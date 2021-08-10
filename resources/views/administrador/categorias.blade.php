@extends('layouts.app')

@section('content')
@if($ver!=null)
<element onload="myfunction">
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
       <div class="panel panel-default">
    <div class="panel-heading">
    </div>
    <div class="panel-body">
        <table class="table table-striped ">
            <thead>
             <th style="padding:1px">Categorias</th>
             <th style="padding:1px"></th>
             <th style="padding:1px"></th>
         </thead>
         @if (count($categorias) > 0)
         <tbody>
            @foreach ($categorias as $categoria)
            @if($categoria->nombre!=="indefinido")
            <tr>
                <td class="table-text" style="padding:1px"><div>{{ $categoria->nombre}}</div></td>
               
                <td style="padding:1px">

                    <button type="submit" class="btn btn-success btn-sm" onclick="location.href='/categorias/{{$categoria->id}}'" method="POST">
                        <i class="fa fa-btn fa-pencil"></i> Editar
                    </button>
            </td>
            <td style="padding:1px">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/eliminar_categoria/{{$categoria->id}}'" method="POST">
                        <i class="fa fa-btn fa-trash"></i> Eliminar
                    </button>
                </form>
                </form>
               
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endif
<button 
    type="button" 
    class="btn btn-primary btn-sm" 
    data-toggle="modal" 
    data-target="#AgregarCategoria">
    Agregar categoria
  </button>
    </div>
</div>

<div class="modal fade" id="modal" 
tabindex="-1" role="dialog" 
aria-labelledby="favoritesModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" 
      id="favoritesModalLabel"></h4>
    </div>
    <div class="modal-body">
      @if($categoriaedit!=null)
         <form  method="POST"  action="{{ url('updatecategoria')}}/{{$categoriaedit->id}}" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

                    <div class="form-group row">
                        <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="categoriaedit" type="text" class="form-control @error('categoria') is-invalid @enderror" name="categoriaedit" value="{{$categoriaedit->Nombre}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    </div>
                   
      <div class="modal-footer">
        <button type="button" 
           class="btn btn-default" 
           data-dismiss="modal">Cancelar</button>
        <span class="pull-right">
          <button type="submit" class="btn btn-primary">
                            Guardar Cambios
                        </button>
                      </form>
                         @endif
        </span>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="AgregarCategoria" 
tabindex="-1" role="dialog" 
aria-labelledby="AgregarAsistenciaModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div><a class="row justify-content-center">NUEVA Categoria</a>
    <form  method="POST" action="{{ route('Guardar_Categoria') }}" enctype="multipart/form-data">
      @csrf
      {{ csrf_field() }}
      {{ method_field('POST') }}
      <div class="modal-body">
        <div class="form-group row">
                        <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="nombre" >
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
      </div>
      <div class="modal-footer">
       <span class="pull-left">
        <button type="button" 
        class="btn btn-default" 
        data-dismiss="modal">Cancelar</button>
      </span>
      <span class="pull-right">
        <button type="submit" class="btn btn-primary">
          {{ __('Agregar Categoria') }}
        </button>
      </form>
    </span>
  </div>
</div>
</div>
</div>

<div class="modal fade" id="modaleditar" 
tabindex="-1" role="dialog" 
aria-labelledby="AgregarAsistenciaModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
       @if($categoriaedit!=null)
      <span aria-hidden="true">&times;</span></button>
    </div><a class="row justify-content-center">Editar Categoria</a>
    <form  method="POST" action="{{ url('editar_categoria')}}/{{$categoriaedit->id}}" enctype="multipart/form-data">
  
       @csrf
      {{ csrf_field() }}
      {{ method_field('POST') }}
      <div class="modal-body">
        <div class="form-group row">
                        <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="categoria" type="text" class="form-control @error('categoria') is-invalid @enderror" name="nombre" value="{{$categoriaedit->nombre}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
      </div>
      @endif
      <div class="modal-footer">
       <span class="pull-left">
        <button type="button" 
        class="btn btn-default" 
        data-dismiss="modal">Cancelar</button>
      </span>
      <span class="pull-right">
        <button type="submit" class="btn btn-primary">
          {{ __('Editar Categoria') }}
        </button>
      </form>
    </span>
  </div>
</div>
</div>
</div>
@endsection

<script>
  function myfunction() {
    $('#modaleditar').modal('show');
  }
</script>