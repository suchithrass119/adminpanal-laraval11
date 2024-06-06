@extends('admin.layout.master')

@section('content')
<div class='container-fluid'>
    <div class='col-md-12'>
        <div class="tab-content">
            <!--form card-->
            <div class="card">
                <div class="card-header">
                    <h4>Add User</h4>
                </div>
                <div class="card-body">
                    <div class="demo-box alert alert-danger" style="display:none">
                        <strong>Error:</strong> There were some problems with your input.
                        <ul>
                        </ul>
                    </div>
                    <form class="form-horizontal" id="userregform" autocomplete="off">
                    <!--form group 1-->
                    <div class="form-group row">
                        <div class="col-md-6">
                        <label for="name" class="control-label">Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="name" placeholder="Enter Name" class="form-control" id="name" maxlength="50">                            </div>
                        </div>
                        <div class="col-md-6">
                        <label for="username" class="control-label">UserName</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" name="username" placeholder="Enter UserName" class="form-control" id="username" maxlength="20">                            </div>
                        </div>
                        <!--form group 1-->
                    </div>

                    <!--form group 2-->
                    <div class="form-group row" id="formgroup2">
                        <div class="col-md-6">
                        <label for="password" class="control-label">Password</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" placeholder="Enter Password" class="form-control" id="password" maxlength="20">                                <div id="password_msg" style="color:red"></div>
                            </div>
                            <label style="color:blue;">
                                <font size="2px">Password must contain atleast 6 characters including alphabet,number and special character(!$#%_@)</font>
                            </label>

                        </div>
                        <div class="col-md-6">
                        <label for="confirm_password" class="control-label">Confirm Password</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                </div>
                                <input type="password" name="cpassword" placeholder="Reenter Password" class="form-control" id="cpassword" maxlength="20">                            </div>
                        </div>
                    </div>

                    <!--form group 3-->
                    <div class="form-group row">

                        <div class="col-md-6">
                        <label for="office" class="control-label">Select Office</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-list"></i></span>
                                </div>
                                <select name="office_id" id="office_id" class="form-control">
                                    <option value="">--Select--</option>
                                    <!-- Add options for office selection here -->
                                    <?php foreach ($office as $key => $value): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <label for="usertype" class="control-label">Select Usertype</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-list"></i></span>
                                </div>
                                <select name="usertype" id="usertype" class="form-control">
                                    <option value="">Please Select</option>
                                    <!-- Add options for usertype selection here -->
                                    @foreach($usertype as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-md-6">
                        <label for="designation" class="control-label">Select Designation</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-list"></i></span>
                                </div>
                                <select name="designation_id" id="designation_id" class="form-control">
                                    <option value="">Please Select</option>
                                    <!-- Add options for designation selection here -->
                                    @foreach($designation as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <label for="email" class="control-label">Email Address</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email_address" class="form-control" placeholder="Enter Email Address" id="email_address">                            </div>
                        </div>

                        <!--form group 3-->
                    </div>
                    <!--form group 4-->
                    <div class="form-group row">

                        <div class="col-md-6">
                        <label for="phone_number" class="control-label">Phone Number</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <!--<div class="input-group-addon">+91</div>-->
                                <input type="text" name="mob_number" placeholder="Enter Mobile number" class="form-control" id="mob_number" maxlength="10">                            </div>
                        </div>
                        <div class="col-md-6">
                            
                        <label for="district" class="control-label">Select District</label>                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-list"></i></span>
                                </div>
                                <select name="district_id" id="district_id" class="form-control" onchange="get_taluk();">
                                    <option value="0">Please Select</option>
                                    <!-- Add options for district selection here -->
                                    @foreach($district as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--form group 4-->
                    </div>
                    <!--form group 5-->

                    <div class="row justify-content-around mt-2">
                        <div class="col-sm-3 form-group">
                        
                        </div>
                        <div class="col-md-3 form-group" id="btnsec">
                            {!!$btn_save!!}
                            <button type="button" class="btn btn-secondary" id="clearbtn">clear</button>
                        </div>
                        <input type="hidden" name="user_id" value="" id="user_id">                    </div>
                    </form>


                </div>
                <!--cardbody-->
            </div>
            <!--card-->
            <!--form card-->
            <!--table card-->
            <div class="card card-default">
                <div class="card-header">User table</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user_table" class="table  table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--cardbody-->
            </div>
            <!--card-->
            <!--table card-->
        </div>
        <!--tab-content-->


    </div><!-- /.col -->
</div><!-- /.row -->


@push('pagescripts')

<script type="text/javascript">
    function getOffice(elm) {
        var board_id = elm.value;

        $('#office_id').empty();
        $('#office_id').append(
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
                    $('#office_id').append($('<option>', {
                        value: result[i]['office_id'],
                        text: result[i]['office_name']
                    }));
                }
            }
        });

    }

    $(document).ready(function() {
        var formid = "#userregform";
        load_datatable();
        $('#clearbtn').on('click', function() {
            $("#password").attr('readonly', false);
            $('.tooltip').tooltip('hide');
            $(".demo-box").hide();
            $('#formgroup2').show();
            $('#userregbtn').attr('onclick', 'user_save()');
            $('#userregbtn').val('save');
            $(formid)[0].reset();
        });
        jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/[0-9]+[1-9]/);
        }, "Please specify a valid phone number");


        $("#userregform").validate({
            rules: {
                name: "required",
                username: "required",
                password: "required",
                cpassword: {
                    equalTo: "#password",
                    required: true
                },
                //                           usertype: "required",
                email_address: {
                    email: true,
                    required: true
                },

                // designation_id: "required",
                // board_id: "required",
                // office_id: "required",
                usertype: "required",
                mob_number: {
                    digits: true,
                    minlength: 10,
                    required: true,
                    maxlength: 10,
                    phoneUS: true
                }

            },
            messages: {
                name: "Please specify Name",
                username: "Please specify User name",
                password: "Please specify Password",
                // designation_id: "Please specify Designation",
                // board_id: "Please specify Board",
                // office_id: "Please specify Office",
                usertype: "Please specify Usertype",
                cpassword: {
                    equalTo: "Please Password Mismatch",
                    required: "Please Reenter Password"
                },
                email_address: {
                    email: "Please enter valid Email Address",
                    required: "Please specify Email Address"
                },
                //                           usertype:"Please select User Type",
                //                           office_id: "Please select Any Office",
                //                           designation_id: "Please select Designation",
                mob_number: {
                    digits: "Please Enter only numbers",
                    minlength: "Please enter atleast 10 numbers",
                    required: "Please specify Mobile Number",
                    maxlength: "Please enter no more than 10 numbers"
                }

            }

        });
    }); //document ready

    //save
    function load_datatable() {
        var usertable = $('#user_table').dataTable({

            "serverSide": true,
            "processing": true,
            // "responsive": false,
            "ajax": {
                "url": APP_URL + "/admin/user",
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
                    'data': 'user_id'
                },
                {
                    'data': 'name',
                    'name': 'admin_users.name'
                },
                {
                    'data': 'username'
                },
                {
                    'data': 'mob_number'
                },
                {
                    'data': 'email_address'
                },
                {
                    'data': 'user_type_name',
                    'name': 'admin_user_type.user_type_name'
                },
                {
                    'data': 'designation_name',
                    'name': 'admin_designation.designation_name'
                },
                {
                    'data': 'edit_button',
                    render: function(aData) {
                        return aData.replace(/&lt;/g, '<').replace(/&quot;/g, "'").replace(/&gt;/g,
                            '>');;
                    }
                }
            ],
            // "columnDefs": [{
            //     "targets": 7,
            //     render: function(aData) {
            //         return aData.replace(/&lt;/g, '<').replace(/&quot;/g, "'").replace(/&gt;/g,
            //             '>');;
            //     }
            // }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = usertable.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                // $("td:last", nRow).html($("td:last", nRow).text());
                //$("td:nth-last-child(2)", nRow).html($("td:nth-last-child(2)", nRow).text());
                return nRow;
            },
            "fnDrawCallback": function(oSettings) {

                //edit
                $('.edit_btn').each(function(e) {
                    $(this).on("click", function() {
                        var user_id = $(this).attr('id');
                        $.ajax({
                            url: APP_URL + "/admin/user/" + user_id + "/edit",
                            method: 'GET',
                            dataType: 'json',
                            success: function(result) {
                                console.log(result);
                                $('#formgroup2').hide();
                                $('#name').val(result.name);
                                $('#username').val(result.username);
                                // $('#username').attr('readonly', 'readonly'); //comment on 09012024 sabitha
                                $('.tooltip').tooltip('hide');
                                /*  $('#password').val(result.password);
                                  $("#password").attr('readonly','readonly');*/
                                $('#usertype').val(result.usertype);
                                $('#designation_id').val(result.designation_id);
                                $('#email_address').val(result.email_address);
                                //$("#email_address").attr('readonly','readonly');
                                $('#mob_number').val(result.mob_number);
                                // $("#mob_number").attr('readonly','readonly');
                                $('#user_id').val(result.user_id);
                                $('#office_id').val(result.office_id);
                                $('#district_id').prop('selectedIndex', result.district_id);
                                // $('#taluk_id').val(result.talukid);
                                // $('#block_id').val(result.blockid);
                                $('#btnsec').html(result.buttons);
                                $(window).scrollTop(0);
                            },
                            error: function(jqXHR, exception) {
                                console.log(jqXHR);
                            }
                        });
                        //ajax
                    });
                });
                //edit
                //reset password

                $('.new_pass').blur(function() {
                    var user_id = $(this).attr('name');
                    var new_password = $('#password' + user_id).val();

                    if (new_password == '') {
                        $('#password' + user_id + '_msg').html("Password field should not ne null");
                    } else {
                        $('#password' + user_id + '_msg').html("");
                        var as = checkField(this, "password");
                    }
                });
                $('.con_pass').blur(function() {
                    var user_id = $(this).attr('name');
                    var con_password = $('#con_password' + user_id).val();

                    if (con_password == '') {
                        $('#con_password' + user_id + '_msg').html(
                            "Confirm Password field should not ne null");
                    } else {
                        $('#con_password' + user_id + '_msg').html("");
                        var as1 = checkField(this, "password");
                    }

                });
                $('.reset_pass').each(function(e) {

                    $(this).click(function() {


                        var user_id = $(this).attr('id');
                        var new_password = $('#password' + user_id).val();
                        var con_password = $('#con_password' + user_id).val();
                        var id_con = document.getElementById('con_password' + user_id);
                        var id = document.getElementById('password' + user_id);
                        var flag = checkField(id, "password");
                        var flag_con = checkField(id_con, "password");
                        var old_password = $('#old_password' + user_id).val();
                        if (old_password == '') {
                            var old_flag = false;
                            $('#old_password' + user_id + '_msg').html(
                                "Please enter required value");
                        } else {
                            var old_flag = true;
                            $('#old_password' + user_id + '_msg').html("");
                        }
                        if (new_password == con_password) {
                            var flag_match = true;
                            $('#con_password' + user_id + '_msg').html("");
                        } else {
                            $('#con_password' + user_id + '_msg').html(
                                "The confirmation password and password must match.");
                            var flag_match = false;
                            $('.con_pass').val('');

                        }
                        if (flag == true && flag_con == true && flag_match == true &&
                            old_flag) {

                            $.ajax({
                                url: APP_URL + "/admin/user/" + user_id,
                                method: 'GET',
                                data: {
                                    old_pss: old_password,
                                    password: new_password,
                                    con_password: con_password
                                },
                                dataType: "json",
                                success: function(result) {

                                    if (result.status == 1) {
                                        Swal.fire({
                                            text: result.success,
                                            title: 'Motor Wefare',
                                            icon: 'success'
                                        });
                                        $('.new_pass').val('');
                                        $('.con_pass').val('');
                                        $('#myModal' + user_id).modal('hide');
                                    } else if (result.status == 0) {
                                        Swal.fire({
                                            text: result.success,
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                    } else if (result.status == 2) {
                                        Swal.fire({
                                            text: result.error,
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                    } else {
                                        var error_msgs = "";
                                        $.each(result, function(key, value) {
                                            error_msgs += value;
                                        });

                                        Swal.fire({
                                            text: error_msgs,
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                        $('.new_pass').val('');
                                        $('.con_pass').val('');
                                    }
                                },
                                error: function(jqXHR, exception) {
                                    Swal.fire({
                                        text: 'Password reset failed..some logic problem',
                                        title: 'Motor Wefare',
                                        icon: 'error'
                                    });
                                    console.log(jqXHR);
                                }

                            });

                        }

                    });

                });
                //end reset password
                //delete
                $('.del_btn').each(function(e) {
                    $(this).on("click", function() {
                        var confirmed = confirm("Are you sure you want to do this?");
                        if (confirmed) {
                            var formdata = $("#userregform").serialize();
                            var user_id = $(this).attr('id');
                            $.ajax({
                                url: APP_URL + "/admin/user/" + user_id,
                                method: 'DELETE',
                                //data:{ CSRF: getCSRFTokenValue()},
                                data: formdata,
                                dataType: "json",
                                success: function(result) {
                                    if (result == 1) {
                                        Swal.fire({
                                            text: 'Deleted Successfully',
                                            title: 'Motor Wefare',
                                            icon: 'success'
                                        });
                                        $('#userregform')[0].reset();
                                        $("#password").attr('readonly', false);
                                        $("#username").attr('readonly', false);
                                        $("#email_address").attr('readonly', false);
                                        $("#mob_number").attr('readonly', false);
                                        $('#formgroup2').show();
                                        $('#userregbtn').text('save');
                                        $('#userregbtn').attr('onclick',
                                            'user_save()');
                                        $('#user_id').val('null');
                                        load_datatable();
                                    } else if (result == 2) {
                                        Swal.fire({
                                            text: 'Deletion failed.Survey Users Already Added under this IEO',
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                    } else if (result == 0) {
                                        Swal.fire({
                                            text: 'Deletion failed',
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                    } else if (result.message) {
                                        Swal.fire({
                                            text: result.message,
                                            title: 'Motor Wefare',
                                            icon: 'error'
                                        });
                                    }

                                },
                                error: function(jqXHR, exception) {
                                    Swal.fire({
                                        text: 'Deletion failed..some logic problem',
                                        title: 'Motor Wefare',
                                        icon: 'error'
                                    });
                                    console.log(jqXHR);
                                }
                            }); //ajax

                        } //ok
                        else {
                            //not message
                        } //not ok

                    });
                }); //delete




            }

        }); //d
    }

    function user_save() {

        var checkuser = $("#userregform").valid();
        if (checkuser) {

            var userformdata = $("#userregform").serialize();
            $.ajax({
                url: APP_URL + '/admin/user',
                type: 'POST',
                data: userformdata,
                dataType: "json",
                success: function(result) {
                    $(".demo-box").hide();
                    if (result == 1) {
                        Swal.fire({
                            text: 'Saved Successfully',
                            title: 'Motor Wefare',
                            icon: 'success'
                        });

                        //$("#username").val('');
                        ////alert("hyy");
                        $('#userregform')[0].reset();
                        $('#user_table').DataTable().ajax.reload();
                        load_datatable();

                    } else if (result == 0) {
                        Swal.fire({
                            text: 'Saving Failed',
                            title: 'Motor Wefare',
                            icon: 'error'
                        });
                    } else if (result.message) {
                        Swal.fire({
                            text: result.message,
                            title: 'Motor Wefare',
                            icon: 'error'
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
                    Swal.fire({
                        text: 'Saving failed..some logic problem',
                        title: 'Motor Wefare',
                        icon: 'error'
                    });
                    console.log(jqXHR);
                }
            });
        }
    }

    function user_update() {
        var checkuser = $("#userregform").valid();
        if (checkuser) {

            var userformdata = $("#userregform").serialize();
            var user_id = $('#user_id').val();
            $.ajax({
                url: APP_URL + "/admin/user/" + user_id,
                type: 'PUT',
                data: userformdata,
                dataType: "json",
                success: function(result) 
                {
                    $(".demo-box").hide();
                    if (result == 1) 
                    {
                        Swal.fire({
                            text: 'Updated Successfully',
                            title: 'Motor Wefare',
                            icon: 'success'
                        });
                        $("#password").attr('readonly', false);
                        $("#username").attr('readonly', false);
                        $("#email_address").attr('readonly', false);
                        $("#mob_number").attr('readonly', false);
                        $('#formgroup2').show();
                        $('#userregbtn').text('save');
                        $('#userregbtn').attr('onclick', 'user_save()');
                        $('#user_id').val('null');
                        $('#userregform')[0].reset();

                        //$('#usertbl').DataTable().ajax.reload(null,false);
                        $('#user_table').DataTable().ajax.reload();
                        load_datatable();
                    } 
                    else if (result == 2) 
                    {
                        Swal.fire({
                            text: 'Updation Failed. Survey user Already Added under this IEO',
                            title: 'Motor Wefare',
                            icon: 'error'
                        });
                    } 

                    else if (result == 3)  // 09012024 sabitha (result ==3 condition)
                    {
                        Swal.fire({
                            text: 'Updation Failed. Username Already Exsist',
                            title: 'Motor Wefare',
                            icon: 'error'
                        });
                    } 

                    else if (result == 0) 
                    {
                        Swal.fire({
                            text: 'Updation Failed',
                            title: 'Motor Wefare',
                            icon: 'error'
                        });
                    } 
                    else if (result.message) 
                    {
                        Swal.fire({
                            text: result.message,
                            title: 'Motor Wefare',
                            icon: 'error'
                        });
                    } 
                    else 
                    {
                        var error_msgs = "";
                        ////  $(".error_list").html("");
                        $.each(result, function(key, value) {
                            error_msgs += '<li>' + value + '</li>';

                        });
                        $(".demo-box").html(error_msgs);
                        $(".demo-box").show();


                    }

                },
                error: function(jqXHR, exception) {
                    Swal.fire({
                        text: 'Updation failed..some logic problem',
                        title: 'Motor Wefare',
                        icon: 'error'
                    });
                    console.log(jqXHR);
                }
            });

        }
    }
    // function get_taluk()
    // {
    // var distid=$('#district_id').val();
    // // $('#taluk_id').empty();
    // //   $('#taluk_id').append($('<option>', {
    // //     value: '',
    // //     text : '--Select Taluk--'
    // //   }));
    //   $.ajax({
    //             url: APP_URL+"/admin/get_taluk",
    //             method: 'POST',
    //             data :{
    //                 "_token": "{{ csrf_token() }}",
    //               btn_id:'taluk',district_id:distid},
    //             dataType: 'json',
    //             success: function(result){
    //                 for(var i=0;i<result.length;i++)
    //                  {
    //                    $('#taluk_id').append($('<option>', {
    //                      value: result[i]['talukid'],
    //                      text : result[i]['talukdesc']
    //                    }));
    //                  }
    //             }
    //         });

    // }

    // function get_block()
    // {
    // var distid=$('#district_id').val();
    // var talukid=$('#taluk_id').val();
    // $('#block_id').empty();
    //   $('#block_id').append($('<option>', {
    //     value: '',
    //     text : '--Select Block--'
    //   }));
    //   $.ajax({
    //             url: APP_URL+"/admin/get_block",
    //             method: 'POST',
    //             data :{
    //                 "_token": "{{ csrf_token() }}",
    //               btn_id:'block',talukid:talukid},
    //             dataType: 'json',
    //             success: function(result){
    //                 for(var i=0;i<result.length;i++)
    //                  {
    //                    $('#block_id').append($('<option>', {
    //                      value: result[i]['blockid'],
    //                      text : result[i]['blockdesc']
    //                    }));
    //                  }
    //             }
    //         });

    // }
</script>
@endpush

@endsection