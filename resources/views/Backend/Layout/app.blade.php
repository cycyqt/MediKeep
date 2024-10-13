<!DOCTYPE html>
<html lang="en">

    <head>
        @include('Backend.Layout.common-head')
    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2VC6FKHTT6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-2VC6FKHTT6');
    </script>
    <body class="g-sidenav-show  bg-gray-100">
        


         @include('Backend.Layout.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
                @include('Backend.Layout.header')
                

                @section('main-content')
                @show
                @include('Backend.Layout.footer')
        </main>
        @include('Backend.Layout.common-end')
        @stack('custom-scripts')

    
    </body>

</html>