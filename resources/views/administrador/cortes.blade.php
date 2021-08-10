@extends('layouts.app')

@section('content')
<?php $total=0; 
 $añoactual=date("Y");
 $fechahoy=date("Y-m-d");
$fechaanterior=date("Y-m-d",(strtotime ( '-15day' , strtotime ( $fechahoy) ) ));
 ?>

<div class="container">
    <div class="row">
   
     <div  class="col-sm-6">

        <h2>Lista de cortes del año {{$añoactual}}</h2>
         <button type="submit" class="btn btn-primary" onclick="location.href='/generar_corte/{{$fechahoy}}/{{$fechaanterior}}'" method="GET">Generar corte</button>
       <div class="panel">
    <div class="panel-heading">
     Para visualizar detalles del corte de click a la fila deseada
    </div>
    <div class="panel-body">
        <table class="table table-sm table-hover w-100">
            <thead>
             <th scope="col">Inicio</th>
             <th scope="col">Final</th>
             <th scope="col">Ingreso</th>
             <th scope="col">Egreso</th>
             <th scope="col">Total</th>        
         </thead>
         @if (count($cortes) > 0)
         <tbody>
            @foreach ($cortes as $corte)
         
            <tr onclick="location.href='/cortes/{{$corte->id}}'" method="POST">
               <td align="center" class="table-text"><div>{{$corte->inicio}}</div></td>
               <td align="center" class="table-text"><div>{{$corte->final}}</div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($corte->ingreso,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($corte->egreso,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($corte->total,2) ?></div></td>   
        </tr>

        @endforeach
    </tbody>
</table>
@endif
 
    </div>
</div>
</div>

<div  class="col-sm-6">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>
    @if($corteactual!=null)
    <b>Periodo:{{$corteactual->inicio}}/{{$corteactual->final}}</b>   <button type="submit" class="btn btn-primary" onclick="location.href='/ir_gestion_corte/{{$corteactual->id}}/{{$fechaanterior}}/{{$fechahoy}}'" method="GET">Gestionar corte</button>
    @endif
     </h3>
    </div>
    <div class="panel-body">
        <table class="table table-sm table-hover w-100">
            <thead>
             <th scope="col">Fecha</th>
             <th scope="col">Mañana</th>
             <th scope="col">Tarde</th>
             <th scope="col">Noche</th>
             <th scope="col">Egreso</th>
             <th scope="col">Total</th>        
         </thead>
         @if ($lista_ingresos!=null)
         <tbody>
            @foreach ($lista_ingresos as $ingreso)
            <?php
            $total=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
             ?>
            <tr onclick="location.href='/gestion_dia/{{$ingreso->fecha}}'" method="POST">
               <td align="center" class="table-text"><div>{{$ingreso->fecha}}</div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->manana,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->tarde,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($ingreso->noche,2) ?></div></td>
            @foreach($lista_egresos as $egreso)
            @if($egreso->id==$ingreso->id)
            <?php
             $total-=$egreso->egreso;
             ?>
               <td align="center" class="table-text"><div>$<?php echo number_format($egreso->egreso,2) ?></div></td>
                 <td align="center" class="table-text"><div>$<?php echo number_format($total,2) ?></div></td>
            @endif
            @endforeach      
        </tr>
        @endforeach
    </tbody>
    @endif
</table>
    </div>
</div>
</div>    

</div>
</div>
@endsection
