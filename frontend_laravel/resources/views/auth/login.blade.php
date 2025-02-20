@extends('app')

@section('content')
    <div class="container-login">
        <!-- Área do Login -->
        <div class="login-form">
            <img src="{{ asset('images/logo-myarts.png') }}" alt="Logo MyArts" class="logo">

            <form action="{{ route('login') }}" method="POST">
                <div class='text-login'>
                    <h1>Bem-vindo ao MyArts</h1>
                    <p>Entre e compartilhe sua arte com o mundo!</p>
                </div>
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @csrf
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">

                <label for="password">Senha:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required placeholder="Digite sua senha">
                    <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                </div>
                <button type="submit">Entrar</button>
            </form>
            <div class ="register-link">
                <p>Ainda não possui uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
            </div>
        </div>

        <!-- Área da Imagem -->
        <div class="image-side">
            <div class="incentive-message">
                <h2>Transforme sua criatividade em arte!</h2>
                <p>Cadastre-se e compartilhe suas obras com o mundo.</p>
            </div>
        </div>
    </div>
@endsection
