<?php

namespace App\Services\Filters;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;

class PresentationPermissionsFilter extends VisibilityFilter implements \App\Interfaces\VisibilityInterface
{
    protected Video $video;
    protected Collection $permissions;

    public function __construct(Video $video)
    {
        // Load all related permissions (HasMany → Collection)
        $this->video = $video->loadMissing('status');
        $this->permissions = $this->video->status;
    }

    public function cast(): void
    {
        // Map permission_id values to names
        $map = [
            1 => 'dsv',
            2 => 'dsv_staff',
            3 => 'custom',
            4 => 'public',
        ];

        // Default type if none found
        $permissionType = 'custom';

        foreach ($this->permissions as $permission) {
            $id = $permission->permission_id ?? null;
            if ($id && isset($map[$id])) {
                $permissionType = $map[$id];
                break; // take the first match
            }
        }

        $this->video->setAttribute('permission_type', $permissionType);
    }
}
