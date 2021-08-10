@extends('layouts.app')

@section('content')
<?php $total=0.00; ?>
<div class="container">
    <div id="sales_div"></div>
    {!! $lava->render('CalendarChart', 'Sales', 'sales_div') !!}
                    <br>
    <div class="row">
   
   <br>  
     <div  class="col-sm-6">
        <h4>Ultimo Inicio de Sesión: {{$login->fecha}} a la hora: {{$login->hora}}</h4>
       <div class="panel">
    <div class="panel-heading">
     Para visualizar detalles de egreso de click a la fila deseada
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
         @if (count($ingresos) > 0)
         <tbody>
            @foreach ($ingresos as $ingreso)
            <?php
            $total=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
             ?>
              @foreach($egresos as $egreso)
            @if($egreso->fecha==$ingreso->fecha)
            <?php
             $total-=$egreso->egreso;
             ?>
             @if($total<0)
        
              <tr bgcolor="#ff726f" onclick="location.href='/administrador/{{$ingreso->fecha}}'" method="POST">
               <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->manana,2)?></b></div></td>
                <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->tarde,2)?></b></div></td>
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->noche,2)?></b></div></td>
           
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($egreso->egreso,2)?></b></div></td>
                 <td align="center" class="table-text"><div><b>$<?php echo  number_format($total,2)?></b></div></td>
             @elseif($total>0)
              <tr bgcolor="#98fb98"  onclick="location.href='/administrador/{{$ingreso->fecha}}'" method="POST">
               <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->manana,2)?></b></div></td>
                <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->tarde,2)?></b></div></td>
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->noche,2)?></b></div></td>
           
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($egreso->egreso,2)?></b></div></td>
                 <td align="center" class="table-text"><div><b>$<?php echo  number_format($total,2)?></b></div></td>
             @else
              <tr  onclick="location.href='/administrador/{{$ingreso->fecha}}'" method="POST">
               <td align="center" class="table-text"><div><b>{{$ingreso->fecha}}</b></div></td>
                <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->manana,2)?></b></div></td>
                <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->tarde,2)?></b></div></td>
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($ingreso->noche,2)?></b></div></td>
           
               <td align="center" class="table-text"><div><b>$<?php echo  number_format($egreso->egreso,2)?></b></div></td>
                 <td align="center" class="table-text"><div><b>$<?php echo  number_format($total,2)?></b></div></td>
             @endif
           
            @endif
            @endforeach      
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
    <b>Fecha: {{$detallegreso->fecha}}</b>   <button type="submit" class="btn btn-primary" onclick="location.href='/gestion_dia/{{$detallegreso->fecha}}'" method="GET">Gestionar dia</button>
     </h3>
    </div>
    <div class="panel-body">
        <table class="table table-sm w-90">
            <h4><b>Ingresos</b></h4>
            <thead>
             <th scope="col">Mañana</th>
             <th scope="col">Tarde</th>
             <th scope="col">Noche</th>
             <th scope="col">Total Ingreso</th>        
         </thead>
        <?php
         $totalingreso=$detalleingreso->manana+$detalleingreso->tarde+$detalleingreso->noche;
         ?>
         <tbody>       
            <tr>

               <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->manana,2) ?></div></td>
               <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->tarde,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($detalleingreso->noche,2) ?></div></td>
                <td align="center" class="table-text"><div>$<?php echo number_format($totalingreso,2)?></div></td>
        </tr>
    </tbody>
</table>
        <br>
        <table class="table table-sm w-90">
                  <h4><b>Egresos</b></h4>
            <thead>
             <th scope="col">Categoria</th>
             <th scope="col">Detalles</th>
             <th scope="col">Costo</th>        
         </thead>
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
                <td align="center" class="table-text"><div>$<?php echo number_format($listaegreso->costo,2)?></div></td>
        </tr>
        @endforeach
        @else
        <tr>
               <td align="center" class="table-text"><div><b>Aun no ah registrado ningun egreso en esta fecha</b></div></td>
        </tr>
        @endif
    </tbody>
</table>

 
    </div>
</div>
</div>    

</div>
</div>
</div>
@endsection
