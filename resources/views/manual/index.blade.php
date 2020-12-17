@extends('layouts.suplay')
@section('content')
    <div class="container lst">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                Fel på inmatningen!.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h3>Manuell uppladdning</h3>
            <form method="post" action="{{route('manual_store')}}" enctype="multipart/form-data">
                @csrf
          <div class="border border p-5">
            <div class="form-row">
                <div class="col-5">
                    <label>Title</label>
                    <input class="form-control form-control-sm" name="title" type="text">
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                </div>
                <div class="col">
                    <label>Presentator</label>
                    <input class="form-control form-control-sm" name="presenter[]" type="text">
                </div>
            </div>
            <!--Second row -->
            <div class="form-row">
                <div class="col-2">
                    <label>Creation Date</label>
                    <input class="form-control form-control-sm" name="created" type="date">
                    <small class="text-danger">{{ $errors->first('created') }}</small>
                </div>
                <div class="col">
                    <label>Belongs to course</label>
                    <input class="form-control form-control-sm" name="course[]" type="text">
                </div>
                <div class="col">
                    <label>Additional course</label>
                    <input class="form-control form-control-sm" name="course[]" type="text">
                </div>
            </div>
            <!--Third row -->
            <div class="form-row">
                <div class="col-2">
                    <label>Tag</label>
                    <input class="form-control form-control-sm" name="tag[]" type="text">
                </div>
                <div class="col-2">
                    <label>Tag</label>
                    <input class="form-control form-control-sm" name="tag[]" type="text">
                </div>
                <div class="col-2">
                    <label>Tag</label>
                    <input class="form-control form-control-sm" name="tag[]" type="text">
                </div>
                <div class="col-4">
                    <label>Thumb</label>
                    <input class="form-control form-control-sm" name="thumb" type="text">
                    <div class="text-danger">{{ $errors->first('thumb') }}</div>
                </div>
            </div>
          </div>

            <div class="input-group filecont control-group lst increment" >
                <input type="file" name="filenames[]" class="form-control">
                <div class="input-group-btn">
                    <button class="btn btn-success" type="button"><i class="fas fa-plus"></i> Lägg till</button>
                </div>
            </div>
            <div class="fileupload">
                <div class="filecont control-group lst input-group" style="margin-top:10px">
                    <input type="file" name="filenames[]" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn btn-danger" type="button"><i class="fas fa-minus"></i> Ta bort</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success" style="margin-top:10px">Ladda upp</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(".btn-success").click(function(){
                var upload = $(".fileupload").html();
                $(".increment").after(upload);
            });
            $("body").on("click",".btn-danger",function(){
                $(this).parents(".filecont").remove();
            });
        });
    </script>

@endsection

