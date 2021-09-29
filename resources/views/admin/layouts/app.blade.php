<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>@yield('title') | 7Stock Holding Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
@include('admin.layouts.partials.appcss')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-sidebar="dark">
    <div id="layout-wrapper">
        @include('admin.layouts.partials.appheader')
        @include('admin.layouts.partials.leftsidebar')
        <div class="main-content">
            <div class="page-content">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
        @include('admin.layouts.partials.footer')
    </div>
    @include('admin.layouts.partials.appjavascript')
</body>
</html>