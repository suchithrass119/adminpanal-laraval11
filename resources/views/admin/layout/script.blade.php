@push('commonjs')
<!-- <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/adminlte.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.overlayScrollbars.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>-->









<!--  -->



<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- <script src="{{ asset('dist/js/adminlte.min.js') }}"></script> -->

<!-- <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="module" src="{{ asset('js/popper.min.js') }}"></script> -->

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>


<!-- datatable -->
<!-- <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/dataTables.responsive.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/responsive.bootstrap4.min.js') }}" /> </script> -->
<script type="text/javascript" src="{{ asset('js/dataTables.buttons.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/buttons.bootstrap4.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/jszip.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/pdfmake.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/buttons.html5.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/buttons.print.min.js') }}" />
</script>
<script type="text/javascript" src="{{ asset('js/buttons.colVis.min.js') }}" />
</script>


<!-- <script type="text/javascript" src="{{ asset('js/colReorder.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/fixedColumns.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/fixedHeader.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/keyTable.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/rowGroup.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/rowReorder.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/scroller.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/select.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/autoFill.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/searchBuilder.bootstrap4.min.js') }}" /> </script>
<script type="text/javascript" src="{{ asset('js/searchPanes.bootstrap4.min.js') }}" /> </script> -->
<!-- datatable -->

<script type="text/javascript" src="{{ asset('js/utilities.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/iscript.js') }}"></script>
<script type="text/javascript">
    history.pushState(null, null, window.location.href);
    window.addEventListener('popstate', function() {
        history.pushState(null, null, window.location.href);
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init();

        function disableBack() {
            window.history.forward()
        }
        window.onload = disableBack();
        window.onpageshow = function(evt) {
            if (evt.persisted) disableBack()
        }
    });

    $('.menuSelect').on('click', function() {
        var moduleid = $(this).data("id");
        if (moduleid) {
            getMenu(moduleid);
        } else {}
    });

    function getMenu(moduleid) {
        $.ajax({
            type: "GET",
            "url": APP_URL + "/admin/get_menu_text/" + moduleid,
            success: function(res) {
                var res = $.parseJSON(res);
                if ($.trim(res.menu) == 'test')
                    window.location.href = window.location.href;

                if (res.url != null) {
                    window.location.href = APP_URL + res['url'];
                    $('.menuDiv').html(res.menu);
                }
            },
        });
    }


    $("#view_profile").click(function() {
        var user_id = $("#hidden_userid").val();

        $.ajax({
            type: "GET",
            url: APP_URL + "/admin/viewprofile/" + user_id,
            success: function(res) {
                var pro_data = res[0];
                $('#admin_name').html(pro_data[0].name);
                $('#user').html(pro_data[0].username);
                $('#desig').html(pro_data[0].designation_name);
                $('#email').html(pro_data[0].email_address);
                $('#phone').html(pro_data[0].mob_number);
                $('#user_type').html(pro_data[0].user_type_name);

                var result = res[1];

                $('#edit_name').val(pro_data[0].name);
                $('#edit_email').val(pro_data[0].email_address);
                $('#edit_phone').val(pro_data[0].mob_number);
                $('#edit_desig').empty();
                $('#edit_desig').append('<option value ="">' + 'Select District' + '</option>');
                $.each(result, function(i, resu) {
                    $('#edit_desig').append($('<option>', {
                        value: resu.designation_id,
                        text: resu.designation_name
                    }));
                });
                $('#edit_desig').val(result[0].designation_id);
            }

        });
    });
</script>


<script>
    $('.select2').select2();

    $('.date-picker-normal').datetimepicker({
        clearBtn: true,
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });

    $('.datenormal').datetimepicker({
        format: 'DD/MM/YYYY',
    });

    $('.date-normal').datetimepicker({
        format: 'DD/MM/YYYY',
        maxDate: moment()
    });

    function datemask(evt) {
        var v = evt.value;
        if (v.match(/^\d{2}$/) !== null) {
            evt.value = v + '/';
        } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
            evt.value = v + '/';
        }
    }
</script>


<script>
    function autocomplete(inp, arr,xxx) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    getDetilSeleted(inp.value,xxx);
                    closeAllLists();
                });
                a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
                // load_jointmember();
            }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
            
        });
    }


    $(document).ready(function() {


$('#old_password').on('keypress', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        $('#new_password').focus();
    }
});

$('#new_password').on('keypress', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        $('#password_confirmation').focus();
    }
});

$('#password_confirmation').on('keypress', function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        $('#reset').click();
    }
});

});

function check_password() {
var pass = $("#new_password").val();
var cpass = $("#password_confirmation").val();
if (pass != cpass) {
    alert("please enter password correctly");
    $("#password_confirmation").val('');
}
}

function show_modal() {
$("#profileModal").removeClass("fade").modal("hide");
}

function show_modal_pass() {
$('#changeModal').modal('show');
$("#profileModal").modal("hide");
}

function edit_prof() {
var edit_name = $('#edit_name').val();
var edit_email = $('#edit_email').val();
var edit_phone = $('#edit_phone').val();

var check1 = validateProfile(document.getElementById('edit_name'), "edit_name");
var check2 = validateProfile(document.getElementById('edit_email'), "edit_email");
var check3 = validateProfile(document.getElementById('edit_phone'), "edit_phone");
console.log(check1);
console.log(check2);
console.log(check3);


if (check1 && check2 && check3) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: APP_URL + "/admin/editprofile",
        data: {
            'edit_name': edit_name,
            'edit_email': edit_email,
            'edit_phone': edit_phone
        },
        dataType: "json",
        success: function(res) {
            console.log(res);
            if (res.status) {
                Swal.fire({
                    title: 'COBANK',
                    text: res.message,
                    priority: 'success'
                });
            } else {
                Swal.fire({
                    title: 'COBANK',
                    text: res.error,
                    priority: 'danger'
                });
            }
        },
        error: function(jqXHR, err) {
            console.log(jqXHR);
            Swal.fire({
                title: 'COBANK',
                text: 'Server error. Please try again',
                priority: 'danger'
            });
        }
    });
}
}

function resetPassword() {
var old_password = $.trim($("#old_password").val());
var password = $.trim($("#new_password").val());
var password_confirmation = $.trim($("#password_confirmation").val());

var check1 = validateProfile(document.getElementById('old_password'), "old_password");
var check2 = validateProfile(document.getElementById('new_password'), "new_password");
var check3 = validateProfile(document.getElementById('password_confirmation'), "password_confirmation");
console.log(check1);
console.log(check2);
console.log(check3);

if (check1 && check2 && check3) {

    var msg = '';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '<?php echo url('/admin/change_password') ?>',
        type: 'post',
        dataType: "json",
        data: {
            'current_password': old_password,
            'password': password,
            'password_confirmation': password_confirmation
        },
        success: function(res) {
            console.log(res);
            if (res.status) {
                Swal.fire({
                    title: 'COBANK',
                    text: res.message,
                    priority: 'success'
                }, function() {
                    $('#changeModal').hide();
                    $('#changepass')[0].reset();
                    $("#profileModal").modal("hide");
                });
            } else {
                Swal.fire({
                    title: 'COBANK',
                    text: res.error,
                    priority: 'danger'
                });
            }
        },
        error: function(jqXHR, err) {
            console.log(jqXHR);
            Swal.fire({
                title: 'COBANK',
                text: 'Server error. Please try again',
                priority: 'danger'
            });
        }
    });
}
}


function validateProfile(field, type) {
if (type == "edit_name") {

    var val = field.value;

    if (val.length > 0) {
        $('#edit_name_msg').html('');
        return true;
    } else {
        $('#edit_name_msg').html('Please enter name');
        return false;
    }

} else if (type == "edit_email") {

    var mail = field.value;
    if (mail.length > 0) {
        var mailformat =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (mailformat.test(mail)) {
            $('#edit_email_msg').html('');
            return true;
        } else {
            $('#edit_email_msg').html('Please enter valid email');
            return false;
        }
    } else {
        $('#edit_email_msg').html('Please enter valid email');
        return false;
    }

} else if (type == "edit_phone") {

    var val = field.value;
    if (val.length == 10 && (val.charAt(0) == '6' || val.charAt(0) == '7' || val.charAt(0) == '8' || val.charAt(
            0) == '9')) {
        $('#edit_phone_msg').html('');
        return true;
    } else {
        $('#edit_phone_msg').html('Please enter valid phone number');
        return false;
    }
} else { // pasword

    var val = field.value;
    if (val.length >= 6) {
        $('#' + type + '_msg').html('');
        return true;
    } else {
        $('#' + type + '_msg').html('Please enter valid password (Minimum 6 letters) ');
        return false;
    }
}
}
</script>




@endpush