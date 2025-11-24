<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ url('/') }}">BoF Careers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-4">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Job</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tracking</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a href="{{ route('login') }}" class="btn btn-dark px-3">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-outline-dark px-3">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
