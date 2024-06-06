
<!DOCTYPE html>
<html lang="en">
<script type="text/javascript">
    var APP_URL = '{{ URL::to("/") }}';
</script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Motor Welfare</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" media="all" />

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.min.css') }}" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}" media="all" />


</head>

<body class="hold-transition login-page">
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
    <section class="background-radial-gradient overflow-hidden">

<div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
  <div class="row gx-lg-5 align-items-center mb-5">
    <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
      <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
        Motor Department<br />
        <span style="color: hsl(218, 81%, 75%)">Welfare Fund Board</span>
      </h1>
      <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
        Temporibus, expedita iusto veniam atque, magni tempora mollitia
        dolorum consequatur nulla, neque debitis eos reprehenderit quasi
        ab ipsum nisi dolorem modi. Quos?
      </p>
    </div>

    <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
      <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
      <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

      <div class="card bg-glass">
        <div class="card-body px-4 py-5 px-md-5">
          <form method="post">
            <input type="hidden" name="_token"  id="_token" value="{{ csrf_token() }}" autocomplete="off">
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row">
              <div class="col-md-6 mb-4">
                <div data-mdb-input-init class="form-outline">
                  &nbsp;
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div data-mdb-input-init class="form-outline">
                  &nbsp;
                </div>
              </div>
            </div>

            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="text" id="username" name="ussername" class="form-control" autofocus />
              <label class="form-label" for="username">Username</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="password" id="password"  name="password" class="form-control" >
              <label class="form-label" for="password">Password</label>
            </div>

            <div class='row align-items-center'>
              <div class='col-md-6'>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text"   id="captcha" name="captcha" class="form-control p-4"  onkeypress="isAlphaNumeric(event)" onblur="checkField(this,'captcha')" maxlength="6" >
                <label class="form-label" for="password">Captcha</label>
              </div>
                  

              </div>
              <div class='col-md-6 text-right d-flex justify-content-end align-items-center'>
                  <img src="{{ captcha_src('flat'); }}" alt="captcha" class="captcha-img" data-refresh-config="flat" style="margin-bottom:15px;">
                  <span class="fas fa-redo ml-2" title="Refresh captcha" style="cursor:pointer;margin-bottom:15px;" onclick="refreshCaptcha()"></span>
              </div>
          </div>
          <br>


            <!-- Submit button -->
            <button type="button" id="loginbtn" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
              Sign up
            </button>
            <br>
            <div class="row">
                <div class="col">
                    <div id="error_msg" class="text-center text-danger mt-1" style="font-family: sans-serif;color:red;">
                    </div>
                </div>
            </div>


            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
    <!-- /.login-box -->

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/iscript.js') }}"></script>
    <script src="{{ asset('js/utilities.js') }}"></script>

</body>

</html>
