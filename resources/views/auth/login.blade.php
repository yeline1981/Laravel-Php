@extends('auth.auth')

@section('login')

<div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
            <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
              {{ csrf_field() }}    
              <div class="card-body">
                <h1>Imprenta Express</h1>
                <p class="text-muted">Iniciar sesión</p>

                <div class="input-group mb-3 {{$errors->has('login' ? 'is-invalid' : '')}}">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>                    
                  </div>                  
                  <input type="text" value="{{old('login')}}" name="login" id="login" class="form-control" placeholder="Nombre de usuario">
                  {!!$errors->first('login','<span class="invalid-feedback d-block">:message</span>')!!}
                </div>

                <div class="input-group mb-4 {{$errors->has('password' ? 'is-invalid' : '')}}">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                  {!!$errors->first('password','<span class="invalid-feedback d-block">:message</span>')!!}
                </div>

                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-primary px-4" type="submit">Acceder</button>
                  </div>                  
                </div>
              </div>
            </form>  
            </div>
            <div class="card text-white bg-success py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                <br>
                  <br>
                  <h3>Impresos de Calidad en Tiempo Record</h3>
                  <!-- 
                  <br>
                  <br>
                  <h6>Impresos de Calidad en Tiempo Record</h6>
                  -->
                                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
