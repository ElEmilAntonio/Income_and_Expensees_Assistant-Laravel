  @extends('layouts.app')

  @section('content')
  <?php 
  $total=0; 
  $totalingresos=0;
   $añoactual=date("Y");
  $sumadias=0;
  $sumaegresos=0;
  $sumaingresos=0;
   ?>

  <div class="container">
      <div class="row">
   <form  method="POST"  action="{{ url('buscar_dias')}}" enctype="multipart/form-data">
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
  <div  class="col-sm-8">
   <div class="panel-body">

     <form  method="POST"  action="{{ url('guardar_corte')}}" enctype="multipart/form-data">
                      @csrf
                      {{ csrf_field() }}
                      {{ method_field('POST') }}
     <button class="btn btn-bg btn-primary" type="submit">
  Generar corte
  </button>
          <table class="table table-sm table-hover w-100">
              <thead>
               <th scope="col">Fecha</th>
               <th scope="col">Mañana</th>
               <th scope="col">Tarde</th>
               <th scope="col">Noche</th>
               <th scope="col">Egreso</th>
               <th scope="col">Total</th>
               <th scope="col">Seleccionar</th>    
           </thead>
           @if (count($ingresos) > 0)
           <tbody>
              @foreach ($ingresos as $ingreso)
              <?php
              $total=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
              $totalingresos=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
               ?>
                @foreach($egresos as $egreso)
              @if($egreso->id==$ingreso->id)
              <?php
               $total-=$egreso->egreso;
                    $check=0;
               ?>

               @if($total<0)
               
                <tr bgcolor="#ff726f">
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                  <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>s
                   @if($lista_egresosregistrados!=null)
                      <?php
                    $verificador=true;
                     ?>
                     @foreach($lista_egresosregistrados as $egresoregistrado)
                     @if($egresoregistrado->fecha===$egreso->fecha)
                     <?php $verificador=false; ?>
                     @endif
                     @endforeach
                      @if($verificador)
                     <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                     @else
                      <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                     @endif
              
                   @else
                    <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                   @endif
                  
               @elseif($total>0)
                <tr bgcolor="#98fb98" >
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                  <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                     @if($lista_egresosregistrados!=null)
                      <?php
                    $verificador=true;
                     ?>
                     @foreach($lista_egresosregistrados as $egresoregistrado)
                     @if($egresoregistrado->fecha===$egreso->fecha)
                     <?php $verificador=false; ?>
                     @endif
                     @endforeach
                      @if($verificador)
                      <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                     @else
                      <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                     @endif
              
                   @else
                      <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                   @endif
               @else
                <tr>
                 <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
                    <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                   @if($lista_egresosregistrados!=null)
                      <?php
                    $verificador=true;
                     ?>
                     @foreach($lista_egresosregistrados as $egresoregistrado)
                     @if($egresoregistrado->fecha===$egreso->fecha)
                     <?php $verificador=false; ?>
                     @endif
                     @endforeach
                      @if($verificador)
                     <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                     @else
                      <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                     @endif
              
                   @else
                    <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                   @endif

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
  <H2><b>Datos generales del corte<b></H2>
      <br>
      <div class="row">
      <H3><b>Total de dias: <p id="texto_dias" style="display:inline">0</p> <b></H3>
        </div>
           <br>
        <H3><b> Ingreso del corte: <p id="texto_ingreso" style="display:inline">0</p> <b></H3>
           <br>
            <H3><b>Egreso del corte: <p id="texto_egreso" style="display:inline">0</p><b></H3>
               <br>
                <H3><b>Total del corte: <p id="texto_total" style="display:inline">0</p><b></H3>

    
  </div>    

  </div>
  </div>
  @endsection
   <script type="text/javascript">
  var sumadias=0;
  var sumaegresos=0;
  var sumaingresos=0;
  var totaltotal=0;

    function sumastotales(check,ingresos,egreso){
    var checkBox = document.getElementById(check);
    if (checkBox.checked == true){
     sumadias++;
     sumaingresos+=parseFloat(ingresos);
     sumaegresos+=parseFloat(egreso);
    } else {
       sumadias--;
     sumaingresos-=parseFloat(ingresos);
     sumaegresos-=parseFloat(egreso);
    }
      totaltotal=sumaingresos-sumaegresos;
     document.getElementById("texto_dias").innerHTML =sumadias;
     document.getElementById("texto_ingreso").innerHTML =sumaingresos.toFixed(2);
     document.getElementById("texto_egreso").innerHTML =sumaegresos.toFixed(2);
     document.getElementById("texto_total").innerHTML =totaltotal.toFixed(2);
    }
   </script>