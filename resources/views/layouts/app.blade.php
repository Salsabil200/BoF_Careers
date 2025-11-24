<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'BoF Careers')</title>

  {{-- Bootstrap CSS (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  {{-- Vite jika kamu ingin gunakan asset lokal --}}
  @vite(['resources/js/app.js'])

  <style>
    /* ===== Navbar styling sesuai contoh ===== */
    .nav-soft {
      background: #f7f8fb;
      border-bottom: 1px solid #e5e7eb;
    }
    .nav-soft .navbar-brand {
      font-weight: 600;
      font-size: 1.25rem;
      color: #111827;
    }
    .nav-soft .nav-link {
      color: #6b7280;
      padding: .5rem .75rem;
      transition: 0.2s;
    }
    .nav-soft .nav-link.active,
    .nav-soft .nav-link:hover {
      color: #111827;
      font-weight: 600;
    }
    .btn-soft {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,.1);
    }
    .btn-soft-outline {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,.08);
    }
  </style>
</head>

<body>

  {{-- ========== NAVBAR ========== --}}
  <nav class="navbar navbar-expand-lg navbar-light nav-soft py-3">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand" href="{{ route('home') }}">BoF Careers</a>

      <!-- Mobile toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-3">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('job') ? 'active' : '' }}" href="{{ route('job') }}">Job</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tracking') ? 'active' : '' }}" href="{{ route('tracking') }}">Tracking</a>
          </li>
        </ul>

        <!-- Right side buttons -->
        <ul class="navbar-nav ms-auto align-items-center">
          @guest
            <li class="nav-item me-2">
              <a href="{{ route('login') }}" class="btn btn-dark btn-soft px-4 py-2">Login</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-outline-dark btn-soft-outline px-4 py-2">Sign Up</a>
            </li>
          @else
            <li class="nav-item">
              <a href="#" class="btn btn-outline-dark btn-soft-outline px-4 py-2"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  {{-- ========== MAIN CONTENT ========== --}}
  <main>
    @yield('content')
  </main>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
          crossorigin="anonymous"></script>
</body>
</html>
