@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<?php $total=0; ?>
<div class="container">
   @if($registrocorte==null)
       <h2><b>Gestión de la fecha {{$detalleingreso->fecha}} Sin registrar</b></h2>
        @else
       <h2><b>Gestión de la fecha {{$detalleingreso->fecha}} Registrado al corte: {{$registrocorte->inicio}} / {{$registrocorte->final}}</b></h2>
        @endif
  <hr>
 <div class="panel">
    <div class="panel-body">
  <table class="table table-sm w-100">
    <?php
         $totalingreso=$detalleingreso->manana+$detalleingreso->tarde+$detalleingreso->noche;
        $totalabsoluto=$totalingreso-$detallegreso->egreso;
         ?>
            <h4><b>Resumen</b></h4>
            <thead>
             <th scope="col"><p style="font-size:25px">Ingreso: $<?php echo number_format($totalingreso,2) ?> </p></th>
             <th scope="col"><p style="font-size:25px">Egreso: $<?php echo number_format($detallegreso->egreso,2) ?> </p></th>
             <th scope="col"><p style="font-size:25px">Total: $<?php echo number_format($totalabsoluto,2) ?></p></th>    
         </thead>
         <tbody></tbody>
</table>
</div>
</div>
   <div class="panel">
    <div class="panel-body">
  <table class="table table-sm w-100">
            <h4><b>Ingresos </b><button 
    type="button" 
    class="btn btn-success" 
    data-toggle="modal" 
    data-target="#Editaringresos">
    Asignar Ingresos
  </button></h4>
            <thead>
             <th scope="col">Mañana</th>
             <th scope="col">Tarde</th>
             <th scope="col">Noche</th>
             <th scope="col">Total Ingreso</th>        
         </thead>
         <tbody>       
            <tr>
               <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->manana,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->tarde,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->noche,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($totalingreso,2) ?></div></td>
        </tr>
    </tbody>
</table>
</div>
</div>
 <div class="panel">
    <div class="panel-body">
  <table class="table table-sm w-100">
            <h4><b>Egresos</b><button 
    type="button" 
    class="btn btn-danger" 
    data-toggle="modal" 
    data-target="#agregaregresos">
    Registrar Egreso
  </button>-<button 
    type="button" 
    class="btn btn-primary" 
    data-toggle="modal" 
    data-target="#editaregresos">
    Editar Egreso
  </button></h4>
            <thead>
             <th scope="col">Categoria</th>
             <th scope="col">Detalles</th>
             <th scope="col">Costo</th>
              <th scope="col">Opciones</th>
         </thead>
         <tbody>       
         @if (count($listaegresos) > 0)
         <tbody>
            @foreach ($listaegresos as $listaegreso)
            
            <tr>
            @foreach($categorias as $categoria)
             @if($categoria->id==$listaegreso->categoria)
             <td align="center" class="table-text"><div>{{$categoria->nombre}}</div></td>
             @endif
            @endforeach
               <td align="center" class="table-text"><div>{{$listaegreso->razon}}</div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($listaegreso->costo,2) ?></div></td>
                <td><div class="row"><button type="submit" class="btn btn-danger btn-sm" onclick="location.href='/destroy_egreso/{{$detallegreso->fecha}}/{{$listaegreso->id}}'" method="GET">Eliminar</button></div></td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
</div>
</div>
</div>

   <button type="submit" class="btn btn-primary" onclick="location.href='/export_excel/{{$detallegreso->id}}'" method="GET">Descargar excel</button>



<div class="modal fade" id="Editaringresos" 
tabindex="-1" role="dialog" 
aria-labelledby="AgregarAsistenciaModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div><a class="row justify-content-center">Ingresos</a>
      <form  method="POST"  action="{{ url('update_ingreso')}}/{{$detalleingreso->fecha}}" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    {{ method_field('POST') }}

      <div class="modal-body">
        <div class="form-group row">
                        <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Mañana') }}</label>

                        <div class="col-md-6">
                            <input id="manana" type="text" class="form-control @error('manana') is-invalid @enderror" name="manana" value="{{$detalleingreso->manana}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Tarde') }}</label>

                        <div class="col-md-6">
                            <input id="tarde" type="text" class="form-control @error('tarde') is-invalid @enderror" name="tarde" value="{{$detalleingreso->tarde}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="noche" class="col-md-4 col-form-label text-md-right">{{ __('Noche') }}</label>

                        <div class="col-md-6">
                            <input id="noche" type="text" class="form-control @error('noche') is-invalid @enderror" name="noche" value="{{$detalleingreso->noche}}">
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
          {{ __('Asignar Ingresos') }}
        </button>
      </form>
    </span>
  </div>
</div>
</div>
</div>





<div class="modal fade bd-example-modal-lg" id="agregaregresos" 
tabindex="-1" role="dialog" 
aria-labelledby="AgregarAsistenciaModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <a class="row justify-content-center"><b>Egresos a registrar para la fecha de: {{$detallegreso->fecha}}</b></a>
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div>
      <form  method="POST"  action="{{ url('create_egreso')}}/{{$detalleingreso->fecha}}" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
      <div class="modal-body">
       @for ($numeroegreso =1; $numeroegreso<=10; $numeroegreso++)
        <div class="form-group row" id="rowegreso{{$numeroegreso}}">
                       <label for="name" class="col-md-1 col-form-label text-md-right">{{ __('Categoria: ') }}</label>

                            <div class="col-md-2">
                        <select id="categoria[{{$numeroegreso}}]" name="categoria[{{$numeroegreso}}]">
                         <option  value="ninguno">--------</option>
                           @if (count($categorias) > 0)
                             @foreach ($categorias as $categoria) 
                        <option  value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                             @endforeach
                            @endif  
                           </select>
                                @error('unidades')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <label for="detalle" class="col-md-1 col-form-label text-md-right">{{ __('Detalle:') }}</label>

                        <div class="col-md-4">
                            <input id="razon[{{$numeroegreso}}]" type="text" class="form-control @error('detalle') is-invalid @enderror" name="razon[{{$numeroegreso}}]">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                          <label for="costo" class="col-md-1 col-form-label text-md-right">{{ __('Costo:') }}</label>

                        <div class="col-md-2">
                            <input id="costo[{{$numeroegreso}}]" type="text" class="form-control @error('costo') is-invalid @enderror" name="costo[{{$numeroegreso}}]" value="0.00">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>
                    @endfor
             
      </div>
      <div class="modal-footer">
       <span class="pull-left">
        <button type="button" 
        class="btn btn-default" 
        data-dismiss="modal">Cancelar</button>
      </span>
      <span class="pull-right">
        <button type="submit" class="btn btn-primary">
          {{ __('Agregar Egresos') }}
        </button>
      </form>
    </span>
  </div>
</div>
</div>
</div>





<?php $numeroedit=0 ?>
<div class="modal fade bd-example-modal-lg" id="editaregresos" 
tabindex="-1" role="dialog" 
aria-labelledby="AgregarAsistenciaModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <a class="row justify-content-center"><b>Lista de egresos de la fecha: {{$detallegreso->fecha}}</b></a>
      <button type="button" class="close" 
      data-dismiss="modal" 
      aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    </div>
      <form  method="POST"  action="{{ url('update_egreso')}}/{{$detalleingreso->fecha}}" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
      <div class="modal-body">
       @if (count($listaegresos) > 0)
            @foreach ($listaegresos as $listaegreso)
            <?php $numeroedit++; ?>
             <div class="form-group row">
             <input id="idedit[{{$numeroedit}}]" type="text" name="idedit[{{$numeroedit}}]" value="{{$listaegreso->id}}" style="display:none">
              <label for="name" class="col-md-1 col-form-label text-md-right">{{ __('Categoria: ') }}</label>
                
                            <div class="col-md-2">
                        <select id="categoriaedit[{{$numeroedit}}]" name="categoriaedit[{{$numeroedit}}]">
                        @foreach($categorias as $categoria)
                         @if($categoria->id==$listaegreso->categoria)
                        <option  value="{{$categoria->id}}" selected>{{$categoria->nombre}}</option>
                         @else
                        <option  value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endif
                   @endforeach
                           </select>
                                @error('unidades')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
        <label for="detalle" class="col-md-1 col-form-label text-md-right">{{ __('Detalle:') }}</label>

                        <div class="col-md-4">
                            <input id="razonedit[{{$numeroedit}}]" type="text" class="form-control @error('detalle') is-invalid @enderror" name="razonedit[{{$numeroedit}}]" value="{{$listaegreso->razon}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                          <label for="costo" class="col-md-1 col-form-label text-md-right">{{ __('Costo:') }}</label>

                        <div class="col-md-2">
                            <input id="costoedit[{{$numeroedit}}]" type="text" class="form-control @error('costo') is-invalid @enderror" name="costoedit[{{$numeroedit}}]" value="{{$listaegreso->costo}}">
                            @error('Link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
      
          </div>
        @endforeach
        @endif
      </div>
      <div class="modal-footer">
       <span class="pull-left">
        <button type="button" 
        class="btn btn-default" 
        data-dismiss="modal">Cancelar</button>
      </span>
      <span class="pull-right">
        <button type="submit" class="btn btn-primary">
          {{ __('Guardar cambios') }}
        </button>
      </form>
    </span>
  </div>
</div>
</div>
</div>






@endsection


<script>
  var cantidadegresos=<?php echo $numeroegreso ?>;
function Agregardiv() {
  cantidadegresos++;
  var newItem = document.createElement("div");
  newItem.className = "form-group row";
  newItem.id="rowegreso"+cantidadegresos;
  newItem.innerHTML = "test";
 var egresoanterior=cantidadegresos-1;
  var div = document.getElementById("rowegreso"+egresoanterior);
var modal_div = document.getElementById("agregaregresos");
modal_div.appendChild(newItem);
//insertAfter(div,newItem);
}
</script>