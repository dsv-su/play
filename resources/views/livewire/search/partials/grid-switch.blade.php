{{--}} // deactivated 2026-01-14
<div class="mr-4 flex justify-end w-full">
    <div
        x-data="{ switchOn: @entangle('switchOn').live }"
        class="inline-flex items-center space-x-2">

        <input type="checkbox" class="hidden" x-model="switchOn">

        <button
            x-ref="switchButton"
            type="button"
            @click="switchOn = !switchOn"
            :class="switchOn ? 'bg-neutral-900' : 'bg-neutral-200'"
            class="relative inline-flex h-4 py-0.5 rounded-full focus:outline-none w-6">
            <span
                :class="switchOn ? 'translate-x-[10px]' : 'translate-x-0.5'"
                class="w-3 h-3 duration-200 ease-in-out bg-white rounded-full shadow-md"
            ></span>
        </button>

        <label
            @click="$refs.switchButton.click(); $refs.switchButton.focus()"
            :class="{ 'text-neutral-900': switchOn, 'text-gray-400': !switchOn }"
            class="text-xs font-medium select-none truncate">
            {{__("Grid")}}
        </label>
    </div>
</div>
{{--}}
