@extends('layout')

@section('title','Welcome')

@section('content')
    <div class="hero-section">
        <h1 class="mb-3">Welcome to CodeJournal!</h1>
        <p class="lead">Your personal knowledge base for efficient code snippet management.</p>
        <hr class="my-4 w-50 mx-auto border-light opacity-25">
        @guest
            <p>Ready to organize your code knowledge and boost your productivity?</p>
            <p class="mt-4">
                <a class="btn btn-primary btn-lg me-3" href="{{ route('register') }}">Register Now</a>
                <a class="btn btn-secondary btn-lg" href="{{ route('login') }}">Or Login</a>
            </p>
        @else
            <p class="fs-5 text-light">Hello, {{ Auth::user()->name ?? Auth::user()->username }}! You're logged in and ready to code.</p>
            <p class="mt-4">
                <a class="btn btn-primary me-3" href="{{ route('snippets.create') }}">Add a New Snippet</a>
                <a class="btn btn-secondary" href="{{ route('snippets.index') }}">View My Existing Snippets</a>
            </p>
        @endguest
    </div>

    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <h3 class="text-synapse-accent-green mb-3">Organize</h3>
            <p class="text-light">Keep your code snippets neatly categorized and searchable.</p>
        </div>
        <div class="col-md-4 text-center">
            <h3 class="text-synapse-accent-green mb-3">Learn</h3>
            <p class="text-light">Save solutions and notes for future reference and continuous learning.</p>
        </div>
        <div class="col-md-4 text-center">
            <h3 class="text-synapse-accent-green mb-3">Share</h3>
            <p class="text-light">Optionally share your insights with the community (future feature).</p>
        </div>
    </div>
@endsection
