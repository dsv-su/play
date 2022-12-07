<!-- Save bar -->
<div class="container-fluid px-2 play_savebar" id="bulkcontainer" style="display: none;">
    <div class="d-flex justify-content-center row">
        <div class="col-md-12">
            <div class="bar p-3 bg-white">

                <div class="d-flex row no-gutters">
                    <div class="col-md-4 border-right">
                        <div class="d-flex flex-column align-items-center">
                            <span class="d-block" id="bulk">{{__("Bulk edit")}}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form class="d-flex flex-column justify-content-end" id="bulkediting" method="post" action="{{route('edit.bulk.show')}}">
                            @csrf
                            @method('GET')
                            <input type="submit" class="btn btn-lg btn-outline-primary m-auto"><br><br>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- end save bar -->
