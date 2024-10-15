<!DOCTYPE html>
<html lang="en">

    <head>
        @include('Backend.backend/auth.common-head')
    </head>

    <body class="g-sidenav-show  bg-gray-100 pt-0">
        


        <main class="main-content">

                @section('main-content')
                @show

        </main>
        @include('Backend.backend/auth.common-end')
        @stack('custom-scripts')

    
    </body>

</html>