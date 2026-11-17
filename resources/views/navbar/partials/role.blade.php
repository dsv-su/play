<div x-data="{ open: false, role: @js(app()->make('play_role')) }" class="role-switcher"
     @keydown.escape.stop="open = false; $refs.trigger.focus()"
     @click.outside="open = false"
     @focusout="if (!$el.contains($event.relatedTarget)) open = false">
    <button x-ref="trigger" type="button" class="role-switcher-trigger"
            @click="open = !open; if (open) $nextTick(() => $refs.roleSelect.focus())"
            :aria-expanded="open" aria-controls="role-switcher-panel">
        {{ app()->make('play_role') ?? __('Not logged in') }}
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true" :class="{ 'rotate-180': open }"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
    </button>

    <form id="role-switcher-panel" style="display: none;" x-ref="form" x-show="open"
          x-transition.opacity.duration.150ms method="POST" action="{{ route('admin.emulate') }}"
          class="role-switcher-panel" aria-labelledby="role-switcher-heading">
        @csrf
        <p id="role-switcher-heading" class="role-switcher-heading">{{ __('Switch role') }}</p>
        <label for="role" class="role-switcher-label">{{ __('Role') }}</label>
        <select id="role" x-ref="roleSelect" name="role" x-model="role"
                @change="if ($event.target.value !== 'custom') $refs.form.submit()"
                aria-describedby="role-switcher-help" class="role-switcher-select">
            @foreach (['Administrator', 'Courseadmin', 'Uploader', 'Staff', 'Student1', 'Student2', 'Student3', 'custom'] as $availableRole)
                <option value="{{ $availableRole }}" @selected(app()->make('play_role') === $availableRole)>
                    {{ $availableRole === 'Courseadmin' ? 'CourseAdmin' : ($availableRole === 'custom' ? __('Custom') : $availableRole) }}
                </option>
            @endforeach
        </select>
        <p id="role-switcher-help" class="role-switcher-help">{{ __('Selecting a role reloads the page. Choose Custom to select a user.') }}</p>
        <div x-show="role === 'custom'" class="role-switcher-custom">
            <label for="custom-user" class="role-switcher-label">{{ __('Custom user') }}</label>
            <livewire:admin.custom-input />
            <button type="submit" class="role-switcher-submit">{{ __('Change') }}</button>
        </div>
    </form>
</div>
