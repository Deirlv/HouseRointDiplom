<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'House Roint')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>

        .custom-btn {
            color: green;
            border-color: black;
        }

        .custom-btn:hover {
            background-color: darkgreen;
            color: black;
            border-color: black;
        }

        .form-white.input-group>.form-control:focus {
            border-color: #fff;
            box-shadow: inset 0 0 0 1px #fff;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link:focus {
            color: rgba(255, 255, 255, 0.75);
        }

        .carousel-inner {
            display: flex;
            align-items: center;
            overflow: hidden;
            margin: 0 auto;
        }

        .carousel-item img {
            transition: transform 0.3s ease;
            object-fit: contain;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <img src="{{ asset('logos/logo.png') }}" alt="HouseRoint" width="75" height="74" class="me-4">
        <a class="navbar-brand">HouseRoint</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('houses.index') }}">Houses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('logos/account.svg') }}" alt="">
                            Account
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('houses.my') }}">My Houses</a></li>
                            <li><a class="dropdown-item" href="/profile">My Account</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


<section class="hero">
    <div class="container my-4">
        @yield('content')
    </div>
</section>


<footer class="footer">
    <div class="container text-center">
        <p>&copy; 2025 HouseRoint. All rights reserved.</p>
        <p>
            <a href="/privacypolicy">Privacy Policy</a> |
            <a href="/terms">Terms of Service</a>
        </p>
    </div>
</footer>
</body>
</html>
