<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $page_title ?? "MOTOR WELFARE" }}</title>
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">
    <meta name="description"
        content="Kerala Government has became the first State Government in India to establish an Energy Management Centre (Welfare) at State level" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        var APP_URL = '{{ URL::to('/') }}';
    </script>
    @include('admin.layout.style')
    @stack('commonstyle')
</head>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open  accent-purple layout-navbar-fixed">
    <div class="wrapper">
        @include('admin.layout.header')
        @include('admin.layout.sidebar')

        <div class="content-wrapper" style="background-color: #f4f6f9;">
            <section class="content-header">
            </section>
            <section class="content">
                @yield('content','Dashboard')
            </section>
        </div>

        @include('admin.layout.footer')
    </div>

    @include('admin.layout.script')
    @stack('commonjs')
    @stack('masterjs')
    @stack('pagescripts')
</body>

</html>
