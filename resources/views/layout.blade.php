<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Styles and Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
        <!-- jQuery -->
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <!-- jQuery UI-->
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('css/jquery-ui.min.css') }}"></script>
        <script src="{{ asset('css/datePicker.css') }}"></script>

        <style>
            body {
                /* 使用asset助手函数来获取本地图片的URL，或者直接使用线上图片的URL */
                
                /* 确保背景图片覆盖整个屏幕 */
                height: 100%;
                width: 100%;
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                -moz-background-size: cover;
                -webkit-background-size: cover;
                
                /* 适当的基础样式 */
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
        <header> 
            <nav>
                <div class="nav-container" style="text-align: center;">
                    <div class="nav-item">
                        <a href="/travelInquiry/travel">
                            <img src="/images/Home.png" alt="Create" width="55"> 
                            <div class="nav-text">Create Travel Plan</div>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="/travelInquiry">
                            <img src="/images/view.png" alt="View" width="55"> 
                            <div class="nav-text">View Your Travel Plan</div>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="/register">
                            <img src="/images/register.png" alt="Register" width="55"> 
                            <div class="nav-text">Register</div>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="/login">
                            <img src="/images/login.png" alt="Login" width="55"> 
                            <div class="nav-text">Login</div>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
        <main class="container">
            @yield('content')
            @yield('script')
        </main>
        <script src="{{ asset('js/app.js') }}"></script>
        <footer>
            <div style="text-align: center;">Copyright &copy; 2024 ABK Travels</div>
        </footer>
    </body>
</html>