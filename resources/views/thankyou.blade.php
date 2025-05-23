@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="mb-4">Thank You for Taking the Exam!</h2>
    <p class="lead">
        Your exam session has been completed and submitted successfully.
    </p>
    <p>
        You may now close this window or log out of your account.
    </p>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="btn btn-danger mt-3">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
@endsection
