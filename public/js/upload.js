$(document).ready(function() {
    $('.datepicker').datepicker({
        language:'sv',
        weekStart: 1,
        todayHighlight: true
    });
    var ent = 0;
    $(document).on('change', '#permission', function(){
        var data = $(this).val();
        if(data == 'true') {
            var html = '';
            html += '<input type="text" class="form-control" id="input_entitlement" name="entitlement"  value="urn:mace:swami.se:gmai:dsv-user:staff;urn:mace:swami.se:gmai:dsv-user:student">';
            $('#entitlement').append(html);
            ent++;
        }
        else if (data == 'false' && ent==1) {
            $("#input_entitlement").remove();
            ent = 0;
        }
    });

    var count = 2;
    $(document).on('click', '.presenteradd', function(){
        var html = '';
        html += '<tr>';
        html += '<td><input type="text" name="presenters[]" class="form-control form-control-sm" placeholder="SU Användarnamn" required></td>';
        html += '<td><button type="button" name="presenterremove" class="btn btn-outline-danger btn-sm presenterremove"><i class="fas fa-user-times"></i><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
        $('#presenter_table').append(html);
    });
    $(document).on('click', '.presenterremove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.courseadd', function(){
        var html = '';
        html += '<tr>';
        html += '<td><input type="text" name="courses[]" class="form-control form-control-sm" placeholder="Kursnamn" required></td>';
        html += '<td><button type="button" name="courseremove" class="btn btn-outline-danger btn-sm courseremove"><i class="fas fa-chalkboard"></i></button></td></tr>';
        $('#course_table').append(html);
    });
    $(document).on('click', '.courseremove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.tagadd', function(){
        var html = '';
        html += '<tr>';
        html += '<td><input type="text" name="tags[]" class="form-control form-control-sm" placeholder="Tagg" required></td>';
        html += '<td><button type="button" name="tagremove" class="btn btn-outline-danger btn-sm tagremove"><i class="fas fa-tags"></i></button></td></tr>';
        $('#tag_table').append(html);
    });
    $(document).on('click', '.tagremove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.mediaadd', function(){
        if (count<5){
            var html = '';
            html += '<tr>';
            html += '<td>Sekundärmedia</td>';
            html += '<td><input type="file" name="filenames[]" class="form-control form-control-sm"  required></td>';
            html += '<td><button type="button" name="mediaremove" class="btn btn-outline-danger btn-sm mediaremove"><i class="far fa-file-video"></i></button></td></tr>';
            count++;
            $('#media_table').append(html);
        }
        else {
            $('#max').modal('show');
        }
    });
    $(document).on('click', '.mediaremove', function(){
        count--;
        $(this).closest('tr').remove();
    });

});
