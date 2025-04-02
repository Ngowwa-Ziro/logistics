@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Dashboard</h6>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('images/images.png') }}" class="rounded-circle" width="30" height="30" alt="Profile">
                    <span class="ml-2">{{ Auth::user()->name }}</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                        <i class="fas fa-user"></i> View Profile
                    </a>
                    <a class="dropdown-item" href="/">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(function (dropdown) {
            new bootstrap.Dropdown(dropdown);
        });
    });
</script>
@endsection
