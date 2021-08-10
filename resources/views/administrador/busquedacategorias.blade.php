  @extends('layouts.app')

  @section('content')
  <?php 
  $total=0; 
  $totalingresos=0;
  
  $sumadias=0;
  $sumaegresos=0;
  $sumaingresos=0;
  $arraycategorias=array();
   ?>

  <div class="container">
      <div class="row">
    
  <h1>Busqueda de los gastos de {{$categoria}} </h1>
  <h2>Periodo {{$fechaanterior}} - {{$fechasiguiente}}</h2>
    <br>
   <form  method="POST"  action="{{ url('buscar')}}" enctype="multipart/form-data">
                      @csrf
                      {{ csrf_field() }}
                      {{ method_field('POST') }}
  <label for="start">Fecha inicial:</label>

  <input type="date" id="fechaanterior" name="fechaanterior"
         value="{{$fechaanterior}}"/>
         <label for="start">Fecha final:</label>

  <input type="date" id="fechasiguiente" name="fechasiguiente"
         value="{{$fechasiguiente}}"/>
  <button class="btn btn-sm btn-primary" type="submit">
  Buscar Dias    
  </button>
  </form>  
   <div class="panel-body">

          <table class="table table-sm table-hover w-100">
              <thead>
               <th scope="col">Fecha</th>
               <th scope="col">Categoria</th>
               <th scope="col">Razon</th>
               <th scope="col">Gasto</th>
               
           </thead>
           @if(count($tablagastos) > 0)
           <tbody>
             
              @foreach($tablagastos as $gasto)
                         @foreach($egresos as $egreso)
                @if($egreso->id==$gasto->id_egreso)
                <tr
                onclick="location.href='/gestion_dia/{{$egreso->fecha}}'" method="GET">
                <td align="center" class="table-text"><div><b>{{$egreso->fecha}}</b></div></td>
                @endif
                @endforeach
              
                  <td align="center" class="table-text"><div>{{$categoria}}</div></td>
                <td align="center" class="table-text"><div>{{$gasto->razon}}</div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($gasto->costo,2) ?></div></td>    
          </tr>
          @endforeach
      </tbody>
  </table>
  @endif
   
  </div>
      </div>
      </div> 
  @endsection
