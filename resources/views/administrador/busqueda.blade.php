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
    
  <div  class="col-sm-8">
  <h1>Busqueda por dias </h1>
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

  </button>
          <table class="table table-sm table-hover w-100">
              <thead>
               <th scope="col">Fecha</th>
               <th scope="col">Mañana</th>
               <th scope="col">Tarde</th>
               <th scope="col">Noche</th>
               <th scope="col">Egreso</th>
               <th scope="col">Total</th>   
           </thead>
           @if(count($ingresos) > 0)
           <tbody>
             
              @foreach($ingresos as $ingreso)
              
              <?php
          
              $sumadias++;
              $total=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
              $totalingresos=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
              $sumaingresos+=$totalingresos;
               ?>
                @foreach($egresos as $egreso)
              @if($egreso->fecha===$ingreso->fecha)
              <?php
               $total-=$egreso->egreso;
               $sumaegresos+=$egreso->egreso
                 
               ?>

               @if($total<0)
               
                <tr bgcolor="#ff726f" 
                onclick="location.href='/gestion_dia/{{$ingreso->fecha}}'" method="GET">
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                  <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                  
               @elseif($total>0)
                <tr bgcolor="#98fb98"
                onclick="location.href='/gestion_dia/{{$ingreso->fecha}}'" method="GET" >
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                  <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                     
               @else
                <tr onclick="location.href='/gestion_dia/{{$ingreso->fecha}}'" method="GET">
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                  
             
              @endif
              @endif
              @endforeach      
          </tr>
          @endforeach
      </tbody>
  </table>
  @endif
   
  </form> 
      </div>
  </div>

  <div  class="col-sm-4">
  <H2><b>Datos generales<b></H2>
      <br>
      <div class="row">
      <H3><b>Total de dias: <p id="texto_dias" style="display:inline">{{$sumadias}}</p> <b></H3>
        </div>
           <br>
        <H3><b> Ingresos: <p id="texto_ingreso" style="display:inline">$<?php echo number_format($sumaingresos,2) ?></p> <b></H3>
           <br>
            <H3><b>Egresos: <p id="texto_egreso" style="display:inline">$<?php echo number_format($sumaegresos,2) ?></p><b></H3>
               <br>
                <H3><b>Total: <p id="texto_total" style="display:inline">$<?php echo number_format($sumaingresos-$sumaegresos,2) ?></p><b></H3>
                 <br>
                  <H3><b>Media de ingreso:<p id="texto_egreso" style="display:inline">$<?php echo number_format(($sumaingresos/count($ingresos)),2) ?></p><b></H3>
            <H3><b>Media de egreso:<p id="texto_egreso" style="display:inline">$<?php echo number_format(($sumaegresos/count($ingresos)),2) ?></p><b></H3>
      <br>
    <h2><b> gastos por categorias</b></h2>
    <br>
    <table class="table table-sm table-hover w-100">
              <thead>
               <th scope="col">Categoria</th>
               <th scope="col">Gasto Total</th>   
           </thead>
           @if(count($ingresos) > 0)
           <tbody>
       @foreach($tablagastos as $gasto)
       <?php $totalgasto=0; ?> 
       @if(!in_array($gasto->categoria,$arraycategorias))
       <?php array_push($arraycategorias,$gasto->categoria);?>
       @foreach($tablagastos as $gastocategoria)
       @if($gasto->categoria==$gastocategoria->categoria)
       <?php $totalgasto+=$gastocategoria->costo; ?>
       @endif
       @endforeach
         <tr onclick="location.href='/buscar_categoria/{{$gasto->categoria}}/{{$fechaanterior}}/{{$fechasiguiente}}'" method="GET">
        @foreach($categorias as $categoria)
        @if($categoria->id==$gasto->categoria)
       <td align="center" class="table-text"><div><b>{{$categoria->nombre}}</b></div></td>
        @endif
        @endforeach
        <td align="center" class="table-text"><div>$<?php echo number_format($totalgasto,2) ?></div></td>
          <?php array_push($arraycategorias,$gasto->categoria); ?>
       @endif
       </tr>
       @endforeach
      </tbody>
      </table>
      @endif
  </div>    

  </div>
  </div>
  @endsection
