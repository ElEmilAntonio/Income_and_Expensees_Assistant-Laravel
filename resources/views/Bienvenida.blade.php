@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                   <p class="row justify-content-center"><b>Tu Cuenta ah sido creada con exito</b></p>
                 <p class="row justify-content-center">   <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/redirigir'" method="POST">
                        Ingresar
                    </button></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
