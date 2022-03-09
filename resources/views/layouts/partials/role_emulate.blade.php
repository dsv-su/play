<!-- Role Emulate for Admins - child view - will inherit all data available in the parent view-->
<style>
    .custom-select{
        color: #FFFFFF;
        background-color: #002f5f;
        -webkit-appearance: button;
    }
</style>
<form id="roleform" class="form-inline" method="post" action="{{route('emulateUser')}}">
    @csrf
    <label class="my-1 mr-2" for="role">{{app()->make('play_user') ?? 'Not logged in'}}</label>
    <select class="custom-select my-1 mr-sm-2" id="role" name="role" >
        <option @if(app()->make('play_role') == 'Administrator') selected @endif value="Administrator">Administrator</option>
        <option @if(app()->make('play_role') == 'Courseadmin') selected @endif value="Courseadmin">CourseAdmin</option>
        <option @if(app()->make('play_role') == 'Uploader') selected @endif value="Uploader">Uploader</option>
        <option @if(app()->make('play_role') == 'Staff') selected @endif value="Staff">Staff</option>
        <option @if(app()->make('play_role') == 'Student1') selected @endif value="Student1">Student 1</option>
        <option @if(app()->make('play_role') == 'Student2') selected @endif value="Student2">Student 2</option>
        <option @if(app()->make('play_role') == 'Student3') selected @endif value="Student3">Student 3</option>
    </select>

</form>
