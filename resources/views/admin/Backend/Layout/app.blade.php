<!DOCTYPE html>
<html lang="en">

    <head>
        @include('admin.Backend.Layout.common-head')
    </head>

    <body class="g-sidenav-show  bg-gray-100">
        


         @include('admin.Backend.Layout.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
                @include('admin.Backend.Layout.header')
                

                @section('main-content')
                @show
                @include('admin.Backend.Layout.footer')
        </main>
        @include('admin.Backend.Layout.common-end')
        @stack('custom-scripts')

    
    </body>

</html>