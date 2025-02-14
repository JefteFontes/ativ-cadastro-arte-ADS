@extends('app')

@section('content')
    <h1>Login</h1>
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label>Usuário:</label>
        <input type="text" name="username">

        <label>Senha:</label>
        <input type="password" name="password">

        <button type="submit">Entrar</button>
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection