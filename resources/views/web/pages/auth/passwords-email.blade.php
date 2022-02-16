@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Запрос пароля'"></x-h1>
    <p>Выберите, какую информацию использовать для изменения пароля:</p>
    @if (session('status'))
        <p role="alert" style="color: green;">{{session("status")}}</p>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Логин или email:</label>

            <div>
                <input id="email" type="email" class=" @error('email') has-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="error-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <p>Контрольная строка для смены пароля, а также ваши регистрационные данные, будут высланы вам по email.</p>
        </div>

        <div>
            <button type="submit">Выслать</button>
        </div>
    </form>
@endsection
