<div x-data="{ open: false, role: '{{ app()->make('play_role') }}' }" class="relative inline-block">
    <button type="button" @click="open = !open">
        {{ app()->make('play_user') ?? 'Not logged in' }}
    </button>

    <form
        x-ref="form"
        x-show="open"
        x-transition
        @click.outside="open = false"
        method="POST"
        action="{{ route('admin.emulate') }}"
        class="absolute right-0 z-30 mt-2 flex flex-wrap items-center gap-3 bg-gray-900 border border-gray-700 p-4 rounded-lg shadow-lg">
        @csrf

        <select
            id="role"
            name="role"
            x-model="role"
            @change="if (role !== 'custom') $refs.form.submit()"
            class="rounded-md border-gray-600 bg-gray-800 text-gray-100 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
            @foreach (['Administrator', 'Courseadmin', 'Uploader', 'Staff', 'Student1', 'Student2', 'Student3', 'custom'] as $role)
                <option value="{{ $role }}" @selected(app()->make('play_role') === $role)>
                    {{ $role === 'Courseadmin' ? 'CourseAdmin' : ($role === 'custom' ? 'Custom' : $role) }}
                </option>
            @endforeach
        </select>

        <div x-show="role === 'custom'" x-transition class="w-full md:w-auto">
            <div class="flex flex-col sm:flex-row items-center gap-2 mt-2">
                <livewire:admin.custom-input />
                <button type="submit"
                        class="rounded-md border border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-white px-4 py-2 text-sm transition-colors">
                    {{ __('Change') }}
                </button>
            </div>
        </div>
    </form>
</div>

