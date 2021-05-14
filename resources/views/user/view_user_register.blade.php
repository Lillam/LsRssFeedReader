@extends('main.main')
@section('body')
    <div class="register flex-full flex-center">
        <div>
            <form class="fancy-form" method="post" action="{{ route('register') }}">
                @csrf
                <div class="input-wrapper {{ $errors->has('email') ? 'error' : '' }}">
                    <input id="email" type="email"
                           name="email"
                           autocomplete="off"
                           value="{{ old('email') }}" placeholder="Enter Email"
                    /><label for="email" class="placeholder">Email</label>
                    @if($errors->has('email'))
                        <p>{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="input-wrapper {{ $errors->has('username') ? 'error' : '' }}">
                    <input id="username" type="text"
                           name="username"
                           autocomplete="off"
                           value="{{ old('username') }}" placeholder="Enter Email"
                    /><label for="username" class="placeholder">Username</label>
                    @if($errors->has('username'))
                        <p>{{ $errors->first('username') }}</p>
                    @endif
                </div>
                <div class="input-wrapper {{ $errors->has('password') ? 'error' : '' }}">
                    <input id="password" type="password"
                           name="password"
                           autocomplete="off"
                           placeholder="Password"
                    /><label for="password" class="placeholder">Password</label>
                    @if($errors->has('password'))
                        <p>{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div>
                    <button type="submit">Register</button>
                </div>
                <div class="form-info">
                    <p>If for some reason, you are already registered, you then you can <a href="{{ route('login') }}">login here</a></p>
                </div>
            </form>
        </div>
        <div class="title-block">
            <div>
                <h1>{{ env('APP_NAME') }}</h1>
                <p>Register now and begin your RSS Feed collection spree!</p>
            </div>
        </div>
    </div>
@endsection
