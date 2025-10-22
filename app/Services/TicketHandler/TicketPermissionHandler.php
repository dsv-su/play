<?php

namespace App\Services\TicketHandler;

use App\Models\Video;

class TicketPermissionHandler
{
    public function __construct(protected Entitlement $entitlement) {}

    /**
     * Decides whether to issue a ticket.
     * Flow:
     *  1) Set presentation permission_id on the video (fallback to 1).
     *  2) If default (1), allow course setting to override.
     *  3) If entitlement validates for the final permission_id → issue token.
     *  4) Otherwise, evaluate exception rules (individuals, course-individuals, course-admin, admin).
     *  5) If any exception grants a ticket → issue token; else return ''.
     *
     * @return mixed TokenIssuer::issue() result, or '' when not allowed.
     */
    public function issue(Video $video, array $providedEntitlements = [])
    {
        // 1) Presentation setting → sets ticket_permission_id on $this->video
        (new PresentationTicket($video))->cast();

        // 2) If default (1), let course setting potentially override permission_id
        if ((int) ($video->ticket_permission_id ?? 1) === 1) {
            (new CourseSettingTicket($video))->cast();
        }

        // 3) Entitlement validation for the (possibly overridden) permission_id
        $permissionId   = (int) ($video->ticket_permission_id ?? 1);
        if ($this->entitlement->validate($permissionId, $providedEntitlements)) {
            return (new TokenIssuer($video))->issue();
        }

        // 4) Exceptions/grants (set $video->ticket = true if matched)
        (new PresentationIndividualTicket($video))->cast();
        (new CourseIndividualTicket($video))->cast();
        (new CourseAdminTicket($video))->cast();
        (new AdminTicket($video))->cast();

        // 5) Final decision
        return $video->getAttribute('ticket') === true
            ? (new TokenIssuer($video))->issue()
            : '';
    }
}

