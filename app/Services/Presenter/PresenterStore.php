<?php

declare(strict_types=1);

namespace App\Services\Presenter;

use App\Models\IndividualPermission;
use App\Models\Presenter;
use App\Models\Video;
use App\Services\Ldap\SukatUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PresenterStore
{
    /**
     * Sync presenters for a video from request input:
     * expects an array in `package.presenters` containing either SUKAT usernames or external presenter names.
     */
    public function presenter($request, Video $video): void
    {
        $raw = $request->input('package.presenters', []);
        $userInputs = $this->normalizeList($raw);

        if (empty($userInputs)) {
            // no presenters => clear associations
            $video->presenters()->sync([]);
            return;
        }

        DB::transaction(function () use ($userInputs, $video) {
            $presenterIds = [];

            foreach ($userInputs as $value) {
                //Try SUKAT first
                $ldapUser = SukatUser::findBy('uid', $value);

                if ($ldapUser) {
                    //LDAP-backed presenter (unique on username)
                    $presenter = Presenter::updateOrCreate(
                        ['username' => $value],
                        [
                            'username'    => $value,
                            'name'        => $ldapUser->getFirstAttribute('cn'),
                            'description' => 'sukat',
                        ]
                    );

                    //Ensure edit permission for this SUKAT user on this video
                    IndividualPermission::firstOrCreate(
                        [
                            'video_id' => $video->id,
                            'username' => $value,
                        ],
                        [
                            'name'       => $ldapUser->getFirstAttribute('cn'),
                            'permission' => 'edit',
                        ]
                    );
                } else {
                    //External presenter: we can’t rely on username, so upsert by (name, description)
                    $presenter = Presenter::updateOrCreate(
                        [
                            'name'        => $value,
                            'description' => 'external',
                        ],
                        [
                            // keep username null for externals
                            'username'    => null,
                            'name'        => $value,
                            'description' => 'external',
                        ]
                    );
                }

                $presenterIds[] = $presenter->id;
            }

            // Finalize associations
            $video->presenters()->sync($presenterIds);
        });
    }

    /**
     * Normalize input to a unique, trimmed list (drop null/empty).
     *
     * @param mixed $raw
     * @return array<int, string>
     */
    private function normalizeList($raw): array
    {
        $items = Arr::wrap($raw);

        $items = array_map(
            static fn($v) => is_string($v) ? trim($v) : '',
            $items
        );

        $items = array_filter($items, static fn($v) => $v !== '');

        // de-duplicate while preserving order
        return array_values(array_unique($items));
    }
}
