@extends('admin.layout.master')
@push('commonstyle')
<style>
td.details-control {
    background: url('{{URL::asset("/images/details_open.png")}}') no-repeat center center;
    cursor: pointer;
}

tr.shown td.details-control {
    background: url('{{URL::asset("/images/details_close.png")}}') no-repeat center center;
}
</style>
@endpush
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Add Controller</h4>
        </div>
        <div class="card-body">
            <form id="controller_form" class="form-horizontal" method="POST" action="">
            <input type="hidden" name="count" value="1" class="form-control" id="count">
            <input type="hidden" name="controller_id" value="" class="form-control" id="controller_id">
            <div class="form-group row">
                <div class="col-md-6">
                <label for="controller_name" class="col control-label">Controller Name</label>
                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-random"></i></span>
                        </div>
                        <input type="text" name="controller_name" placeholder="Enter Controller Name" required class="form-control" id="controller_name" maxlength="50">
                    </div>
                </div>
                <div class="col-md-6">
                <label for="route_path" class="col control-label">Route Path</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-road"></i></span>
                        </div>
                        <input type="text" name="route_path" placeholder="Enter Route Path" class="form-control" id="route_path" maxlength="70">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                <label for="route_name" class="col control-label">Route Name</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                        </div>
                        <input type="text" name="route_name" placeholder="Enter Route Name" class="form-control" id="route_name" maxlength="50">
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                <label for="action1" class="col control-label">Actions</label>                    <div class="col input-group">
                <input type="text" name="action1" placeholder="Enter Action Name" class="form-control" id="action1" maxlength="50">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" onclick="addAction()"><i class="fa fa-plus"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="append col mt-2"></div>
                </div>

            </div>
            <div class="row justify-content-around">
                <div class="col-md-3 form-group">
                    <button type="button" class="btn btn-secondary btn-block" id="clearbtn">clear</button>
                </div>
                <div class="col-md-3 form-group">
                <button type="button" class="btn btn-success btn-block" id="controllerbtn" onclick="controller_save()">save</button>
                </div>
            </div>
            </form>
                </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Controller Table</h4>
        </div>
        <div class="card-body">
            <table id="controller_table" class="table  table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Controller Name</th>
                        <th>Route Path</th>
                        <th>Route Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('pagescripts')

<script>
var url = APP_URL + "/admin/add_controllers";
var table, id;

function addAction() {
    var next = $("#count").val();
    next++;
    $(".append").append('<div class="input-group mt-2 actionfield' + next + '"> \
                          <input placeholder="Enter Action Name" class="form-control" id="action' + next +
                         '" name="action' + next + '" type="text" maxlength="50"> \
                         <div class="input-group-append"> \
                            <span class="input-group-text"> \
                            <a href="javascript:void(0)" onclick="deleteAction(' + next + ')"> \
                              <i class="fa fa-minus"></i> \
                            </a> \
                          </span> \
                          </div> \
                        </div>');
    $("#count").val(next);
}

function deleteAction(action) {
    $('.actionfield' + action).remove();
    $("#count").val(parseInt($("#count").val()) - 1);
}

$(document).ready(function() {
    var formid = "#controller_form";
    $('#clearbtn').on('click', function() {
        $(formid)[0].reset();
        $('#controllerbtn').attr('onclick', 'controller_save()');
        $('#controllerbtn').text('save');
        $('#controller_form')[0].reset();
        $(".append").html('');
        $('#count').val(1);
    });
    $("#controller_form").validate({
        rules: {
            controller_name: "required"
        },
        messages: {
            controller_name: "Please specify Controller name"
        }
    });
    table = '#controller_table';
    var controller_table = $('#controller_table').dataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": APP_URL + "/admin/add_controllers",
            "type": "GET",
            "dataType": "json",

        },
        "order": [
            [0, "desc"]
        ],
        "bdestroy": true,
        "destroy": true,
      //  "autoWidth": false,
        "columns": [

            {
                'data': 'controller_id'
            },
            {
                'data': 'controller_name'
            },
            {
                'data': 'route_path'
            },
            {
                'data': 'route_name'
            },
            {
                'data': 'action'
            }

        ],

        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = controller_table.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            // $("td:last", nRow).html($("td:last", nRow).text());
            //$("td:nth-last-child(2)", nRow).html($("td:nth-last-child(2)", nRow).text());
            return nRow;
        },

        "fnDrawCallback": function() {
            //edit
            $('.edit_btn').each(function(e) {
                $(this).on("click", function() {
                    var id = $(this).attr('id');
                    $.ajax({
                        url: url + "/" + id + "/edit",
                        method: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            $(window).scrollTop(0);
                            $(".append").html('');
                            $('#count').val(1);
                            var controller = result.controller[0];
                            var actions = result.actions;
                            $('#controller_id').val(controller
                                .controller_id);
                            $('#controller_name').val(controller
                                .controller_name);
                            $('#route_path').val(controller
                                .route_path);
                            $('#route_name').val(controller
                                .route_name);
                            $('#action1').val(actions[0]);
                            for (var i = 1; i < actions
                                .length; i++) {
                                var j = parseInt(i) + 1;
                                $('.append').append('<div class="col input-group actionfield'+j+'"> \
                                                        <input placeholder="Enter Action Name" class="form-control" id="action'+j+'" name="action'+j+'" type="text" value="'+actions[i]+'"> \
                                                        <div class="input-group-append"> \
                                                            <span class="input-group-text"> \
                                                                <a href="javascript:void(0)" onclick="deleteAction('+j+')"> \
                                                                    <i class="fa fa-minus"></i> \
                                                                </a> \
                                                            </span> \
                                                        </div> \
                                                    </div>');
                            }
                            $("#count").val(actions.length);
                            $('#controllerbtn').attr('onclick',
                                'controller_update()');
                            $('#controllerbtn').text('update');
                        },
                        complete: function(data) {},
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);
                        }
                    });
                });
            });

            //delete
            $('.del_btn').each(function(e) {
                $(this).on("click", function() {
                    var str = $("#controller_form").serialize();
                    var id = $(this).attr('id');
                    $.ajax({
                        url: url + "/" + id,
                        method: 'DELETE',
                        data: str,
                        dataType: "json",
                        success: function(result) {
                            if (result == 1) {
                                Swal.fire({
                                    text: 'Deleted Successfully',
                                    title: 'Motor Welfare',
                                    priority: 'success'
                                });
                                $(table).DataTable().ajax.reload();

                            } else if (result == 0) {
                                Swal.fire({
                                    text: 'Error Occured',
                                    title: 'Motor Welfare',
                                    priority: 'danger'
                                });

                            } else if (result.message) {
                                Swal.fire({
                                    text: result.message,
                                    title: 'Motor Welfare',
                                    priority: 'danger'
                                });
                            }
                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);
                        }
                    });
                });
            });
        },
        "fnInitComplete": function(oSettings, json) {
            // Add event listener for opening and closing details
            $('#controller_table tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = controller_table.DataTable().row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    var controller_id = row.data()[1];
                    $.ajax({
                        url: url + '/' + controller_id,
                        type: 'GET',
                        dataType: "json",
                        success: function(result) {
                            row.child(format(result)).show();
                            tr.addClass('shown');
                        }
                    });
                }
            });
        }
    });

});
/*
document ready closing
 */

function controller_save() {
    var check = $("#controller_form").valid();
    if (check) {
        $.ajax({
            url: url,
            type: 'POST',
            data: $("#controller_form").serialize(),
            dataType: "json",
            success: function(result) {
                $(".demo-box").hide();
                if (result == 1) {
                    Swal.fire({
                        text: 'Saved Successfully',
                        title: 'Motor Welfare',
                        priority: 'success'
                    });
                    $('#controller_form')[0].reset();
                    $(table).DataTable().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Error Occured',
                        title: 'Motor Welfare',
                        priority: 'danger'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        priority: 'danger'
                    });
                } else {
                    var error_msgs = "";
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';
                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();
                }
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
            }
        });
    }
}

function controller_update() {
    var check = $("#controller_form").valid();
    if (check) {
        var str = $("#controller_form").serialize();
        id = $("#controller_id").val();
        $.ajax({
            url: url + "/" + id,
            type: 'PUT',
            data: str,
            dataType: "json",
            success: function(result) {
                $(".demo-box").hide();
                if (result == 1) {
                    Swal.fire({
                        text: 'Updated Successfully',
                        title: 'Motor Welfare',
                        priority: 'success'
                    });
                    $('#controllerbtn').attr('onclick', 'controller_save()');
                    $('#controllerbtn').text('save');
                    $('#controller_form')[0].reset();
                    $(".append").html('');
                    $(table).DataTable().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Error Occured',
                        title: 'Motor Welfare',
                        priority: 'danger'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        priority: 'danger'
                    });
                } else {
                    var error_msgs = "";
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';
                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();
                }

            },
            error: function(jqXHR, exception) {
                console.log(jqXHR);
            }

        });
    }
}



/* Formatting function for row details - modify as you need */
function format(actions) {
    var result = '<h6>Other Actions</h6><ul>';
    $.each(actions, function(index, value) {
        result += '<li>' + value + '</li>';
    });
    return result + '</ul>';
}
</script>
@endpush
