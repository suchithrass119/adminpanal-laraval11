@extends('admin.layout.master')

@section('content')
@push('rolerightstyle')
@endpush
<div class='container-fluid'>
    <div class="card">
        <div class="card-header" style="color: black;">
            <h4>Add Role Right</h4>
        </div>
        <div class="card-body">

            <form class="form-horizontal" id="rolerightform" autocomplete="off">            <!--form group 1-->
            <div class="form-group row">
                <div class="col-md-6">
                <label for="role_id" class="col control-label">Select Role</label>
                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="role_id" class="form-control" id="role_id" onchange="modulereset()">
                            <option value="">Please Select</option>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                        <label for="module" class="col control-label">Select Module</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="module" class="form-control" id="module" onchange="show_menu()">
                            <option value="">Please Select</option>
                            @foreach ($modules as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!--cardbody-->
    </div>

    <div class="card card">
        <div class="card-header" style="color: black;">
            <h4>Role rights</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table table-bordered table-striped" cellspacing="0" width="100%"
                    style="border: 1px solid #ddd;">
                    <thead>
                        <tr style="border:1px solid #ddd;">
                            <th>Menu Name</th>
                            <th colspan="8">Actions</th>
                            <th>Assign</th>
                        </tr>
                        <thead>
                        <tbody id="menutbl">
                            <tr>
                                <td colspan='10'>No Data </td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
        <!--cardbody-->
    </div>

</div><!-- /.row -->

@push('pagescripts')
<script type="text/javascript">
/*  $("input:checkbox").on('change',function(){
                $(this).val(this.checked?"1":"0");
              });
*/

$.validator.addMethod("valueNotEquals", function(value, element, arg) {
    return arg != value;
}, "Value must not equal arg.");

$("#rolerightform").validate({
    rules: {
        role_id: "required",
        module: "required"
    },
    messages: {
        role_id: "Please select Role",
        module: "Please select Module"
    }

});


function show_menu() {
    var role_id = $("#role_id").val();
    var module_id = $("#module").val();

    $.ajax({
        url: APP_URL + "/admin/add_roleright",
        type: 'GET',
        data: {
            'module_id': module_id,
            'role_id': role_id
        },
        dataType: "json",
        success: function(data) {
            console.log(data);

            $("#menutbl").html('');
            $.each(data, function(i, record) {
                var insert, update, delet, view, index, verify, approve;
                if (data[i].default.insert == '1') {
                    insert = "checked";
                } else {
                    insert = '';
                }
                if (data[i].default.update == '1') {
                    update = "checked";
                } else {
                    update = '';
                }
                if (data[i].default.delete == '1') {
                    delet = "checked";
                } else {
                    delet = '';
                }
                if (data[i].default.view == '1') {
                    view = "checked";
                } else {
                    view = '';
                }
                if (data[i].default.index == '1') {
                    index = "checked";
                } else {
                    index = '';
                }
                if (data[i].default.verify == '1') {
                    verify = "checked";
                } else {
                    verify = '';
                }
                if (data[i].default.approve == '1') {
                    approve = "checked";
                } else {
                    approve = '';
                }
                $("#menutbl").append("<tr id='def_" + data[i].menu_id + "'>" +
                    "<td rowspan='2' style='vertical-align: middle;color:#;'>" + data[i]
                    .menu_name + "<br/>[" + data[i].controller_name + "]</td>" +
                    "<td>Default Action<input type='hidden' class='ctrl_id' value=" + data[i]
                    .controller_id + "></td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.insert + "' " + insert + "> Insert</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.update + "' " + update + "> Update</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.delete + "' " + delet + ">Delete</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.view + "' " + view + ">View</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.index + "' " + index + ">Index</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.verify + "' " + verify + "> Verify</td>" +
                    "<td><input type='checkbox' autocomplete='off' class='default' value='" +
                    data[i].default.approve + "' " + approve + "> Approve</td>" +
                    "<td rowspan='2' style='vertical-align: middle;text-align: center'><button type='button' class='btn btn-success' id=" +
                    data[i].menu_id + " onclick='assign(this.id," + data[i].controller_id +
                    ")'>Assign rights</button></td>" +
                    "</tr>" +
                    "<tr id='oth_" + data[i].menu_id + "' style='border:1px solid #ddd;'>" +
                    "<td>Other Action</td>");
                $.each(data[i].otheractions, function(j, record) {
                    var checked;
                    if (record.status == '1') {
                        checked = "checked";
                    } else {
                        checked = '';
                    }
                    $("#oth_" + data[i].menu_id).append("<td>" +
                        "<input type='checkbox' autocomplete='off' class='other' value='" +
                        record.status + "' id=" + record.controller_action_id + " " +
                        checked + ">" + record.action_name +
                        "</td>");
                });

                $("#menutbl").append("</tr>");
            });

            $("input:checkbox").on('change', function() {
                $(this).val(this.checked ? "1" : "0");
            });
        }
    });



}

function assign(menu_id, controller_id) {

    var role_id = $("#role_id").val();
    var defaultid = $('#def_' + menu_id + ' input:checkbox').map(function() {
        return this.value;
    }).get();
    console.log(defaultid);
    var checked_otherid = [];
    $('#oth_' + menu_id + ' input:checkbox:checked').each(function() {
        checked_otherid.push($(this).attr('id'));
    });
    if (checked_otherid == '') {
        checked_otherid = '';
    }

    var rolerightdata = {
        role_id: role_id,
        controller_id: controller_id,
        menu_id: menu_id,
        defaultid: defaultid,
        checked_otherid: checked_otherid,
        //unchecked_otherid :unchecked_otherid
    };


    $.ajax({
        url: APP_URL + "/admin/add_roleright",
        type: 'POST',
        data: {
            rolerightdata: rolerightdata
        },
        dataType: "json",
        success: function(result) {

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
                    priority: 'success'
                });

            } else if (result.message) {
                Swal.fire({
                    text: result.message,
                    title: 'Motor Welfare',
                    priority: 'danger'
                });
            }


        }
    });

}

function modulereset() {
    $("#module").val('');
    $("#menutbl").html('');
}
</script>
@endpush


@endsection
