@extends('layouts.app')

@section('title', __('FAQ') . ' — ')

@section('content')
    @include('dsvheader')
    @include('navbar.navbar')

    @php
        $commonQuestions = [
            [
                'question' => __('Where can I find my presentations?'),
                'answer' => __('Open Navigation and choose My Presentations. The page lists presentations connected to your courses or account.'),
            ],
            [
                'question' => __('Why can I not open a presentation?'),
                'answer' => __('Access depends on the presentation visibility and your course membership. If you believe you should have access, contact the course teacher.'),
            ],
            [
                'question' => __('How do I switch between light and dark mode?'),
                'answer' => __('Use the theme button in the navigation bar. Your preference is saved in this browser.'),
            ],
            [
                'question' => __('Can I change the language?'),
                'answer' => __('Yes. Use the language selector in the page header to switch between English and Swedish.'),
            ],
        ];

        $roleQuestions = [
            'Student' => [
                [
                    'question' => __('Which presentations can I see?'),
                    'answer' => __('You can see presentations shared with your current courses, as well as public or individually shared presentations.'),
                ],
                [
                    'question' => __('Why is one of my courses missing?'),
                    'answer' => __('Course information is retrieved from Daisy. A newly registered course may take some time to appear; contact student support if it remains missing.'),
                ],
                [
                    'question' => __('Can I download a presentation?'),
                    'answer' => __('A download button is available only when the presenter or course staff has enabled downloads for that presentation.'),
                ],
            ],
            'Staff' => [
                [
                    'question' => __('How do I find presentations for a course I teach?'),
                    'answer' => __('Open My Presentations and select the relevant course. Teaching activities and their presentations are grouped by course.'),
                ],
                [
                    'question' => __('How do I control who can watch a presentation?'),
                    'answer' => __('Edit the presentation and choose its visibility and playback permissions. You can limit access to a course, staff, selected people, or make it public.'),
                ],
                [
                    'question' => __('Can I manage a presentation uploaded by someone else?'),
                    'answer' => __('You can when you have course-administrator or individual management permission. Ask the owner to grant access, or contact Helpdesk if needed.'),
                ],
            ],
            'Uploader' => [
                [
                    'question' => __('How do I upload a presentation manually?'),
                    'answer' => __('Open Manage in the navigation bar and choose Manual Upload. Complete the form from top to bottom as follows:'),
                    'steps' => [
                        [
                            'title' => __('Add presentation details'),
                            'body' => __('Enter the Swedish and English titles, an optional short description, and the recording date. You can also upload a custom thumbnail or allow Playback to generate one from the video.'),
                        ],
                        [
                            'title' => __('Choose visibility and downloads'),
                            'body' => __('Visible presentations are searchable and playable. Private presentations are hidden and cannot be played. Unlisted presentations can be played using their direct link but do not appear in search. Enable downloads only when viewers should be allowed to save the media.'),
                        ],
                        [
                            'title' => __('Associate courses'),
                            'body' => __('Select one or more relevant courses and semesters from those available to your account. Course membership helps determine where the presentation appears and who can find it.'),
                        ],
                        [
                            'title' => __('Review presenters and tags'),
                            'body' => __('Your own account is added as a presenter automatically. Add any co-presenters and useful tags so the presentation is correctly attributed and easier to find.'),
                        ],
                        [
                            'title' => __('Set playback access'),
                            'body' => __('Choose who may watch the presentation and, when needed, grant access to specific people. Visibility controls whether the item is listed, while playback access controls who can open it, so review both settings together.'),
                        ],
                        [
                            'title' => __('Upload the media'),
                            'body' => __('Drag at least one media file into the Media files area or choose it from your computer. Wait until the progress indicator confirms that the upload is complete. Large files are uploaded in smaller parts, so keep the page open and do not save while a file is still transferring.'),
                        ],
                        [
                            'title' => __('Configure subtitles'),
                            'body' => __('Upload existing WebVTT subtitle files and assign their language, or request automatically generated subtitles and select the spoken language. This step is optional, and subtitles can also be managed later.'),
                        ],
                        [
                            'title' => __('Review and save'),
                            'body' => __('Check the complete form and choose Save presentation. The button becomes available after all required fields are valid and at least one media file has finished uploading. Playback validates the information, places the presentation in the processing queue, and returns you to the home page with a confirmation message.'),
                        ],
                    ],
                    'note' => __('After saving, use Pending Presentations to follow processing. The media must be processed before the finished presentation is available, and you will receive an upload progress notification. If the upload or processing appears stuck, contact Helpdesk.'),
                ],
                [
                    'question' => __('Which video files can I upload?'),
                    'answer' => __('Use a standard web video format such as MP4. For reliable processing, H.264 video with AAC audio is recommended.'),
                ],
                [
                    'question' => __('Why is my uploaded presentation still processing?'),
                    'answer' => __('Large files need time to upload and encode. Check Pending Presentations for progress; if processing appears stuck, contact Helpdesk.'),
                ],
                [
                    'question' => __('How do I edit a presentation?'),
                    'answer' => __('Find a presentation you are allowed to manage and choose its Edit action. The edit page lets you update its information, access, media, and subtitles in one place. Follow these steps:'),
                    'steps_label' => __('Presentation editing steps'),
                    'steps' => [
                        [
                            'title' => __('Review presentation details'),
                            'body' => __('Update the Swedish or English title, description, recording date, thumbnail, download setting, visibility, or category. Keep the title clear and check how the selected visibility affects whether the presentation can be found and played.'),
                        ],
                        [
                            'title' => __('Update course associations'),
                            'body' => __('Add or remove the courses and semesters connected to the presentation. Course associations control where it is grouped and can affect which course participants are able to find it.'),
                        ],
                        [
                            'title' => __('Manage presenters and tags'),
                            'body' => __('Add or remove presenters so the correct people are credited, and update tags to improve searching and organisation. Check names carefully before saving.'),
                        ],
                        [
                            'title' => __('Review playback permissions'),
                            'body' => __('Choose the audience allowed to watch the presentation and add individual permissions when specific people need access. Review playback permissions together with visibility: visibility controls discovery, while playback permissions control who may open the presentation.'),
                        ],
                        [
                            'title' => __('Manage video streams'),
                            'body' => __('Review the media streams attached to the presentation. If you replace a stream, wait until the replacement upload has completed before saving or leaving the page.'),
                        ],
                        [
                            'title' => __('Manage subtitles'),
                            'body' => __('Review existing subtitles, remove files that are no longer needed, or upload new WebVTT subtitle files and assign the correct language.'),
                        ],
                        [
                            'title' => __('Save your changes'),
                            'body' => __('Review every section and choose Save presentation in the fixed bar at the bottom of the page. Saving applies all edits made on the page. Choose Cancel if you want to return without applying them.'),
                        ],
                    ],
                    'note_label' => __('Before you leave'),
                    'note' => __('Changes are not applied until you choose Save presentation. Do not leave the page while a replacement stream is uploading. If an Edit action is unavailable, you do not have management permission for that presentation; ask the owner to grant access or contact Helpdesk.'),
                ],
                [
                    'question' => __('How do I create and manage a channel?'),
                    'answer' => __('Open Manage in the navigation bar and choose Manage channel. Channels let you collect related presentations on one shareable page. Follow these steps:'),
                    'steps_label' => __('Channel management steps'),
                    'steps' => [
                        [
                            'title' => __('Create the channel'),
                            'body' => __('Enter a unique channel name. Select Show this channel as a carousel if it should appear on the start page, then choose Create channel. The new channel is selected automatically so you can begin adding presentations.'),
                        ],
                        [
                            'title' => __('Find presentations to add'),
                            'body' => __('Use the list on the right to browse available presentations, grouped by course, or search by presentation title or course. You can add presentations that you own or have individual permission to edit.'),
                        ],
                        [
                            'title' => __('Add and remove presentations'),
                            'body' => __('Choose Add beside a presentation to place it in the channel. Presentations already in the channel appear in the list on the left. Choose Remove to take one out; this removes only its channel assignment and does not delete the presentation.'),
                        ],
                        [
                            'title' => __('Edit channel settings'),
                            'body' => __('Select a channel under Your channels to manage it. Change its name or start-page carousel setting, then choose Save changes. Choose Create another channel when you want to leave the current channel and start a new one.'),
                        ],
                        [
                            'title' => __('Preview and share'),
                            'body' => __('Choose Open channel to preview the public-facing channel page in a new tab. Use Share link to copy its address and send it to viewers. Whether each presentation can be opened still depends on its own visibility and playback permissions.'),
                        ],
                        [
                            'title' => __('Delete a channel'),
                            'body' => __('Select the channel and choose Delete channel, then confirm the warning. Deleting a channel removes all of its presentation assignments and cannot be undone, but it does not delete the presentations themselves.'),
                        ],
                    ],
                    'note_label' => __('Important to know'),
                    'note' => __('Adding a presentation to a channel does not change its category, visibility, playback access, or download settings. Update those settings on the presentation itself. You can manage channels you created; contact Helpdesk if you need access to a channel owned by someone else.'),
                ],
            ],
            'Administrator' => [
                [
                    'question' => __('How do I track and retrieve information about a presentation?'),
                    'answer' => __('Open Admin in the main navigation and select the Presentation tracking section. This tool retrieves a detailed, read-only overview of a presentation from its UUID. Follow these steps:'),
                    'steps_label' => __('Presentation tracking steps'),
                    'steps' => [
                        [
                            'title' => __('Find the presentation UUID'),
                            'body' => __('Locate the presentation in Playback and copy its UUID from the presentation, player, or edit-page URL. Use the internal presentation UUID, not a notification ID, course code, title, or channel address.'),
                        ],
                        [
                            'title' => __('Search for the presentation'),
                            'body' => __('Paste the UUID into the Presentation UUID field and choose Search. If no result is returned, check that the complete UUID was copied and that the presentation has finished processing and still exists.'),
                        ],
                        [
                            'title' => __('Review identity and state'),
                            'body' => __('Confirm the title and internal UUID, then review state, category, origin, creation and update times, duration, visibility, unlisted status, and notification ID. These fields help identify the presentation and its current lifecycle state.'),
                        ],
                        [
                            'title' => __('Inspect activity and metrics'),
                            'body' => __('Review total playbacks and downloads, followed by the dated metrics table. The table shows the metric name, category, value, and recorded date or hour, with a total when metric data is available.'),
                        ],
                        [
                            'title' => __('Check metadata and media'),
                            'body' => __('Review presenters, courses, tags, description, subtitles, and video streams. Stream entries include their IDs, names, and available resolutions; subtitle entries show languages, file paths, and generated-subtitle details when available.'),
                        ],
                        [
                            'title' => __('Verify permissions and access'),
                            'body' => __('Inspect global, video-status, individual, and course-administrator permissions. Compare these records with visibility and unlisted status when investigating why a user can or cannot discover or play the presentation.'),
                        ],
                        [
                            'title' => __('Use raw source data for troubleshooting'),
                            'body' => __('The Raw Sources section shows the stored source data in its original structured form. Use it when checking media references or when the summarised fields do not provide enough detail.'),
                        ],
                    ],
                    'note_label' => __('Troubleshooting tip'),
                    'note' => __('Presentation tracking is read-only and does not change the presentation. Record the UUID, notification ID, state, and relevant permission or stream details before escalating an issue to Helpdesk.'),
                ],
                [
                    'question' => __('Where are application-wide settings managed?'),
                    'answer' => __('Open Admin in the navigation bar. Access is restricted to administrators.'),
                ],
                [
                    'question' => __('How do I create and manage a banner message?'),
                    'answer' => __('Open Admin in the main navigation and select Banners. Banner messages appear below the navigation bar and can announce important information to selected audiences. Follow these steps:'),
                    'steps_label' => __('Banner management steps'),
                    'steps' => [
                        [
                            'title' => __('Write the banner message'),
                            'body' => __('Under Create New Banner, enter the required message content. Keep it short, clear, and action-oriented so it remains easy to read across desktop and mobile screens.'),
                        ],
                        [
                            'title' => __('Add an optional link'),
                            'body' => __('Enter a complete Link URL when the message should lead to more information. Add concise Link Text that explains the destination. Leave both fields empty when the banner does not need an action link.'),
                        ],
                        [
                            'title' => __('Choose the audience'),
                            'body' => __('Select Visible for Staff, Visible for Students, or both to target those audiences. Leave both audience options cleared to make an enabled banner general. Administrators can see banners targeted to either Staff or Students.'),
                        ],
                        [
                            'title' => __('Decide whether to publish immediately'),
                            'body' => __('Select Visible to enable the banner as soon as it is created. Leave it cleared to save the banner in a disabled state for later review or publication.'),
                        ],
                        [
                            'title' => __('Create and verify the banner'),
                            'body' => __('Choose Create Banner and confirm that it appears under Existing Banners with the expected message, audience labels, link, and Enabled or Disabled status. If enabled, verify its appearance in the site header for the intended audience.'),
                        ],
                        [
                            'title' => __('Edit, enable, or delete banners'),
                            'body' => __('Use Edit to change the content, link, audience, or visibility and then choose Update Banner. Select the status button to enable or disable a saved banner. Use Delete only when the banner is no longer needed, because deletion cannot be undone.'),
                        ],
                    ],
                    'note_label' => __('Publishing rule'),
                    'note' => __('Only one banner can be enabled at a time. Enabling a banner automatically disables every other banner, so review Existing Banners before publishing a replacement.'),
                ],
                [
                    'question' => __('How can I verify the experience for another role?'),
                    'answer' => __('Use the role selector beside your name to emulate a supported role, then navigate through the site as that user type.'),
                ],
                [
                    'question' => __('Where can I monitor recorder status?'),
                    'answer' => __('Open Recorders in the navigation bar to review connected recorder services and their current status.'),
                ],
            ],
        ];

        // Course administrators have the same upload workflow and guidance as uploaders.
        $roleQuestions['Courseadmin'] = $roleQuestions['Uploader'];

        $roleStyles = match ($role) {
            'Administrator' => ['badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/60 dark:text-violet-300', 'icon' => 'bg-violet-600 shadow-violet-600/20'],
            'Uploader' => ['badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300', 'icon' => 'bg-amber-500 shadow-amber-500/20'],
            'Courseadmin' => ['badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300', 'icon' => 'bg-amber-500 shadow-amber-500/20'],
            'Staff' => ['badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300', 'icon' => 'bg-emerald-600 shadow-emerald-600/20'],
            default => ['badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300', 'icon' => 'bg-blue-600 shadow-blue-600/20'],
        };
    @endphp

    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <section class="relative overflow-hidden rounded-3xl border border-gray-200 bg-gradient-to-br from-blue-50 via-white to-indigo-50 px-6 py-10 shadow-sm dark:border-neutral-800 dark:from-blue-950/40 dark:via-neutral-950 dark:to-indigo-950/30 sm:px-10">
            <div class="absolute -right-20 -top-24 size-72 rounded-full bg-blue-200/40 blur-3xl dark:bg-blue-600/10" aria-hidden="true"></div>
            <div class="relative max-w-2xl">
                <div class="mb-5 flex size-14 items-center justify-center rounded-2xl text-white shadow-lg {{ $roleStyles['icon'] }}" aria-hidden="true">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 1 1 5.83 1c0 2-3 2-3 4"/><path d="M12 18h.01"/></svg>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white sm:text-4xl">{{ __('Frequently asked questions') }}</h1>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $roleStyles['badge'] }}">{{ __($role) }}</span>
                </div>
                <p class="mt-4 text-base leading-7 text-gray-600 dark:text-neutral-300">{{ __('Quick answers about Playback, with guidance selected for your role.') }}</p>
            </div>
        </section>

        @foreach ([
            ['id' => strtolower($role), 'title' => __('For :role', ['role' => __($role)]), 'description' => __('Guidance based on your current access.'), 'questions' => $roleQuestions[$role]],
            ['id' => 'general', 'title' => __('General questions'), 'description' => __('Useful information for everyone using Playback.'), 'questions' => $commonQuestions],
        ] as $section)
            <section class="mt-10" aria-labelledby="faq-section-{{ $loop->index }}">
                <h2 id="faq-section-{{ $loop->index }}" class="text-xl font-semibold text-gray-950 dark:text-white">{{ $section['title'] }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ $section['description'] }}</p>

                <div class="mt-5 space-y-3">
                    @foreach ($section['questions'] as $item)
                        @php($faqId = 'faq-' . $section['id'] . '-' . $loop->iteration)
                        <details id="{{ $faqId }}" class="group scroll-mt-6 rounded-2xl border border-gray-200 bg-white shadow-sm open:ring-1 open:ring-blue-100 dark:border-neutral-800 dark:bg-neutral-950 dark:open:ring-blue-950">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-5 text-left font-medium text-gray-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-600 dark:text-white dark:focus-visible:ring-blue-400 sm:px-6 [&::-webkit-details-marker]:hidden">
                                <span>{{ $item['question'] }}</span>
                                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-transform group-open:rotate-45 dark:bg-neutral-800 dark:text-neutral-300" aria-hidden="true">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                </span>
                            </summary>
                            <div class="border-t border-gray-100 px-5 py-5 text-sm leading-7 text-gray-600 dark:border-neutral-800 dark:text-neutral-300 sm:px-6">
                                <p>{{ $item['answer'] }}</p>
                                @if (! empty($item['steps']))
                                    <ol class="mt-5 space-y-3" aria-label="{{ $item['steps_label'] ?? __('Upload steps') }}">
                                        @foreach ($item['steps'] as $step)
                                            <li class="flex gap-4 rounded-xl border border-gray-200 bg-gray-50/70 p-4 dark:border-neutral-700 dark:bg-neutral-900/70">
                                                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white shadow-sm shadow-blue-600/20" aria-hidden="true">
                                                    {{ $loop->iteration }}
                                                </span>
                                                <div class="min-w-0 pt-0.5">
                                                    <h3 class="font-semibold leading-6 text-gray-950 dark:text-white">{{ $step['title'] }}</h3>
                                                    <p class="mt-1 leading-6 text-gray-600 dark:text-neutral-300">{{ $step['body'] }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                                @if (! empty($item['note']))
                                    <aside class="mt-5 flex gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4 text-blue-950 dark:border-blue-900 dark:bg-blue-950/40 dark:text-blue-100">
                                        <svg class="mt-0.5 size-5 shrink-0 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                                        <div>
                                            <h3 class="font-semibold">{{ $item['note_label'] ?? __('After saving') }}</h3>
                                            <p class="mt-1 leading-6 text-blue-900 dark:text-blue-200">{{ $item['note'] }}</p>
                                        </div>
                                    </aside>
                                @endif
                                <div class="mt-5 flex justify-end border-t border-gray-100 pt-4 dark:border-neutral-800"
                                     x-data="{
                                         copied: false,
                                         copyLink() {
                                             const url = new URL(window.location.href);
                                             url.hash = @js($faqId);
                                             window.history.replaceState(null, '', url);
                                             navigator.clipboard.writeText(url.toString()).then(() => {
                                                 this.copied = true;
                                                 window.setTimeout(() => this.copied = false, 2000);
                                             });
                                         }
                                     }">
                                    <button type="button" @click="copyLink()"
                                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:border-blue-700 dark:hover:bg-blue-950/40 dark:hover:text-blue-300">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                        <span x-text="copied ? @js(__('Link copied!')) : @js(__('Copy link to this answer'))">{{ __('Copy link to this answer') }}</span>
                                    </button>
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>

    @include('layouts.darktoggler')

    @push('scripts')
        <script>
            (() => {
                const openLinkedAnswer = () => {
                    const id = decodeURIComponent(window.location.hash.slice(1));
                    if (!id) return;

                    const answer = document.getElementById(id);
                    if (!(answer instanceof HTMLDetailsElement)) return;

                    answer.open = true;
                    window.requestAnimationFrame(() => answer.scrollIntoView({ behavior: 'smooth', block: 'start' }));
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', openLinkedAnswer, { once: true });
                } else {
                    openLinkedAnswer();
                }

                window.addEventListener('hashchange', openLinkedAnswer);
            })();
        </script>
    @endpush
@endsection
