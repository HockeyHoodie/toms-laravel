@extends('layouts.app')

@section('title', 'Log in | Budgetly')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-heading">
                <div class="brand-icon brand-icon-large">B</div>
                <h1>Welcome back</h1>
                <p>Log in to manage your finances.</p>
            </div>

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                        autofocus
                        class="@error('email') input-error @enderror"
                    >

                    @error('email')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    @error('password')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>

                <button type="submit" class="btn btn-primary btn-block">
                    Log in
                </button>
            </form>

            <p class="auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create one</a>
            </p>

            <div class="demo-credentials">
                <strong>Demo account</strong>
                <p>Email: demo@example.com</p>
                <p>Password: password123</p>
            </div>
        </div>
    </div>
@endsection
