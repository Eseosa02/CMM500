<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.css')
    </head>
    <body data-anm=".anm">
        <div class="page-wrapper">
            <!-- Preloader -->
            <div class="preloader"></div>
            
            @include('_partials.main.header')
            
            @yield("content")

            @include('_partials.main.footer')
        </div><!-- End Page Wrapper -->
        @include('layouts.js')
        @yield("script")
        @yield("script2")
    </body>
</html>