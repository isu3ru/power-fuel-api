<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config('system.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('system.description') }}" name="description" />
    <meta content="{{ config('system.developer.company') }}" name="developer" />
    <meta content="{{ config('system.developer.name') }}" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    @include('layouts.partials.styles')
    @stack('styles')
</head>

<body data-topbar="dark" data-sidebar="dark">
    <div id="layout-wrapper">
        @include('layouts.partials.topbar')

        @include('layouts.partials.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @include('layouts.partials.alerts')

                    @include('layouts.partials.breadcrumbs')

                    @yield('content')
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ config('system.title') }}
                        </div>

                        @include('layouts.partials.footer')
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @include('layouts.partials.scripts')
    @stack('scripts')
</body>

</html>
