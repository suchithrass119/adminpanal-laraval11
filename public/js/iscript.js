$(document).ready(function () {

  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  // $("#loginform").validate({
  //   rules: {
  //     username: "required",
  //     password: "required",
  //     captcha: "required"
  //   },
  //   messages: {
  //     username: "Please Enter Username",
  //     password: "Please Enter Password",
  //     captcha: "Please Enter Captcha"
  //   },
  //   tooltip_options: {
  //     username: { placement: 'right' },
  //     password: { placement: 'right' },
  //     captcha: { placement: 'right' }
  //   }
  //
  // });



  $("#loginbtn").click(function () {
    // var checklog = $("#loginform_admin").valid();
    // if (checklog) {

      var username = $.trim($("#username").val());
      var password = $.trim($("#password").val());
      var captcha = $.trim($("#captcha").val());
      var _token = $.trim($("#_token").val());
      if(!username)
      {
        alert('Enter Username');
        return false;
      }
      if(!password)
      {
        alert('Enter Password');
        return false;
      }
      if(!captcha)
      {
        alert('Enter captcha');
        return false;
      }
      $("#error_msg").html('');

      $.ajax({
        url: APP_URL + '/admin/getLogin',
        type: 'post',
        dataType: "json",
        data: { 'username': username, 'password': password, 'captcha': captcha, "_token": _token},
        success: function (data) {

          if ($.trim(data.message) == 'valid') {
            if ($.trim(data.status) == '1') {
            window.location.href = APP_URL + '/admin/adminhome';
            } else {
              $("#error_msg").html("ACCESS DENIED");
            }
          } else if ($.trim(data.message) == 'invalid') {
            var msg = '';
            if (data.error.msg) {
              $("#error_msg").html(data.error.msg);
            } else if (data.error.msg_active) {
              alert(data.error.msg_active);
              location.reload();
            } else {
              if (data.error.username)
                msg += data.error.username + '<br>';
              if (data.error.password)
                msg += data.error.password + '<br>';
              if (data.error.captcha)
                msg += data.error.captcha;
              $("#error_msg").html(msg);
            }
          }
        },//success
        complete: function (data) {
          refreshCaptcha();
        }
      });//ajax
    // }
  });//loginbtn admin




  $('#username').on('keypress', function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      $('#password').focus();
    }
  });
  $('#password').on('keypress', function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      $('#loginbtn').click();
    }
  });

});
//document ready
