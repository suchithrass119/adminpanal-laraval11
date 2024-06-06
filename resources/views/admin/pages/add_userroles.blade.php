@extends('admin.layout.master')
@section('content')
<style>
    .disabled
    {
        pointer-events: none !important;
        background-color: beige !important;
    }
    .padding-class-50{
        padding-left: 50px;
        padding-right: 50px;
    }
</style>
<div class='container-fluid'>
    <div class="card">
        <div class="card-header">
            <h4>Add User Roles</h4>
        </div>
        <div class="card-body padding-class-50">
        <form class="form-horizontal" id="userroleform">
            <div class="box-body">
                <div class="form-group row justify-content-md-center">
                    <div class="col-md-12">
                    <label for="userid" class="col control-label">Select User</label>
                        <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="userid" class="form-control" id="userid" onchange="loadroles()">
                            <option value="0">Please Select</option>
                            @foreach ($users as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row justify-content-md-center">
                    <div class="col-md-12">
                    <label for="check" class="col control-label">Select Role</label>
                        <div class="col-md-12">
                            <table id="check" class="responsive" width="100%">
                                <tr><input type="checkbox" name="role" value="0" id="check" onclick="selectall()">
                                    <label for="name">Select All/Deselect All</label></tr>
                                <tr>
                                    @for($i=0;$i<=count($roles)-1;$i++) @if(strlen($roles[$i]['role_name'])>25)
                                        @php
                                        $temp=substr($roles[$i]['role_name'],0,25).'...';
                                        @endphp
                                        @else
                                        @php
                                        $temp=$roles[$i]['role_name'];
                                        @endphp
                                        @endif
                                        @if(($i%3)==0)
                                        <td>
                                           
                                            <input type="checkbox" name="roleid[]" value="{{ $roles[$i]['role_id'] }}" id="{{ $roles[$i]['role_id'] }}" class="select">
                                            <label for="{{ $roles[$i]['role_id'] }}" title="{{ $roles[$i]['role_name'] }}">{{ $temp }}</label>
                                        </td>
                                        @elseif(($i%3)==1)
                                        <td>
                                        <input type="checkbox" name="roleid[]" value="{{ $roles[$i]['role_id'] }}" id="{{ $roles[$i]['role_id'] }}" class="select">
                                        <label for="{{ $roles[$i]['role_id'] }}" title="{{ $roles[$i]['role_name'] }}">{{ $temp }}</label>

                                        </td>
                                        @else
                                        <td>
                                           
                                            <input type="checkbox" name="roleid[]" value="{{ $roles[$i]['role_id'] }}" id="{{ $roles[$i]['role_id'] }}" class="select">
                                            <label for="{{ $roles[$i]['role_id'] }}" title="{{ $roles[$i]['role_name'] }}">{{ $temp }}</label>

                                        </td>
                                </tr>
                                <tr>
                                    @endif
                                    @endfor
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-3  justify-content-md-center">
                <button type="button" class="btn btn-success btn-block" id="user_rolebtn" onclick="save_userrole()">Assign</button>
                </div>
            </div>

        </form>
        </div>
        <!--cardbody-->
    </div>
    <!--card-->

    @push('pagescripts')
    <script type="text/javascript">
    $(document).ready(function() {

        // $.validator.addMethod("valueNotEquals", function(value, element, arg){
        //   return arg != value;
        //  }, "Value must not equal arg.");

        $("#userroleform").validate({
            rules: {
                userid: "required"

            },
            messages: {
                userid: "Please select User"

            }

        });
    });



    function loadroles() {

        var user_id = $("#userid").val();
        $.ajax({
            url: APP_URL + "/admin/add_userroles/" + user_id + "/edit",
            type: 'GET',
            dataType: "json",
            success: function(result) {

                var i = 0;
                $('input:checkbox').each(function() {

                    if (result[i] == $(this).attr('id')) {
                        //alert($(this).attr('id'));
                        $(this).prop('checked', 'checked');
                        i++;
                    } else
                        $(this).prop('checked', false);
                });
                if (user_id == 0) {
                    $("input[name='roleid']:checkbox").prop('checked', false);
                }
            }

        });
    }



    function selectall() {
        //alert($(this).attr('id'));
        var check = $('#check').get(0).checked;
        if (check == true) {
            $('.select').prop('checked', 'checked');
        } else {
            $('.select').prop('checked', false);
        }

    }


    function save_userrole() {

        var checkrole = $("#userroleform").valid();
        if (checkrole) {
            var rolestr = $("#userroleform").serialize();
            //  alert(rolestr);
            $.ajax({
                url: APP_URL + "/admin/add_userroles",
                type: 'POST',
                data: rolestr,
                dataType: "json",
                success: function(result) {
                    $(".demo-box").hide();
                    if (result == 1) {
                        Swal.fire({
                            text: 'Assigned Successfully',
                            title: 'Motor Welfare',
                            priority: 'success'
                        });
                    } else if (result == 0) {
                        Swal.fire({
                            text: 'Error Occured',
                            title: 'Motor Welfare',
                            priority: 'danger'
                        });

                    } else if (result == 2) {
                        Swal.fire({
                            text: 'Assigned Roles are Removed ',
                            title: 'Motor Welfare',
                            priority: 'success'
                        });

                    } else {
                        var error_msgs = "";
                        $.each(result, function(key, value) {
                            error_msgs += '<li>' + value + '</li>';

                        });
                        $(".demo-box").html(error_msgs);
                        $(".demo-box").show();


                    }
                }
            });
        }
    }
    </script>
    @endpush

    @endsection
