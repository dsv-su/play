<!-- Layout buttons -->
<span class="custom-control-inline" data-toggle="tooltip"
      title="{{__("Grid layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$grid}}')"
                    @if($videoformat == 'grid') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-table-cells-large"></i>
            </button>
        </span>
<span class="custom-control-inline" data-toggle="tooltip"
      title="{{__("Table layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$table}}')"
                    @if($videoformat == 'table') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-table-list"></i>
            </button>
        </span>
<span class="custom-control-inline" data-toggle="tooltip"
      title="{{__("List layout")}}">
            <button class="btn btn-outline-primary" wire:click="videoformat('{{$list}}')"
                    @if($videoformat == 'list') style="background-color: blue; !important; color: white; !important;" @endif>
                <i class="fa-solid fa-list"></i>
            </button>
        </span>
<!-- end layout buttons -->
