@extends("layouts.auth")

@section('title')
    Confirma tu cuenta
@endsection

@section('auth-contents')
    <p class="mt-5 text-lg"> Tu cuenta ha sido creada, pero antes de poder iniciar sesión, debes confirmar tu cuenta haciendo click en el enlace que te enviamos a tu correo electrónico. </p>

    @if(session('success'))
        |<x-alert :message="session('success') " />
    @endif
   
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <input 
            type="submit" 
            class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-5 cursor-pointer" 
            value="Reenviar correo de confirmación"
        />
    </form>
@endsection()