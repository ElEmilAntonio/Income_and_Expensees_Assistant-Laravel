
  <div class="container">
   <h3 align="center">Corte periodo: {{$corte->inicio}}/{{$corte->final}}</h3><br />
   <div align="center">
  
   </div>
   <br />
<div  class="col-sm-6">

  
       <div class="panel">
  
    <div class="panel-body">
        <table>
            <tr>
           <td>Inicio</td>
      <td>Final</td>
      <td>Ingresos</td>
      <td>Egresos</td>
      <td>Total</td>
         </tr>
       
         <tbody>
          
            <tr >
               <td align="center" class="table-text"><div>{{$corte->inicio}}</div></td>
               <td align="center" class="table-text"><div>{{$corte->final}}</div></td>
                <td align="center" class="table-text"><div>${{$corte->ingreso}}</div></td>
               <td align="center" class="table-text"><div>${{ $corte->egreso}}</div></td>
               <td align="center" class="table-text"><div>${{ $corte->total}}</div></td>   
        </tr>

    </tbody>
</table>
|
 
    </div>
</div>
</div>

<div  class="col-sm-6">
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>
     </h3>
    </div>
    <div class="panel-body">
        <table>
             <tr>
      <td>Fecha</td>
      <td>Manana</td>
      <td>Tarde</td>
      <td>Noche</td>
      <td>Total ingreso</td>
      <td>Egreso</td>
      <td>Total</td>
     </tr>
         @if ($lista_ingresos!=null)
         <tbody>
            @foreach ($lista_ingresos as $ingreso)
            <?php
            $total=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
             ?>
            <tr >
               <td align="center" class="table-text"><div>{{$ingreso->fecha}}</div></td>
               <td align="center" class="table-text"><div>${{$ingreso->manana}}</div></td>
                <td align="center" class="table-text"><div>${{$ingreso->tarde}}</div></td>
               <td align="center" class="table-text"><div>${{ $ingreso->noche}}</div></td>
                 <td align="center" class="table-text"><div>${{$total}}</div></td>
            @foreach($lista_egresos as $egreso)
            @if($egreso->id==$ingreso->id)
            <?php
             $total-=$egreso->egreso;
             ?>
               <td align="center" class="table-text"><div>${{ $egreso->egreso}}</div></td>
                 <td align="center" class="table-text"><div>${{$total}}</div></td>
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


   @foreach($lista_egresos as $egreso)
   <h3 align="center">Gastos dia: {{$egreso->fecha}}</h3><br/>
   @if($lista_gastos!=null)
    <table>
      <tr>
      <td>Categoria</td>
      <td>Razon</td>
      <td>Costo</td>
     </tr>
         <tbody>
            @foreach ($lista_gastos as $gasto)
            @if($gasto->id_egreso==$egreso->id)
            <tr >
              @foreach($categorias as $categoria)
              @if($gasto->categoria==$categoria->id)
                  <td align="center" class="table-text"><div>{{$categoria->nombre}}</div></td>
              @endif
              @endforeach
               <td align="center" class="table-text"><div>{{$gasto->Razon}}</div></td>
               <td align="center" class="table-text"><div>${{$gasto->costo}}</div></td>
        </tr>
        @endif
        @endforeach
   
</tbody>  
</table>
 @endif
@endforeach

  </div>
 </body>
</html>
