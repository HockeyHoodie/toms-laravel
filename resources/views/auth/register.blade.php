@extends('layouts.app')

@section('title', 'Create account | Budgetly')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-heading">
                <div class="brand-icon brand-icon-large">B</div>
                <h1>Create your account</h1>
                <p>Start taking control of your money.</p>
            </div>

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Full name</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your name"
                        autocomplete="name"
                        maxlength="255"
                        required
                        class="@error('name') input-error @enderror"
                    >

                    @error('name')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

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
                        placeholder="At least 8 characters"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="@error('password') input-error @enderror"
                    >

                    @error('password')
                        <small class="field-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Enter your password again"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Create account
                </button>
            </form>

            <p class="auth-footer">
                Already have an account?
                <a href="{{ route('login') }}">Log in</a>
            </p>
        </div>
    </div>
@endsection
