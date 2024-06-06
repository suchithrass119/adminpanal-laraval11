@extends('admin.layout.master')
@section('content')
<div class='container-fluid'>
    <div class="card">
        <div class="card-header">
            <h4>Add Menu</h4>
        </div>
        <div class="card-body">
        <form id="menu_frm" name="frm" class="form-horizontal">
        <input type="hidden" name="menu_id" value="" class="form-control" id="menu_id">

            <div class="form-group row">

                <div class="col-md-6">
                <label for="module_id" class="col control-label">Select Module Name</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="module_id" class="form-control" id="module_id">
                        <option value="0">--Select Module --</option>
                        @foreach ($module as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                <label for="action_name" class="col control-label">Enter Default Action</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-hand-point-right"></i></span>
                        </div>
                        <input type="text" name="action_name" class="col form-control" id="action_name" placeholder="Enter Action Name" maxlength="75">
                    </div>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                <label for="parent_menu_id" class="col control-label">Select Parent Menu</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="parent_menu_id" class="form-control" id="parent_menu_id">
                        <option value="0">--select--</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                <label for="menu_order" class="col control-label">Order Of Menu</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-hand-point-right"></i></span>
                        </div>
                        <input type="text" name="menu_order" class="col form-control" id="menu_order" placeholder="Enter Order Of Menu">
                    </div>
                </div>

            </div>


            <div class="form-group row">

                <div class="col-md-6">
                <label for="menu_name" class="col control-label">Enter Menu Name</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-hand-point-right"></i></span>
                        </div>
                        <input type="text" name="menu_name" class="col form-control" id="menu_name" placeholder="Enter Menu Name" maxlength="75">
                    </div>
                </div>

                <div class="col-md-6">
                <label for="route_path" class="col control-label">Route Path</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-hand-point-right"></i></span>
                        </div>
                        <input type="text" name="route_path" class="col form-control" id="route_path" placeholder="Enter Route Path">
                    </div>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                <label for="controller_id" class="col control-label">Select Controller</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                        </div>
                        <select name="controller_id" class="form-control" id="controller_id">
                            <option value="0">--Select Controller --</option>
                            @foreach ($controller as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                <label for="iconclass" class="col control-label">Menu Icon Class</label>                    <div class="col input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-hand-point-right"></i></span>
                        </div>
                        <input type="text" name="iconclass" class="col form-control" id="iconclass" placeholder="Enter Menu Icon Class">
                    </div>
                </div>

                <div class="col-md-6"></div>
            </div>

            <div class="row justify-content-around mt-2">
                <div class="col-sm-3 form-group">
                </div>
                <div class="col-md-3 form-group">
                <button type="button" class="btn btn-secondary " id="clearbtn">clear</button>
                    
                <button type="button" class="btn btn-success" id="menubtn" onclick="menu_save()">save</button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Menu table</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="menu_table" class="table table-bordered  " width="100%">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Module Name</th>
                        <th>Menu Name</th>
                        <th>Controller Name</th>
                        <th>Default Action</th>
                        <th>Order of Menu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
          </div>
        </div>
    </div>
</div>


@endsection
@push('pagescripts')
<script>
var menu_table;
$(document).ready(function() {
    var formid = "#menu_frm";
    $('#clearbtn').on('click', function() {
        $(formid)[0].reset();
        $('#menubtn').attr('onclick', 'menu_save()');
        $('#menubtn').text('save');
        $(".demo-box").hide();
    });

    menu_table = $('#menu_table').dataTable({

        "serverSide": true,
        "processing": true,
        "ajax": {
            //  "url": "/admin/add_office/",
            "url": APP_URL + "/admin/add_menu",
            "type": "GET",
            "dataType": "json"
        },
        "order": [
            [0, "desc"]
        ],
        "bdestroy": true,
        "destroy": true,
        "columns": [

            {
                'data': 'menu_id'
            },
            {
                'data': 'module_name',
                'name': 'admin_modules.module_name'
            },
            {
                'data': 'menu_name',
                'name': 'admin_menus.menu_name'
            },
            {
                'data': 'controller_name',
                'name': 'admin_controllers.controller_name'
            },
            {
                'data': 'default_action_name'
            },
            {
                'data': 'order_of_menu'
            },
            {
                'data': 'edit_button'
            }
        ],


        "columnDefs": [{
            "targets": [2, 4],
            render: function(aData, type, nRow) {
                return type === 'display' &&
                    aData.length > 10 ?
                    '<span title="' + aData + '">' + aData.substr(0, 10) + '...</span>' :
                    aData;
            },
        },
            {
                "targets": 6,
                render: function(aData) {
                    return aData.replace(/&lt;/g, '<').replace(/&quot;/g, "'").replace(/&gt;/g,
                        '>');;
                }
            }
    ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
            var oSettings = menu_table.fnSettings();
            $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
            // $("td:last", nRow).html($("td:last", nRow).text());
            return nRow;

        },
        "fnDrawCallback": function(oSettings) {
            ///edit function

            $('.edit_btn').each(function(e) {
                $(this).on("click", function() {
                    var menu_id = $(this).attr('id'); ///alert(menu_id);
                    //window.location="/admin/add_office/"+office_id+"/edit";
                    $.ajax({
                        url: APP_URL + "/admin/add_menu/" + menu_id +
                            "/edit",
                        method: 'GET',
                        dataType: 'json',
                        success: function(result) {
                            ///// alert(result.controller_id);
                            ////$(".demo-box").html("");
                            $('#module_id').val(result.module_id);
                            if (result.controller_id) {
                                $('#controller_id').val(result
                                    .controller_id);
                            } else {
                                $('#controller_id').val(0);
                            }

                            $('#menu_name').val(result.menu_name);
                            $('#action_name').val(result
                                .default_action_name);
                            $('#menu_order').val(result.order_of_menu);
                            $('#route_path').val(result.route_path);
                            $('#menu_id').val(result.menu_id);
                            $('#iconclass').val(result.iconclass);
                            var parent_id = result.parent_menu_id;
                            var module_id = $('#module_id').val();
                            $.ajax({
                                url: APP_URL +
                                    "/admin/get_available_menus/" +
                                    module_id,
                                method: 'GET',
                                dataType: "json",
                                success: function(result) {
                                    //// alert(result.status);
                                    $('#parent_menu_id')
                                        .empty();
                                    $('#parent_menu_id')
                                        .append(
                                            '<option value ="0">' +
                                            '--Select Parent Menu--' +
                                            '</option>');

                                    if (result.status) {
                                        renderMenu(result
                                            .menus, 1);
                                    }
                                    if (parent_id == null) {
                                        parent_id = 0;
                                    }

                                    $('#parent_menu_id')
                                        .val(parent_id);
                                    $('#menubtn').attr(
                                        'onclick',
                                        'menu_update()');
                                    $('#menubtn').text(
                                        'update');
                                    $(window).scrollTop(0);
                                },

                            });


                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);
                        }
                    });
                });
            });









            //delete_function
            $('.del_btn').on("click", function() {
                var menu_id = $(this).attr('id');
                //alert(office_id);
                var str = $("#menu_frm").serialize();
                $.ajax({
                    url: APP_URL + "/admin/add_menu/" + menu_id,
                    method: 'DELETE',
                    data: str,
                    dataType: "json",
                    success: function(result) {
                        //// alert(result);
                        if (result == 1) {
                            menu_table.api().ajax.reload(null, false);
                            Swal.fire({
                                text: 'Deleted Successfully',
                                title: 'Motor Welfare',
                                icon: 'success'
                            });
                        } else if (result == 0) {
                            Swal.fire({
                                text: 'Unable To Delete',
                                title: 'Motor Welfare',
                                icon: 'success'
                            });
                        } else if (result.message) {
                            Swal.fire({
                                text: result.message,
                                title: 'Motor Welfare',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(jqXHR, exception) {
                        Swal.fire({
                            text: 'Error Occured',
                            title: 'Motor Welfare',
                            icon: 'error'
                        });
                        //////console.log(jqXHR);
                    }
                });

            });
            //delete_function
        }
    });

    $.validator.addMethod("valueNotEquals", function(value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");

    $("#menu_frm").validate({
        rules: {
            menu_name: "required",
            //                  action_name:"required",
            //                  route_path:"required",
            menu_order: "required",
            module_id: {
                valueNotEquals: "0"
            }
            //                  controller_id:{ valueNotEquals: "0" },
            //                  parent_menu_id:{ valueNotEquals: "0" }
        },
        messages: {
            menu_name: "Please specify Menu name",
            //                  action_name: "Please specify Action name",
            //                  route_path: "Please specify Route Path",
            menu_order: "Please specify Menu Order",
            module_id: {
                valueNotEquals: "Please select Module"
            }
            //                  controller_id:{ valueNotEquals: "Please select Contoller"},
            //                  parent_menu_id:{ valueNotEquals: "Please select Parent Menu"}

        }

    });


});

$('#module_id').on('change', function(e) {
    e.preventDefault();
    console.log(e);

    var module_id = e.target.value;
    $.ajax({
        url: APP_URL + "/admin/get_available_menus/" + module_id,
        method: 'GET',
        dataType: "json",
        success: function(result) {
            //// alert(result.status);
            $('#parent_menu_id').empty();
            $('#parent_menu_id').append('<option value="0">' + '--Select Parent Menu--' +
                '</option>');
            if (result.status) {
                renderMenu(result.menus, 1);
            }


        },
        error: function(jqXHR, exception) {
            //////console.log(jqXHR);
        }
    });




});

function renderMenu(menus, level) {
    $.each(menus, function(index, menuObj) {

        var i = level,
            level1 = '';
        while (i > 1) {
            level1 += '&nbsp;&nbsp;&nbsp;&nbsp;';
            i--;
        }
        $('#parent_menu_id').append('<option value ="' + menuObj.menu_id + '">' + level1 +
            '<span>-><i class="fa fa-circle"></i></span>' + menuObj.menu_name + '</option>');
        if (menuObj.children) {
            level++;
            renderMenu(menuObj.children, level);
            level--;
        }

    });
}






function menu_save() {

    var vald = $("#menu_frm").valid();
    console.log(vald);
    if (vald) {
        var str = $("#menu_frm").serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });
        $.ajax({
            url: APP_URL + "/admin/add_menu",
            type: 'POST',
            data: str,
            dataType: "json",
            success: function(result) {
                $(".demo-box").hide();
                /////alert(result);
                if (result == 1) {
                    menu_table.DataTable().ajax.reload(null, false);
                    Swal.fire({
                        text: 'Saved Successfully',
                        title: 'Motor Welfare',
                        icon: 'success'
                    });
                    $("#menu_frm")[0].reset();
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Duplicate Entry',
                        title: 'Motor Welfare',
                        icon: 'error'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        icon: 'error'
                    });
                } else {
                    var error_msgs = "";
                    ////alert(result);
                    ////  $(".error_list").html("");
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';

                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();

                    Swal.fire({
                        text: error_msgs,
                        title: 'Motor Welfare',
                        icon: 'error'
                    });
                }

            },
            error: function(jqXHR, exception) {
                Swal.fire({
                    text: 'Error Occured',
                    title: 'Motor Welfare',
                    icon: 'error'
                });
                //////console.log(jqXHR);
            },
            /*complete: function (data) {
              menu_table.api().ajax.reload(null, false);

            }*/

        });

    }
}

function menu_update() {
    var vald = $("#menu_frm").valid();
    if (vald) {
        var str = $("#menu_frm").serialize();
        var menu_id = $('#menu_id').val();
        $.ajax({
            url: APP_URL + "/admin/add_menu/" + menu_id,
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
                    $("#menu_frm")[0].reset();
                    $('#menubtn').attr('onclick', 'menu_save()');
                    $('#menubtn').text('save');
                    menu_table.api().ajax.reload(null, false);
                } else if (result == 0) {
                    Swal.fire({
                        text: 'Updation Error',
                        title: 'Motor Welfare',
                        icon: 'error'
                    });
                } else if (result.message) {
                    Swal.fire({
                        text: result.message,
                        title: 'Motor Welfare',
                        icon: 'error'
                    });
                } else {
                    var error_msgs = "";
                    ////alert(result);
                    $(".demo-box").html("");
                    $.each(result, function(key, value) {
                        error_msgs += '<li>' + value + '</li>';

                    });
                    $(".demo-box").html(error_msgs);
                    $(".demo-box").show();


                }
            },
            error: function(jqXHR, exception) {
                Swal.fire({
                    text: 'Error in DB',
                    title: 'Motor Welfare',
                    icon: 'error'
                });
                //////console.log(jqXHR);
            }
        });
    }
}




/*$('#module_id').change(function(){
var moduleid = $(this).val();
if(moduleid){
    $.ajax({
       type:"GET",
       data:{moduleid:moduleid},
       "url": APP_URL+"/admin/get_available_menus",
       success:function(res){
        console.log(res.menus);


       }
    });
}else{
    $("#parent_menu_id").empty();
}
});*/
</script>
@endpush
