<!DOCTYPE html>
<html lang="en">

    <head>
        @include('superadmin.Backend.Layout.common-head')
    </head>

    <body class="g-sidenav-show  bg-gray-100">
        


         @include('superadmin.Backend.Layout.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
                @include('superadmin.Backend.Layout.header')
                

                @section('main-content')
                @show
                @include('superadmin.Backend.Layout.footer')
        </main>
        @include('superadmin.Backend.Layout.common-end')
        @stack('custom-scripts')

    
    </body>

</html>