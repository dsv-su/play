<!-- Save bar -->
<div class="container-fluid px-2 play_savebar" id="bulkcontainer" style="display: none;">
    <div class="bar p-3 su-header-container__primary">
        <div class="d-flex row no-gutters justify-content-end">
            {{--}}
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center">
                    <span class="d-block" id="bulk">{{__("Bulk edit")}}</span>
                </div>
            </div>
            {{--}}
            <div class="col-md-4">
                <form class="d-flex flex-column justify-content-end" id="bulkediting" method="post" action="{{route('edit.bulk.show')}}">
                    @csrf
                    @method('GET')
                    <input type="submit" class="btn btn-lg btn-outline-light m-auto"><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end save bar -->
