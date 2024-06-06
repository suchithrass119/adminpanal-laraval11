@extends('admin.layout.master')
@section('content')
<div class='container-fluid'>
    <div class='col-md-12'>
        <div class="card">
            <div class="card-header">Create Roles</div>
            <div class="card-body">
                <form class="form-horizontal" id="roleform">
                <div class="box-body">
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <input type="hidden" name="role_id" class="form-control" id="role_id">
                            <label class="control-label">Select Office</label>

                            <div class="input-group">
                                <select name="officeid" class="form-control" id="officeid">
                                    <option value="">Select</option>
                                    @foreach ($office as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                        <label class="control-label">Enter Role Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                                <input type="text" name="rolename" class="form-control" id="rolename" placeholder="Enter Role Name" maxlength="50">
                            </div>
                        </div>

                        <div class="col-md-3">
                        </div>

                    </div>

                </div>
                <div class="row justify-content-around mt-2">
                    <div class="col-md-3 form-group">
                    </div>
                    <div class="col-md-3 form-group">
                        <button type="button" class="btn btn-secondary " id="clearbtn">clear</button> 
                        <button type="button" class="btn btn-success " id="rolebtn" onclick="role_save()">save</button>

                    </div>
                </div>

                </form>
            </div>
            <!--cardbody-->
        </div>
        <!--card-->
        <div class="card">
            <div class="card-header">Role table</div>
            <div class="card-body">
                <table id="tablerole" class="table table-bordered  table-stripped" width="100%">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Role Name</th>
                            <th>Office Name</th>
                            <th>Modified At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>
            <!--cardbody-->
        </div>
        <!--card-->
    </div>
</div>
@push('pagescripts')
<script type="text/javascript">

function getOffice(elm) {
    var board_id = elm.value;

    $('#officeid').empty();
    $('#officeid').append(
        $('<option>', {
            value: '',
            text: '--Select--'
        })
    );

    $.ajax({
        type: "GET",
        url: "get_office",
        data: {
            board_id: board_id
        },
        dataType: "json",
        success: function(result) {
            for (var i = 0; i < result.length; i++) {
                $('#officeid').append($('<option>', {
                    value: result[i]['office_id'],
                    text: result[i]['office_name']
                }));
            }
        }
    });

}


//var role_table;

$(document).ready(function() {
    var formid = "#roleform";
    $('#clearbtn').on('click', function() {
        $('.tooltip').tooltip('hide');
        $(formid)[0].reset();
        $(".demo-box").hide();
        $("#officeid").attr('disabled', false);
        $('#rolebtn').attr('onclick', 'role_save()');
        $('#rolebtn').text('Save');
    });



    var role_table = $('#tablerole').dataTable({

        "serverSide": true,
        "processing": true,
        //"responsive": true,
        "ajax": {

            "url": APP_URL + "/admin/create_role",
            "type": "GET",
            "dataType": "json"
        },
        "order": [
            [0, "desc"]
        ],
        "bdestroy": true,
        "destroy": true,
        //"autoWidth":false,
        "columns": [

            {
                'data': 'role_id'
            },
            {
                'data': 'role_name'
            },
            {
                'data': 'office_name'
            },
            {
                'data': 'updated_at'
            },
            {
                'data': 'edit_button'
            }

        ],

        "columnDefs": [
            {
                "targets": 4,
                render: function(aData) {
                    return aData.replace(/&lt;/g, '<').replace(/&quot;/g, "'").replace(/&gt;/g,
                        '>');;
                }
            }
        ],

        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = role_table.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            // $("td:last", nRow).html($("td:last", nRow).text());
            $(".dtr-data", nRow).html($(".dtr-data", nRow).text());
            $(".child ul li span", nRow).html($(".child ul li span", nRow).text());
            //         alert($("tr.child td.child ul").text());
            return nRow;
        },

        "fnDrawCallback": function() {
            //Role edit
            $('.edit_but').each(function(e) {
                $(this).on("click", function() {
                    var role_id = $(this).attr('id');
                    $.ajax({
                        url: APP_URL + "/admin/create_role/" + role_id +
                            "/edit",
                        method: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            $('#role_id').val(result[0].role_id);
                            $('#rolename').val(result[0].role_name);
                            $("#board_id").val(result[0].board_id);
                            $("#boardid").val(result[0].board_id);
                            $("#boardid").attr('disabled', true);
                            $('#officeid').html($('<option>', {
                                value: result[0].office_id,
                                text: result[0].office_name,
                            }));
                            $("#officeid").attr('disabled', true);
                            $('#rolebtn').attr('onclick',
                                'role_update()');
                            $('#rolebtn').text('update');
                            $('.tooltip').tooltip('hide');
                            $(window).scrollTop(0);
                        }, error: function(jqXHR, exception) {
                            console.log(jqXHR);
                        }
                    });
                });
            });

            //Role delete
            $('.delete_but').each(function(e) {
                $(this).on("click", function() {
                    var confirmtn = confirm(
                        "Are you sure want to delete the record?");
                    if (confirmtn) {
                        var str = $("#roleform").serialize();
                        var role_id = $(this).attr('id');
                        $.ajax({
                            url: APP_URL + "/admin/create_role/" + role_id,
                            method: 'DELETE',
                            data: str,
                            dataType: "json",
                            success: function(result) {
                                if (result == 1) {
                                    Swal.fire({
                                        text: 'Deleted Successfully',
                                        title: 'Motor Welfare',
                                        icon: 'success'
                                    });
                                    $('#tablerole').DataTable().ajax
                                        .reload();
                                    $('#roleform')[0].reset();
                                    $('#rolebtn').attr('onclick',
                                        'role_save()');
                                    $('#rolebtn').text('Save');

                                } else if (result == 0) {
                                    Swal.fire({
                                        text: 'Error Occured',
                                        title: 'Motor Welfare',
                                        icon: 'danger'
                                    });

                                } else if (result.message) {
                                    Swal.fire({
                                        text: result.message,
                                        title: 'Motor Welfare',
                                        icon: 'danger'
                                    });
                                }
                            },
                            error: function(result) {
                                Swal.fire({
                                    text: 'Error Occured',
                                    title: 'Motor Welfare',
                                    icon: 'danger'
                                });
                            }
                            //office_table.api().ajax.reload(null, false);

                        });
                    } else {
                        event.preventDefault();
                    }
                });
            });




        }

    });
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);


        },
        "Please check your input."
    );

    $("#roleform").validate({
        rules: {
            rolename: {
                required: true
            },
            officeid: "required"
        },
        messages: {
            rolename: {
                required: "Please specify Role name"
            },
            officeid: "Please select Office"

        }
    });


});


//Role save
function role_save() {
    var vald = $("#roleform").valid();
    if (vald) {
        var str = $("#roleform").serialize();
        $.ajax({
            url: APP_URL + "/admin/create_role",
            type: 'POST',
            data: str,
            dataType: "json",
            success: function(result) {
                $(".demo-box").hide();
                if (result == 1) {
                    Swal.fire({
                        text: 'Saved Successfully',
                        title: 'Motor Welfare',
                        icon: 'success'
                    });
                    $('#roleform')[0].reset();
                    $('#tablerole').DataTable().ajax.reload();
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Saving Failed',
                        title: 'Motor Welfare',
                        icon: 'danger'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        icon: 'danger'
                    });
                } else {
                    var error_msgs = "";
                    ////  $(".error_list").html("");
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';

                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();

                }
            },
            error: function(result) {
                Swal.fire({
                    text: 'Error Occured',
                    title: 'Motor Welfare',
                    icon: 'danger'
                });
            }
        });
    }
}

function role_update() {
    var vald = $("#roleform").valid();
    if (vald) {
        var str = $("#roleform").serialize();
        var roleid = $('#role_id').val();
        $.ajax({
            url: APP_URL + "/admin/create_role/" + roleid,
            type: 'PUT',
            data: str,
            dataType: "json",
            success: function(result) {

                $(".demo-box").hide();
                if (result == 1) {
                    Swal.fire({
                        text: 'Updated Successfully',
                        title: 'Motor Welfare',
                        icon: 'success'
                    });
                    $('#rolebtn').attr('onclick', 'role_save()');
                    $('#rolebtn').text('Save');
                    $("#officeid").attr('disabled', false);
                    $('#roleform')[0].reset();
                    $('#tablerole').DataTable().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Updation Failed',
                        title: 'Motor Welfare',
                        icon: 'danger'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        icon: 'danger'
                    });
                } else {
                    var error_msgs = "";
                    ////  $(".error_list").html("");
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';

                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();


                }
            },
            error: function(result) {
                Swal.fire({
                    text: 'Error Occured',
                    title: 'Motor Welfare',
                    icon: 'danger'
                });
            }
        });
    }

}
</script>


@endpush
@endsection
