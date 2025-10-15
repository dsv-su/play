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
</div>


