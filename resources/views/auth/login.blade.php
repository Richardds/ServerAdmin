@extends('root')

@section('body')
    <div class="container">
        <form class="form-signin" method="POST" action="{{ route('login') }}">
            {!! csrf_field() !!}

            <h2 class="text-center">Authentication</h2>

            <label for="username" class="sr-only">Username</label>
            <input id="username" type="text" class="form-control input-top" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

            <label for="password" class="sr-only">Password</label>
            <input id="password" type="password" class="form-control input-bottom" name="password" placeholder="Password" required>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>

            <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            @if($errors->has('username'))
                <span class="help-block error">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </form>
    </div>
@endsection
