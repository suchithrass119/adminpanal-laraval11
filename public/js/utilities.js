function refreshCaptcha() {
  var captcha = $('.captcha-img');
  var config = captcha.data('refresh-config');
  $.ajax({
    method: 'GET',
    url: APP_URL+'/get_captcha/' + config,
  }).done(function (response) {
    captcha.prop('src', response);
  });
  // var captcha = $('.captcha img');
  // var cap_text = $('#captcha');
  // if (captcha && cap_text) {
  //   console.log();

  //   captcha.attr('src', APP_URL+'/captcha/flat?_='+Math.random());
  //   cap_text.val('');
  //   //    cap_text.focus();
  // }
}
function checkField(field, type) {
  if (type == "password") {
    var password = field.value;
    if (password.length >= 6 ) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Password length should be greater than 6');
    return false;
  }
  else if (type == "email") {
    var mail = field.value;
    var mailformat = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (mailformat.test(mail)) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter valid email id( ex: abc123@gmail.com).');
    return false;
  }
  else if (type == "captcha") {
    var captcha = field.value;
    if (captcha.length > 0) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter captcha');
    return false;
  }
  else if (type == "alt_email") {
    var mail = field.value;
    if (mail) {
      /////  alert('dsadsfds');
      var mailformat = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (mailformat.test(mail)) {
        validationChecks(0, field.id + '_msg', field.id, '');
        return true;
      }
      validationChecks(1, field.id + '_msg', field.id, 'Please enter valid email id( ex: abc123@gmail.com).');
      $('#' + field.id).val('');
      return false;
    }
    else {
      ////alert('fsdfsfsdc');
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
  }
  else if (type == "null") {

    var val = field.value;
    if (val.length > 0) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter required value');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "mobile") {

    var val = field.value;
    if (val.length == 10 && (val.charAt(0) == '7' || val.charAt(0) == '8' || val.charAt(0) == '9' || val.charAt(0) == '6')) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter valid mobile number');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "aadhar") {
    var val = field.value;
    if (val.length == 12) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter valid aadhar number');
      document.getElementById(field.id).focus();
      return false;
    }
  }

  else if (type == "checkbox") {
    var val = field.value;
    if (field.checked == true) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please select checkbox');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "aishe") {
    var val = field.value;
    if (val.length > 2 && parseFloat(val) > 0) {
      validationChecks(0, field.id + '_msg', field.id);
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter your valid AISHE Id');
    return false;
  }
  else if (type == "select") {
    var val = field.value;
    if (val.length) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please select required value');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "date") {
    var val=field.value;
     if(val)
       {
        var pattern=/^\d{1,2}\/\d{1,2}\/\d{4}$/;
             if(pattern.test(val))
             {
             validationChecks(0, field.id + '_msg', field.id, '');
             return true;
             }
             else {
               validationChecks(1, field.id + '_msg', field.id, 'Please select required value');
               document.getElementById(field.id).focus();
               return false;
             }
        }
  }
  else if (type == "ac") {
    /*According to RBI Reserve Bank of India -> The bank should have 9-18 digits*/
    var val = field.value;
    var pattern = /^\d{9,18}$/;
    if (pattern.test(val)) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter valid A/C Number');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "ifsc") {
    /*


    According to Indian Financial System Code on wikipedia

    IFSC Code Format:

    1] Exact length should be 11

    2] First 4 alphabets

    3] Fifth character is 0 (zero)

    4] Last six characters (usually numeric, but can be alphabetic)



    */
    var val = field.value;
    var pattern = /^[A-Za-z]{4}[0][A-Za-z0-9]{6}$/;


    if (val.length == 11 && pattern.test(val)) {
      //alert("Pattern matched");
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }

    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid IFSC code');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "file") {
    //console.log('ifsc');
    //alert('ifsc');
    /*
    fixed by Karter Paul
    The IFSC is an 11-character code with the first four alphabetic characters representing the bank name, and the last six characters (usually numeric, but can be alphabetic) representing the branch. The fifth character is 0 (zero) and reserved for future use
    ref:https://en.wikipedia.org/wiki/Indian_Financial_System_Code
    */
    var val = field.value;

    if (val.length > 0) {
      //alert("Pattern matched");
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }

    validationChecks(1, field.id + '_msg', field.id, 'Please upload required file');
    return false;
  }
  else if (type == "address") {
    var val = field.value;
    var pattern = /^d*[a-zA-Z][a-zA-Z0-9_ \'\.\-\s\,\\\/\(\)]*$/i;
    if (val.length >= 20 && pattern.test(val)) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid address with minimum 20 characters');
    return false;
  }
  else if (type == "s_name") {
    var val = field.value;
    var pattern = /^d*[a-zA-Z][a-zA-Z0-9_ \'\.\-\s\,\\\/\(\)]*$/i;
    if (val.length >= 10 && pattern.test(val)) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid School name with minimum of 10 characters');
    return false;
  }
  else if (type == "pincode") {
    var val = field.value;
    if (val.length >= 6 && val.length <= 8 && val.charAt(0) != '0') {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid pincode');
      document.getElementById(field.id).focus();
      return false;
    }
  }
  else if (type == "ddno") {
    var val = field.value;
    if (val.length >= 6 && parseFloat(val) > 0) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid DD Number with minimum 6 numbers');
    return false;
  }
  else if (type == "phcode") {
    var val = field.value;
    if (val.length >= 3 && val.length <= 5 && parseFloat(val) > 0) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid area code');
    return false;
  }
  else if (type == "faxcode") {
    var val = field.value;
    if (val.length >= 2 && val.length <= 5 && parseFloat(val) > 0) {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid fax code');
    return false;
  }
  else if (type == "landphn") {
    var val = field.value;

    if (val.charAt(0) == '0') {
      var itemId = val.substring(1, val.length);

      var mobileformat = /^\d{4}([-]*)\d{6}$/;

      if (mobileformat.test(itemId) && itemId.length == 10) {
        validationChecks(0, field.id + '_msg', field.id, '');
        return true;
      }
      validationChecks(1, field.id + '_msg', field.id, 'Please enter valid land phone number');
      return false;
    }
    else {
      if (val.length == 10 && (val.charAt(0) == '7' || val.charAt(0) == '8' || val.charAt(0) == '9' || val.charAt(0) == '6')) {
        validationChecks(0, field.id + '_msg', field.id, '');
        return true;
      }
      validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid phone number');
      return false;

    }

  }
  else if (type == "faxnum") {
    var val = field.value;
    if (val.length >= 6 && val.length <= 10 && val.charAt(0) != '0') {
      validationChecks(0, field.id + '_msg', field.id, '');
      return true;
    }
    else {
      validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid FAX number');
      return false;
    }
  }
  else if (type == "logpartner_name") {
    var val = field.value;
    //alert(val);
    var pattern = /^d*[a-zA-Z][a-zA-Z0-9_ \'\.\-\s\,\\\/\(\)]*$/i;
    if (val.length >= 3 && pattern.test(val)) {
      validationChecks(0, field.id + '_msg', field.id, ' ');
      return true;
    }
    validationChecks(1, field.id + '_msg', field.id, 'Please enter a valid Agency name');
    return false;
  }
}
function checkMail(mail_field) {
  var mail = mail_field.value;
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (mail.match(mailformat)) {
    validationChecks(0, mail_field.id + '_msg', mail_field.id, '');
    return true;
  }
  validationChecks(1, mail_field.id + '_msg', mail_field.id, 'Please enter valid email id( ex: abc123@gmail.com).');
  return false;
}
function isOrderdate(event) {
  var inputValue = event.which;
  // allow numbers and / (47) and null (0), backspace (8), del(127) .
  if (!(inputValue >= 47 && inputValue < 58) && (inputValue != 0 && inputValue != 8 && inputValue != 127)) {
    event.preventDefault();
  }
}
function isEmail(event) {
  var inputValue = event.which;
  // allow letters and numbers and whitespaces and null (0), backspace (8), del(127), dot(46), @(64), _(95).
  if (!(inputValue > 47 && inputValue < 58) && !(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8 && inputValue != 127 && inputValue != 46 && inputValue != 64 && inputValue != 95 && inputValue != 45)) {
    event.preventDefault();
  }
}
function isNumber(event) {
  var inputValue = event.which;
  // allow numbers and null (0), backspace (8), del(127) .
  if (!(inputValue > 47 && inputValue < 58) && (inputValue != 0 && inputValue != 8 && inputValue != 127)) {
    event.preventDefault();
  }
}
function isAlphaNumeric(event) {
  var inputValue = event.which;
  // allow letters and numbers and whitespaces and null (0), backspace (8), del(127) .
  if (!(inputValue > 47 && inputValue < 58) && !(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8 && inputValue != 127)) {
    event.preventDefault();
  }
}
function isAlpha(event) {
  var inputValue = event.which;
  // allow letters and whitespaces and null (0), backspace (8), del(127) .
  if (!(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8 && inputValue != 127)) {
    event.preventDefault();
  }
}
function isDate(event) {
  var inputValue = event.which;
  // allow numbers and / (47) and null (0), backspace (8), del(127) .
  if (!(inputValue >= 47 && inputValue < 58) && (inputValue != 0 && inputValue != 8 && inputValue != 127)) {
    event.preventDefault();
  }
}
function isLink(event) {
  var inputValue = event.which;
  // allow letters and numbers and null (0), backspace (8), del(127), dot(46), %(37), _(95), -(45), ?(63), /(47), :(58)
  if (!(inputValue > 47 && inputValue < 58) && !(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 0 && inputValue != 8 && inputValue != 127 && inputValue != 46 && inputValue != 37 && inputValue != 95 && inputValue != 45 && inputValue != 63 && inputValue != 47 && inputValue != 58)) {
    event.preventDefault();
  }
}
function isAlphaDot(event) {
  var inputValue = event.which;
  // allow letters and whitespaces and null (0), backspace (8), del(127), dot(46) .
  if (!(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 32 && inputValue != 0 && inputValue != 8 && inputValue != 127 && inputValue != 46)) {
    event.preventDefault();
  }
}
function isAddress(event) {
  var inputValue = event.which;
  // allow letters and numbers and null (0), backspace (8), del(127), dot(46), /(47), -(45), \(92), space(32), ( (40), ) (41), comma (44), CR (13)
  if (!(inputValue > 47 && inputValue < 58) && !(inputValue > 64 && inputValue < 91) && !(inputValue > 96 && inputValue < 123) && (inputValue != 0 && inputValue != 8 && inputValue != 127 && inputValue != 46 && inputValue != 47 && inputValue != 45 && inputValue != 92 && inputValue != 32 && inputValue != 40 && inputValue != 41 && inputValue != 44 && inputValue != 13)) {
    event.preventDefault();
  }
}
function isHEIname(event) {
  var inputValue = event.which;
  // allow letters and whitespaces and dot(46), -(45), '(39), null (0), backspace (8), del(127), ( (40), ) (41), comma (44).
  if (
    !(inputValue > 64 && inputValue < 91) &&
    !(inputValue > 96 && inputValue < 123) &&
    (
      inputValue != 32 && inputValue != 0 &&
      inputValue != 8 && inputValue != 127 &&
      inputValue != 46 && inputValue != 45 &&
      inputValue != 39 && inputValue != 40 &&
      inputValue != 41 && inputValue != 44
    )) {
    event.preventDefault();
  }
}
function validationChecks(status, msg_field, form_elt, message) {
  if (status == 1) {
    $('#' + msg_field).html(message);
    $('#' + form_elt).attr('style', 'border-color:red');
    //    if(focus==1){
    //      $('#'+form_elt).focus();
    //    }
  }
  else if (status == 0) {
    $('#' + form_elt).attr('style', 'border-color:#707070');
    $('#' + msg_field).html('');
  }
}
function resetDate(field) {
  $(field).parent().parent().find('input[type=text]').val('');
}
function toTitleCase(str) {
  return str.replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
}

function disabled_five_yr_inputs() {

  var aca_yr_comp = $("#academic_years").val();
  var enabled_five_yr_inputs;
  var i;

  // console.log(enabled_five_yr_inputs);
  enabled_five_yr_inputs = parseInt(aca_yr_comp) + parseInt(1);

  for (k = 5; k >= enabled_five_yr_inputs; k--) {
    $(".five_yr_" + k).attr('readonly', true);
    $(".five_yr_" + k).val('X');
    $(".report_five_yr_" + k).text('NA');
    $(".re_five_yr_" + k).text('X');
    $(".five_yr_" + k).removeAttr('onblur');

    $(".five_yr_" + k).css({ "border": "2px solid #000", "cursor": "not-allowed", "opacity": ".7", "color": "#000", "background-color": "#c1b451", "text-align": "center", "font-weight": "bold" });
    $(".re_five_yr_" + k).css({ "opacity": ".7", "color": "#000", "text-align": "center", "font-weight": "bold" });


  }

}
