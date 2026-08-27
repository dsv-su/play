@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')

    @php
        $permissionLabel = static fn ($permission) => match ((string) $permission) {
            '1', 'edit', 'write' => __('Edit'),
            '2', 'admin', 'manage' => __('Manage'),
            '0', 'view', 'read' => __('View'),
            default => ucfirst((string) $permission),
        };
    @endphp

    <main class="mx-auto max-w-screen-xl space-y-6 px-4 py-6 sm:px-6 lg:px-8 md:pb-10">
        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-black/[0.02] dark:border-neutral-800 dark:bg-neutral-950 dark:ring-white/[0.04]">
            <div class="relative overflow-hidden border-b border-gray-200 bg-gradient-to-br from-blue-50 via-white to-indigo-50 px-6 py-8 dark:border-neutral-800 dark:from-blue-950/40 dark:via-neutral-950 dark:to-indigo-950/30 sm:px-8">
                <div class="absolute -right-16 -top-20 size-56 rounded-full bg-blue-200/40 blur-3xl dark:bg-blue-600/10" aria-hidden="true"></div>
                <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex size-16 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-semibold text-white shadow-lg shadow-blue-600/20">
                        {{ mb_strtoupper(mb_substr((string) app('play_user'), 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ __('Your profile') }}</p>
                        <h1 class="mt-1 truncate text-2xl font-semibold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{ app('play_user') }}</h1>
                        <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                            <span class="rounded-full bg-white/80 px-3 py-1 font-medium text-gray-700 ring-1 ring-gray-200 dark:bg-neutral-900/80 dark:text-neutral-200 dark:ring-neutral-700">{{ app('play_role') }}</span>
                            <span class="text-gray-500 dark:text-neutral-400">{{ app('play_username') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('Presentation activity') }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('An overview of presentations where you are listed as a presenter.') }}</p>
                <dl class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-3 xl:grid-cols-6">
                    @foreach ([
                        ['key' => 'presentations', 'label' => __('Presented videos'), 'color' => 'text-blue-600 dark:text-blue-400'],
                        ['key' => 'published', 'label' => __('Published'), 'color' => 'text-emerald-600 dark:text-emerald-400'],
                        ['key' => 'unlisted', 'label' => __('Unlisted'), 'color' => 'text-amber-600 dark:text-amber-400'],
                        ['key' => 'courses', 'label' => __('Courses'), 'color' => 'text-violet-600 dark:text-violet-400'],
                        ['key' => 'playbacks', 'label' => __('Playbacks'), 'color' => 'text-cyan-600 dark:text-cyan-400'],
                        ['key' => 'downloads', 'label' => __('Downloads'), 'color' => 'text-rose-600 dark:text-rose-400'],
                    ] as $stat)
                        <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4 dark:border-neutral-800 dark:bg-neutral-900/70">
                            <dd class="text-2xl font-semibold tabular-nums {{ $stat['color'] }}">{{ number_format($profileStats[$stat['key']]) }}</dd>
                            <dt class="mt-1 text-xs font-medium text-gray-500 dark:text-neutral-400">{{ $stat['label'] }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>
        </section>
        
        @if ($daisyStats['courses'] > 0)
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] dark:border-neutral-800 dark:bg-neutral-950 dark:ring-white/[0.04] sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('Daisy study profile') }}</h2>
                            <span class="rounded-full bg-sky-100 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-sky-700 dark:bg-sky-950/60 dark:text-sky-300">Daisy</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('Your current course information from Daisy.') }}</p>
                    </div>
                    @if ($daisyStats['semester_labels']->isNotEmpty())
                        <div class="flex flex-wrap gap-1.5" aria-label="{{ __('Active semesters') }}">
                            @foreach ($daisyStats['semester_labels'] as $semester)
                                <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 dark:bg-neutral-800 dark:text-neutral-300">{{ $semester }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <dl class="mt-5 grid gap-3 sm:grid-cols-3">
                    @foreach ([
                        ['value' => $daisyStats['courses'], 'label' => __('Active courses')],
                        ['value' => $daisyStats['designations'], 'label' => __('Course designations')],
                        ['value' => $daisyStats['semesters'], 'label' => __('Semesters represented')],
                    ] as $stat)
                        <div class="rounded-xl border border-sky-100 bg-sky-50/60 p-4 dark:border-sky-950 dark:bg-sky-950/20">
                            <dd class="text-2xl font-semibold tabular-nums text-sky-700 dark:text-sky-300">{{ number_format($stat['value']) }}</dd>
                            <dt class="mt-1 text-xs font-medium text-gray-500 dark:text-neutral-400">{{ $stat['label'] }}</dt>
                        </div>
                    @endforeach
                </dl>
            </section>
        @endif

        <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] dark:border-neutral-800 dark:bg-neutral-950 dark:ring-white/[0.04] sm:p-8">
            <div class="max-w-2xl">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('Home page order') }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('Drag the sections into your preferred order, then save your changes.') }}</p>
                @include('cookie.presentation-order')
            </div>
        </section>



        @if ($courseadminPermissions->isNotEmpty() || $individualPermissions->isNotEmpty())
            <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] dark:border-neutral-800 dark:bg-neutral-950 dark:ring-white/[0.04] sm:p-8">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">{{ __('Your permissions') }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-neutral-400">{{ __('Presentation access assigned directly to your account.') }}</p>
                <div class="mt-5 grid gap-4 lg:grid-cols-2">
                    @foreach ([
                        ['title' => __('Course administrator permissions'), 'items' => $courseadminPermissions, 'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300'],
                        ['title' => __('Individual permissions'), 'items' => $individualPermissions, 'badge' => 'bg-violet-100 text-violet-700 dark:bg-violet-950/60 dark:text-violet-300'],
                    ] as $group)
                        @if ($group['items']->isNotEmpty())
                            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-neutral-800">
                                <div class="flex items-center justify-between bg-gray-50 px-4 py-3 dark:bg-neutral-900">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $group['title'] }}</h3>
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $group['badge'] }}">{{ $group['items']->count() }}</span>
                                </div>
                                <ul class="divide-y divide-gray-200 dark:divide-neutral-800">
                                    @foreach ($group['items'] as $permission)
                                        <li class="flex items-center justify-between gap-4 px-4 py-3">
                                            <span class="min-w-0 truncate text-sm text-gray-700 dark:text-neutral-300" title="{{ $permission->video?->title }}">
                                                {{ $permission->video?->title ?? __('Presentation unavailable') }}
                                            </span>
                                            <span class="shrink-0 rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 dark:bg-neutral-800 dark:text-neutral-300">{{ $permissionLabel($permission->permission) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    @include('layouts.darktoggler')
@endsection
