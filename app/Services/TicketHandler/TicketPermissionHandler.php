<?php

namespace App\Services\TicketHandler;

use App\Models\Video;

class TicketPermissionHandler
{
    protected Video $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

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
    public function issue()
    {
        // 1) Presentation setting → sets ticket_permission_id on $this->video
        (new PresentationTicket($this->video))->cast();

        // 2) If default (1), let course setting potentially override permission_id
        if ((int) ($this->video->ticket_permission_id ?? 1) === 1) {
            (new CourseSettingTicket($this->video))->cast();
        }

        // 3) Entitlement validation for the (possibly overridden) permission_id
        $permissionId   = (int) ($this->video->ticket_permission_id ?? 1);
        $userEntitlement = new Entitlement();

        if ($userEntitlement->validate($permissionId)) {
            // Issue token; do NOT call fresh() or you will lose computed attributes
            $token = new TokenIssuer($this->video);
            return $token->issue();
        }

        // 4) Exceptions/grants (set $video->ticket = true if matched)
        (new PresentationIndividualTicket($this->video))->cast();
        (new CourseIndividualTicket($this->video))->cast();
        (new CourseAdminTicket($this->video))->cast();
        (new AdminTicket($this->video))->cast();

        // 5) Final decision
        if ($this->video->getAttribute('ticket') === true) {
            $token = new TokenIssuer($this->video);
            return $token->issue();
        }

        // No ticket
        return '';
    }
}

