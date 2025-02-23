@extends('app')

@section('content')
    <div class="container-login flex flex-row-reverse">
        <!-- Área do Registro -->
        <div class="login-form">
            <img src="{{ asset('images/logo-myarts.png') }}" alt="Logo MyArts" class="logo">

            <form action="{{ route('register') }}" method="post">
                <div class='text-login'>
                    <h1>Crie sua conta no MyArts</h1>
                    <p>Junte-se à comunidade e compartilhe sua arte com o mundo!</p>
                </div>
                
                @if ($errors->any())
                    <ul class="error-messages">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @csrf
                <label for="username">Nome:</label>
                <input type="text" id="username" name="username" required placeholder="Digite seu nome">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">

                <label for="password">Senha:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required placeholder="Digite sua senha">
                    <i class="fa-solid fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                </div>

                <button type="submit">Criar Conta</button>
            </form>

            <div class="register-link">
                <p>Já tem uma conta? <a href="{{ route('login') }}">Logar</a></p>
            </div>
        </div>

        <!-- Área da Imagem -->
        <div class="image-side">
            <div class="incentive-message">
                <h2>Mostre seu talento para o mundo!</h2>
                <p>Cadastre-se e faça parte da nossa comunidade criativa.</p>
            </div>
        </div>
    </div>
@endsection