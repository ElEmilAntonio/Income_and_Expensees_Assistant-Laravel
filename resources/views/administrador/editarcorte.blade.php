        @extends('layouts.app')

      @section('content')
      <?php 
      $total=0; 
      $totalingresos=0;
      $sumadias=0;
      $sumaegresos=0;
      $sumaingresos=0;
       ?>

      <div class="container">
          <div class="row">
       <form  method="POST"  action="{{ url('buscar_dias_edit')}}/{{$id_corte}}" enctype="multipart/form-data">
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

         <form  method="POST"  action="{{ url('update_corte')}}/{{$id_corte}}" enctype="multipart/form-data">
                          @csrf
                          {{ csrf_field() }}
                          {{ method_field('POST') }}
         <button class="btn btn-bg btn-primary" type="submit">
      Editar Corte
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
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
                       @if($lista_egresosregistrados!=null)
                         <?php
                        $verificador=true;
                        $verificadorcorte=false;
                         ?> 
                         @foreach($lista_egresosregistrados as $egresoregistrado)
                         @if($egresoregistrado->fecha==$egreso->fecha)
                         <?php $verificador=false; ?>
                         @if((int)$egresoregistrado->id_corte==(int)$id_corte)
                         <?php $verificadorcorte=true; ?>
                         @else
                           <?php $verificadorcorte=false; ?>
                         @endif
                         @endif
                         @endforeach
                          @if($verificador)
                         <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                         @else
                          @if($verificadorcorte==true)
                           <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')" checked></td>
                          @else
                           <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                          @endif
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
                        $verificadorcorte=false;
                         ?>
                         @foreach($lista_egresosregistrados as $egresoregistrado)
                         @if($egresoregistrado->fecha==$egreso->fecha)
                         <?php $verificador=false; ?>
                         @if((int)$egresoregistrado->id_corte==(int)$id_corte)
                         <?php $verificadorcorte=true; ?>
                         @else
                           <?php $verificadorcorte=false; ?>
                         @endif
                         @endif
                         @endforeach
                          @if($verificador)
                         <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                         @else
                          @if($verificadorcorte)
                           <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')" checked></td>
                          @else
                           <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                          @endif
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
                        $verificadorcorte=false;
                         ?>
                         @foreach($lista_egresosregistrados as $egresoregistrado)
                         @if($egresoregistrado->fecha==$egreso->fecha)
                         <?php $verificador=false; ?>
                         @if((int)$egresoregistrado->id_corte==(int)$id_corte)
                         <?php $verificadorcorte=true; ?>
                         @else
                           <?php $verificadorcorte=false; ?>
                         @endif
                         @endif
                         @endforeach
                          @if($verificador)
                         <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')"></td>
                         @else
                          @if($verificadorcorte)
                           <td align="center" class="table-text"><input type="checkbox" name="checkegreso[]" id="checkegreso[{{$egreso->id}}]" value="{{$egreso->id}}" onchange="sumastotales('checkegreso[{{$egreso->id}}]','{{$totalingresos}}','{{$egreso->egreso}}')" checked></td>
                          @else
                           <td align="center" class="table-text"><div><b>Registrado</b></div></td>
                          @endif
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
    <?php $totaldias=0; ?>
    @foreach($lista_egresosregistrados as $egresoregistrado)
    @if($egresoregistrado->id_corte==$id_corte)
    <?php $totaldias++; ?>
    @endif
    @endforeach
    
     <H2><b>Datos generales del corte<b></H2>
          <br>
          <div class="row">
          <H3><b>Total de dias: <p id="texto_dias" style="display:inline">{{$totaldias}}</p> <b></H3>
            </div>
               <br>
            <H3><b> Ingreso del corte: <p id="texto_ingreso" style="display:inline"><?php echo number_format($corte_actual->ingreso,2) ?></p> <b></H3>
               <br>
                <H3><b>Egreso del corte: <p id="texto_egreso" style="display:inline"><?php echo number_format($corte_actual->egreso,2) ?></p><b></H3>
                   <br>
                    <H3><b>Total del corte: <p id="texto_total" style="display:inline"><?php echo number_format($corte_actual->total,2) ?></p><b></H3>
      </br>
       <button  class="btn btn-success" onclick="location.href='/export_excel_corte/{{$id_corte}}'" method="GET"><i class="fa fa-file-excel-o"></i>Descargar excel</button>
      </div>    

      </div>
      </div>
      @endsection
       <script type="text/javascript">
      var sumadias=parseFloat("<?php echo $totaldias ?>");
      var sumaegresos=parseFloat("<?php echo $corte_actual->egreso ?>");
      var sumaingresos=parseFloat("<?php echo $corte_actual->ingreso ?>");
      var totaltotal=parseFloat("<?php echo $corte_actual->total ?>");

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

        function sumastotalesinicio(ingresos,egreso){
         sumadias++;
         sumaingresos+=parseFloat(ingresos);
         sumaegresos+=parseFloat(egreso);
         totaltotal=sumaingresos-sumaegresos;
        document.getElementById("texto_dias").innerHTML =sumadias;
     document.getElementById("texto_ingreso").innerHTML =sumaingresos.toFixed(2);
     document.getElementById("texto_egreso").innerHTML =sumaegresos.toFixed(2);
     document.getElementById("texto_total").innerHTML =totaltotal.toFixed(2);
        }
       </script>