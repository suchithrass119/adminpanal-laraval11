<footer class="main-footer">
    <strong>Copyright © <?php echo date('Y'); ?> <a href="#" target="_blank">Motor Welfare</a>.</strong> &nbsp
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        Powered By <b> <a href="http://www.keltron.in" target="_blank">KELTRON</a></b>
    </div>
</footer>

<div id="profileModal" class="modal fade" role="dialog">
    @php $id=Crypt::encrypt(Session::get('userid')) @endphp
    <input type="hidden" name="hidden_userid" value="{{ $id }}" class="form-control" id="hidden_userid">    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">


                <div class="panel panel-info">
                    <div class="panel-heading"><b>
                            <center>Profile View</center>
                        </b></div>
                    <div class="panel-body">
                        <table id="office_table" class="table responsive table-bordered compact table-hover" cellspacing="0" width="100%">
                            <tr>
                                <th>Name</th>
                                <td id="admin_name"></td>
                            </tr>
                            <tr>
                                <th>UserName</th>
                                <td id="user"></td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td id="desig"></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td id="email"></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td id="phone"></td>
                            </tr>
                            <tr>
                                <th>Usertype</th>
                                <td id="user_type"></td>
                            </tr>

                        </table>

                        <div class="form-group row justify-content-between">
                            <div class="col-md-5 form-group">
                            <button type="button" data-toggle="modal" data-target="#editModal" class="btn btn-warning btn-block" id="officebtn">Edit Profile</button>

                            </div>
                            <div class="col-md-5 form-group">
                            <button type="button" class="btn btn-success btn-block" id="clearbtn" onclick="show_modal_pass()">Change Password</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
            <form id="prof_edit" class="form-horizontal" method="post">

                <div class="form-group">
                    <div class=""><label>Name</label></div>
                    <div class="">
                        <input type="text" class="form-control" id="edit_name" name="edit_name" />
                        <div id="edit_name_msg" style="color:red"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class=""><label>Email Address</label></div>
                    <div class="">
                        <input type="text" class="form-control" id="edit_email" name="edit_email" />
                        <div id="edit_email_msg" style="color:red"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class=""><label>Phone Number</label></div>
                    <div class="">
                        <input type="text" class="form-control" id="edit_phone" name="edit_phone" maxlength="10" onkeypress="isNumber(event)" />
                        <div id="edit_phone_msg" style="color:red"></div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-md-6">
                        <input type="button" class="btn btn-primary btn-block" name="edit_profile" id="edit_profile" value="Save" onclick="edit_prof()">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="changeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Change Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="changepass" class="form-horizontal" method="post">
                <div class="form-group row justify-content-center">
                    <div class="col-sm-4"><label>Old password</label></div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="old_password" name="old_password" autocomplete="off" value="" />
                        <div id="old_password_msg" style="color:red"></div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-sm-4"><label>New password</label></div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off" onblur="checkField(this,'password');" />
                        <div id="new_password_msg" style="color:red"></div>
                        <label style="color:green;">
                            <font size="2px">Password must contain atleast 6 characters including alphabet,number and special character(!$#%_@)</font>
                        </label>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-sm-4"><label>Confirm password</label></div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="off" onchange="check_password()" />
                        <div id="password_confirmation_msg" style="color:red"></div>
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-md-6">
                        <input type="button" class="btn btn-primary btn-block" name="reset" id="reset" value="Reset" onclick="resetPassword()">
                    </div>
                </div>
                </form>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
