<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CodeJournal - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/prism.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark container px-3 rounded">
            <a class="navbar-brand" href="{{ route('home') }}">CodeJournal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('snippets.index') }}">My Snippets</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('snippets.create') }}">Add Snippet</a></li>
                        <li class="nav-item"><form method="POST" action="{{ route('logout') }}" class="p-0 m-0">@csrf<button class="nav-link btn btn-link">Logout ({{ Auth::user()->name ?? Auth::user()->username ?? Auth::user()->email }})</button></form></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        @foreach (['success','info','danger','warning'] as $msg)
            @if(session($msg))
                <div class="alert alert-{{ $msg }}">{{ session($msg) }}</div>
            @endif
        @endforeach

        @yield('content')
    </main>

    <footer class="text-center py-3 mt-4">
        <p class="mb-0">&copy; <span id="footer-year"></span> CodeJournal</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/prism.js"></script>
    <script src="/js/main.js"></script>
    @yield('scripts')
</body>
</html>
