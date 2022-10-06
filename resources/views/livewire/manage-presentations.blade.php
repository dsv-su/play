<div>
    @include('livewire.layoutbuttons')
    <div class="card border border-primary mt-3" style="border-width:3px !important; border-radius: 10px !important; padding: 25px !important; z-index: 900; !important;">
        <div class="container">
            <div class="d-flex row justify-content-center align-items-start">
                <div class="col-12 col-sm">
                    <form wire:submit.prevent="filter"
                          class="form-inline manage-filter d-flex justify-content-sm-center"
                          method="GET" id="manage-filter" role="search">
                        <label for="manage-filter" class="sr-only">{{ __("Type to search") }}</label>
                        <input class="form-control w-100" type="search"
                               wire:model.debounce.1000ms="filterTerm"
                               id="manage-filter-text" autocomplete="off"
                               aria-haspopup="true"
                               placeholder="{{ __("Type to search") }}"
                               style="font-size: 100% !important;"
                               aria-labelledby="manage-filter">
                    </form>
                </div>
            </div>
        </div>

        <!-- Dropdown filter -->
        @include('livewire.filter.dropdownfilter')

    </div>
    <!-- Loading spinners -->
    <div wire:loading wire:target="loadUncat">
        @include('livewire.modals.loading_spinner')
    </div>
    <div wire:loading.delay wire:target="filterTerm">
        @include('livewire.modals.loading_spinner')
    </div>
    <div wire:loading.delay wire:target="resetFilter">
        @include('livewire.modals.reset_spinner')
    </div>
    <!-- end loading spinners -->

    <div class="card">
        <div id="headingOne">
            <h2 class="col mt-4" style="line-height: 1.5em;">
                <span class="badge badge-primary ml-2 mb-2" data-toggle="tooltip" title="{{__("Number of presentations")}}">{{$uncatcounter}}</span>
                <span style="color:blue;">{{__("Uncategorized presentations")}}</span>
            </h2>
            @if($videoformat == 'table')
                <!-- Check all -->
                <div class="form-check">
                    <input wire:click="checkAll" type="checkbox" class="check" id="checkAll"
                           @if($allChecked) checked
                    > {{__("Uncheck All")}}
                    @else
                        > {{__("Check All")}}
                    @endif
                </div>
            @endif
            <div>
                @include('home.videolayout', ['videos' => $uncat_videos])
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        Livewire.hook('message.processed', (message, component) => {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $("input[type='checkbox'][name='bulkedit']").each(function () {
                    handleSelected($(this));
                });

                $("input[type='checkbox'][name='bulkedit']").on('change', function () {
                    handleSelected($(this));
                });
            })
        })
        function handleSelected(checkbox) {
            let checked = checkbox.prop('checked');
            let id = checkbox.attr('data-id');
            if (checked) {
                if (!$('#bulkediting').find('input[name="bulkids[]"][value="'+id+'"]').length) {
                    $('#bulkediting').append('<input type="hidden" name="bulkids[]" value=' + id + '>');
                }
            } else {
                $('#bulkediting').find('input[value="' + id + '"]').remove();
            }
            let n = $('#bulkediting').find('input[name="bulkids[]"]').length;
            if (n) {
                $('#bulkediting input[type="submit"]').val("{{__("Edit")}}" + ' ' + n + ' ' + "{{__("selected presentations")}}");
                $('#bulkcontainer').show();
            } else {
                $('#bulkcontainer').hide();
            }
        }
    });
</script>
