<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bikroyik :: Login</title>
    <link rel="icon" class="img-circle elevation-2" href="{!! asset('dist/img/logo.png') !!}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/themes/default.min.css" />

  <style>
        :root {
        --background: #1a1a2e;
        --color: #ffffff;
        --primary-color: #0f3460;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            box-sizing: border-box;
            font-family: "poppins";
            background: var(--background);
            color: var(--color);
            letter-spacing: 1px;
            transition: background 0.2s ease;
            -webkit-transition: background 0.2s ease;
            -moz-transition: background 0.2s ease;
            -ms-transition: background 0.2s ease;
            -o-transition: background 0.2s ease;
        }

        a {
            text-decoration: none;
            color: var(--color);
        }

        h1 {
            font-size: 2.5rem;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            position: relative;
            width: 22.2rem;
        }
        .form-container {
            border: 1px solid hsla(0, 0%, 65%, 0.158);
            box-shadow: 0 0 36px 1px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            backdrop-filter: blur(20px);
            z-index: 99;
            padding: 2rem;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
        }

        .login-container form input {
            display: block;
            padding: 14.5px;
            width: 100%;
            margin: 2rem 0;
            color: var(--color);
            outline: none;
            background-color: #9191911f;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            letter-spacing: 0.8px;
            font-size: 15px;
            backdrop-filter: blur(15px);
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }

        .login-container form input:focus {
            box-shadow: 0 0 16px 1px rgba(0, 0, 0, 0.2);
            animation: wobble 0.3s ease-in;
            -webkit-animation: wobble 0.3s ease-in;
        }

        .login-container form button {
            background-color: var(--primary-color);
            color: var(--color);
            display: block;
            padding: 13px;
            border-radius: 5px;
            outline: none;
            font-size: 18px;
            letter-spacing: 1.5px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            margin-bottom: 2rem;
            transition: all 0.1s ease-in-out;
            border: none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transition: all 0.1s ease-in-out;
            -moz-transition: all 0.1s ease-in-out;
            -ms-transition: all 0.1s ease-in-out;
            -o-transition: all 0.1s ease-in-out;
        }

        .login-container form button:hover {
            box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.15);
            transform: scale(1.02);
            -webkit-transform: scale(1.02);
            -moz-transform: scale(1.02);
            -ms-transform: scale(1.02);
            -o-transform: scale(1.02);
        }

        .circle {
            width: 8rem;
            height: 8rem;
            background: linear-gradient(135deg, #EA580C, #1E40AF);
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            position: absolute;
        }

        .illustration {
            position: absolute;
            top: -14%;
            right: -2px;
            width: 90%;
        }

        .circle-one {
            top: 0;
            left: 0;
            z-index: -1;
            transform: translate(-45%, -45%);
            -webkit-transform: translate(-45%, -45%);
            -moz-transform: translate(-45%, -45%);
            -ms-transform: translate(-45%, -45%);
            -o-transform: translate(-45%, -45%);
        }

        .circle-two {
            bottom: 0;
            right: 0;
            z-index: -1;
            transform: translate(45%, 45%);
            -webkit-transform: translate(45%, 45%);
            -moz-transform: translate(45%, 45%);
            -ms-transform: translate(45%, 45%);
            -o-transform: translate(45%, 45%);
        }

        .register-forget {
            margin: 1rem 0;
            display: flex;
            justify-content: space-between;
        }
        .opacity {
            opacity: 0.6;
        }
        @keyframes wobble {
            0% {
                transform: scale(1.025);
                -webkit-transform: scale(1.025);
                -moz-transform: scale(1.025);
                -ms-transform: scale(1.025);
                -o-transform: scale(1.025);
            }
            25% {
                transform: scale(1);
                -webkit-transform: scale(1);
                -moz-transform: scale(1);
                -ms-transform: scale(1);
                -o-transform: scale(1);
            }
            75% {
                transform: scale(1.025);
                -webkit-transform: scale(1.025);
                -moz-transform: scale(1.025);
                -ms-transform: scale(1.025);
                -o-transform: scale(1.025);
            }
            100% {
                transform: scale(1);
                -webkit-transform: scale(1);
                -moz-transform: scale(1);
                -ms-transform: scale(1);
                -o-transform: scale(1);
            }
        }
        .img-container {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .img-container img {
            width: 200px;
            height: 50px;
            /* height: auto; */
            /* background-color: rgb(52, 58, 64); */
            /* border-radius: 50%; */
        }
        .copyright {
            position: fixed;
            bottom: 10px;
            right: 10px;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            color: #dfdfdf;
            z-index: 100;
        }

        .copyright a {
            color: #ff2020;
            text-decoration: none;
        }

        .copyright a:hover {
            text-decoration: underline;
        }
  </style>

</head>
<body>
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success("{{ session('success') }}");
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                alertify.set('notifier', 'position', 'top-right');
                @foreach ($errors->all() as $error)
                    alertify.error("{{ $error }}");
                @endforeach
            });
        </script>
    @endif
    <div class="form-structor">
        <section class="container">
            <div class="img-container">
                <img alt="Bikroyik" src="{{ asset('dist/img/walock.png') }}" class="img elevation-2">
            </div>
            <div class="login-container">
                <div class="circle circle-one"></div>
                <div class="form-container">
                    <h1 class="opacity">LOGIN</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="submit" class="opacity">SUBMIT</button>
                    </form>
                </div>
                <div class="circle circle-two"></div>
            </div>
        </section>
    </div>

    <!-- Copyright Section -->
    <div class="copyright">
        <strong>Copyright
            <i class="fas fa-copyright"></i>
            <a href="https://inovexidea.com/">INovex Idea Solution</a>.
        </strong>
        All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
    <!-- partial -->

</body>
</html>
