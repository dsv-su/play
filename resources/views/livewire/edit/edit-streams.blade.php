<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
    @foreach ($streams as $key => $stream)
        <!-- Card -->
            <div class="w-full">
                <div class="flex flex-col h-full rounded overflow-hidden shadow bg-white dark:bg-gray-900 border border-gray-200/70 dark:border-gray-800">
                    <!-- Media -->
                    @include('livewire.edit.partials.form.stream-img')

                    <!-- Card body -->
                    @include('livewire.edit.partials.form.stream-card')
                </div>
            </div>
            <!-- /Card -->
        @endforeach
    </div>
    <!-- -->
{{--}}
    <div id="accordion-collapse" data-accordion="collapse" class="mt-2 rounded-lg border border-gray-200 overflow-hidden shadow-xs">
        <h2 id="accordion-collapse-heading-1">
            <button type="button"
                    class="flex items-center justify-between w-full p-3 font-medium rtl:text-right text-body
                    rounded-t-base border border-t-0 border-x-0 border-b-default hover:text-heading hover:bg-neutral-secondary-medium gap-3"
                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                <span>{{__("Moore options")}}</span>
                <svg data-accordion-icon class="w-5 h-5 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7"/></svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden border border-s-0 border-e-0 border-t-0 border-b-default" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-4 md:p-5">
                <p class="mb-2 text-body">Replace a stream</p>
                <p class="text-body"></p>
            </div>
        </div>

    </div>
{{--}}
    <!-- -->
</div>


