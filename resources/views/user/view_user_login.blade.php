@extends('main.main')
@section('body')
    <div class="login flex-center flex-full">
        <div>
            <form class="fancy-form" method="post" action="{{ route('login') }}">
                @csrf
                <div class="input-wrapper {{ $errors->has('username') ? 'error' : '' }}">
                    <input id="username" type="text"
                           name="username"
                           autocomplete="off"
                           value="{{ old('username') }}" placeholder="Enter Username"
                    /><label for="username" class="placeholder">Username</label>
                    @if($errors->has('username'))
                        <p>{{ $errors->first('username') }}</p>
                    @endif
                </div>
                <div class="input-wrapper {{ $errors->has('password') ? 'error' : '' }}">
                    <input id="password" type="password"
                           name="password"
                           autocomplete="off"
                           placeholder="Enter Password"
                    /><label for="password" class="placeholder">Password</label>
                    @if($errors->has('password'))
                        <p>{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div>
                    <button type="submit">Login</button>
                </div>
                <div class="form-info">
                    <p>If you have not yet got an account, but for some reason would absolutely love an account, you can <a href="{{ route('register') }}">register</a> and begin your RSS Feed collection spree today!</p>
                </div>
            </form>
        </div>
        <div class="title-block">
            <div>
                <h1>{{ env('APP_NAME') }}</h1>
                <p>Sign in now to begin your RSS Feed collection spree!</p>
            </div>
        </div>
    </div>
@endsection
