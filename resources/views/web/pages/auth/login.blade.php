@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Авторизация'"></x-h1>

    <div class="content__white-block">
        <div class="contact-single">
            <p><b>Авторизуйтесь, чтобы увидеть свои заказы.</b></p>
            <p>При оформлении заказа Логину присвоено название указанного Вами Email, а пароль сгенерирован автоматитчески и выслан на этот Email.</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <div class="form-group__item">
                    <label for="email">Логин:</label>

                    <div>
                        <input class="form-control" id="email" type="email" class=" @error('email') has-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="error-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group__item">
                    <label for="password">Пароль:</label>

                    <div>
                        <input class="form-control" id="password" type="password" class=" @error('password') has-error @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="error-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group__item">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        Запомнить пароль
                    </label>
                </div>

                <div class="form-group__item">
                    <button type="submit" class="btn-submit">
                        Войти
                    </button>
                    <p class="form-group__text">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Забыли свой пароль?
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
