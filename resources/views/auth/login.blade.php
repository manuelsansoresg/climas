@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-inner card-inner-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title">Iniciar Sesión</h4>
                <div class="nk-block-des">
                    <p>Accede al panel Dashlite usando tu correo electrónico y contraseña.</p>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <label class="form-label" for="default-01">Correo</label>
                </div>
                <div class="form-control-wrap">
                    {{-- <input type="text" class="form-control form-control-lg" id="default-01"
                        placeholder="Ingresa tu correo electrónico o usuario"> --}}
                        <input id="email" type="email"  placeholder="Ingresa tu correo electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <label class="form-label" for="password">Contraseña</label>
                    @if (Route::has('password.request'))
                    
                    <a class="link link-primary link-sm"
                    href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif                   
                </div>
                <div class="form-control-wrap">
                    <a href="#" class="form-icon form-icon-right passcode-switch lg"
                        data-target="password">
                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                    </a>
                    
                    <input id="password" type="password"  placeholder="Ingresa tu contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox text-right">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember">Recordarme</label>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block">Iniciar Sesión</button>
            </div>
        </form>
        <div class="form-note-s2 text-center pt-4"> ¿Nuevo en nuestra plataforma? <a
                href="html/pages/auths/auth-register-v2.html">Crear una cuenta</a>
        </div>
       
    </div>
</div>

@endsection
