@extends('app')

@section('content')
    <h1>Cadastro</h1>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <label>Usuário:</label>
        <input type="text" name="username">

        <label>Email:</label>
        <input type="email" name="email">

        <label>Senha:</label>
        <input type="password" name="password">

        <button type="submit">Registrar</button>
    </form>
@endsection