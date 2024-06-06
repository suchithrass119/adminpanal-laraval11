@extends('admin.layout.master')
@section('content')
<div class='container-fluid'>
    <div class="card">
        <div class="card-header">
            <h4>Add Modules</h4>
        </div>
        <div class="card-body">
            <form id="module_frm" class="form-horizontal">
            <input type="hidden" name="module_id" value="" class="form-control" id="module_id">

            <div class="form-group row">
                <div class="col-md-6">
                <label for="module_name" class="col control-label">Module Name</label>                    <div class="col input-group">
                        <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                        <input type="text" name="module_name" placeholder="Enter Module Name" class="form-control" id="module_name" maxlength="50">                    </div>
                </div>
                <div class="col-md-6">
                <label for="module_order" class="col control-label">Module Order</label>                    <div class="col input-group">
                        <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                        <input type="text" name="module_order" placeholder="Enter Module Order" class="form-control" id="module_order" maxlength="10">                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                <label for="module_description" class="col control-label">Description</label>                    <div class="col input-group">
                        <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                        <textarea name="module_description" placeholder="Enter Description" class="form-control" id="module_description" rows="3" maxlength="100"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                <label for="module_icon" class="col control-label">Module Icon</label>                    <div class="col input-group">
                        <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                        <input type="text" name="module_icon" id="module_icon" class="form-control" placeholder="Enter Module Icon (eg. fa fa-user)" maxlength="50">
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                <label for="module_dashboard" class="col control-label">Module Dashboard URL</label>                    <div class="col input-group">
                        <span class="input-group-addon"><i class="fa fa-hand-right"></i></span>
                        <input type="text" name="dashboard" placeholder="Eg: /admin/dashboard" class="form-control" id="module_dashboard" maxlength="50">
                    </div>
                </div>
              </div>

            <div class="row justify-content-around mt-2">
              <div class="col-md-3 form-group">
              </div>
              <div class="col-md-3 form-group">
                <button type="button" class="btn btn-secondary " id="clearbtn">clear</button>
                <button type="button" class="btn btn-success " id="modulebtn" onclick="module_save()">save</button>

              </div>
            </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Module Details</h4>
        </div>
        <div class="card-body">
            <table id="module_table" class="table  table-bordered table-stripped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sl NO</th>
                        <th>Module Name</th>
                        <th>Module Description</th>
                        <th>Module Order</th>
                        <th>Module Icon</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div><!-- /.row -->




@push('pagescripts')
<script type="text/javascript">
var module_table;
$(document).ready(function() {
    var formid = "#module_frm";
    $('#clearbtn').on('click', function() {
        $(formid)[0].reset();
        $(".demo-box").hide();
    });
    module_table = $('#module_table').dataTable({

        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": APP_URL + "/admin/add_module",
            //  "url": "/admin/add_module/",
            "type": "GET",
            "data": {
                tablename: "module_table"
            },
            "dataType": "json"

        },
        "order": [
            [0, "desc"]
        ],
        "bdestroy": true,
        "destroy": true,
        "columns": [

            {
                'data': 'module_id'
            },
            {
                'data': 'module_name'
            },
            {
                'data': 'module_description'
            },
            {
                'data': 'module_order'
            },
            {
                'data': 'module_icon'
            },
            {
                'data': 'edit_button'
            }

        ],
        "columnDefs": [{
                "targets": [1, 2, 3, 4],
                render: function(aData, type, nRow) {
                    return type === 'display' &&
                        aData.length > 10 ?
                        '<span title="' + aData + '">' + aData.substr(0, 10) + '...</span>' :
                        aData;
                },
            },
            {
                "targets": [2, 4],
                "orderable": false,
                "searchable": false,
            },
            {
                "targets": 5,
                render: function(aData) {
                    return aData.replace(/&lt;/g, '<').replace(/&quot;/g, "'").replace(/&gt;/g,
                        '>');;
                }
            },

        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = module_table.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            // $("td:last", nRow).html($("td:last", nRow).text());
            // $("li:last", nRow).html($("li:last", nRow).text());
            return nRow;

        },
        "fnDrawCallback": function(oSettings) {

            $('.edit_btn').each(function(e) {
                $(this).on("click", function() {
                    //alert("hello Raj");
                    var module_id = $(this).attr('id'); ////alert(office_id);
                    //window.location="/admin/add_office/"+office_id+"/edit";
                    //alert(module_id);
                    $.ajax({
                        url: APP_URL + "/admin/add_module/" + module_id +
                            "/edit",
                        method: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            //alert(result.module_description);
                            $('#module_id').val(result.module_id);
                            $('#module_name').val(result.module_name);
                            $('#module_description').val(result
                                .module_description);
                            $('#module_order').val(result.module_order);
                            $('#module_icon').val(result.module_icon);
                            $('#module_dashboard').val(result
                                .module_dashboard);
                            $('#modulebtn').attr('onclick',
                                'module_update()');
                            $('#modulebtn').text('update');
                            $(document).scrollTop(0);
                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);
                            alert("erro");
                        }
                    });
                });
            });




            //delete_function
            $('.del_btn').on("click", function() {
                var confirmed = confirm("Are you sure want to delete the record?");
                if (confirmed) {
                    var module_id = $(this).attr('id');
                    //alert(office_id);
                    var str = $("#module_frm").serialize();
                    //alert(str);
                    $.ajax({
                        url: APP_URL + "/admin/add_module/" + module_id,
                        method: 'DELETE',
                        data: str,
                        dataType: "json",
                        success: function(result) {

                        },
                        complete: function(data) {
                            Swal.fire({
                                text: 'Deleted Successfully',
                                title: 'Motor Welfare',
                                priority: 'danger'
                            });
                            module_table.api().ajax.reload(null, false);
                            $('#modulebtn').attr('onclick', 'module_save()');
                            $('#modulebtn').text('save');
                            $(formid)[0].reset();
                        }

                    });
                } else {
                    event.preventDefault();
                }
            });
            //delete_function


        }
    });
    // $('#module_table').css('cursor', 'pointer');
    /*$('#office_table tbody').on( 'click', 'tr', function (){
           var str=office_table.fnGetData(this);
        /////  alert(str[3]);
           $('#office_name').val(str[1]);
            $('#office_type').val(str[2]);
            $('#phonenumber').val(str[3]);
            $('#email_address').val(str[4]);

 });*/
    $.validator.addMethod("valueNotEquals", function(value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");

    $("#module_frm").validate({
        rules: {
            module_name: "required",
            module_order: "required",
            module_description: "required",
            module_icon: "required"
        },
        messages: {
            module_name: "Please specify Module Name",
            module_order: "Please specify Module Order",
            module_description: "Please specify Description",
            module_icon: "Please specify Module Icon"

        }

    });


});


function module_save() {
    //alert("hello");
    //var i=$( "#module_description" ).val();
    //alert(i);

    var checkmod = $("#module_frm").valid();
    if (checkmod) {

        var str = $("#module_frm").serialize();
        $.ajax({
            url: APP_URL + "/admin/add_module",
            type: 'POST',
            data: str,
            dataType: "json",
            success: function(result) {
                $(".demo-box").hide();
                if (result == 1) {
                    /////alert(result);
                    Swal.fire({
                        text: 'Saved Successfully',
                        title: 'Motor Welfare',
                        priority: 'success'
                    });
                    $('#module_name').val('');
                    $('#module_order').val('');
                    $('#module_description').val('');
                    $('#module_icon').val('');

                    module_table.api().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Duplicate Entry',
                        title: 'Motor Welfare',
                        priority: 'danger'
                    });

                } else {
                    var error_msgs = "";
                    ////  $(".error_list").html("");
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';

                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();
                    Swal.fire({
                        text: error_msgs,
                        title: 'Motor Welfare',
                        priority: 'error'
                    });
                }

            },
            error: function(jqXHR, exception) {
                Swal.fire({
                    text: 'Error Occured',
                    title: 'Motor Welfare',
                    priority: 'danger'
                });
                //////console.log(jqXHR);
            },

        });

    }
}
//update_function
function module_update() {
    var checkmod = $("#module_frm").valid();
    if (checkmod) {

        var str = $("#module_frm").serialize();
        var moduleid = $('#module_id').val();
        $.ajax({
            url: APP_URL + "/admin/add_module/" + moduleid,
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

                    $('#module_name').val('');
                    $('#module_order').val('');
                    $('#module_description').val('');
                    $('#module_icon').val('');
                    $('#modulebtn').attr('onclick', 'module_save()');
                    $('#modulebtn').text('save');
                    module_table.api().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Operation Not Permitted',
                        title: 'Motor Welfare',
                        priority: 'danger'
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




                //============================================

                //module_table.api().ajax.reload(null, false);
                module_table.api().ajax.reload(null, false);

            },
            error: function(jqXHR, exception) {
                Swal.fire({
                    text: 'Error in DB',
                    title: 'Motor Welfare',
                    priority: 'danger'
                });
                //////console.log(jqXHR);
            }
        });
    }
}
//update_function
</script>
@endpush
@endsection
