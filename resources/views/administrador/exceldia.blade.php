
  <div class="container">
   <h3 align="center">Dia: {{$ingreso->fecha}}</h3><br />
   <div align="center">
  
   </div>
   <br />
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <tr>
      <td>Manana</td>
      <td>Tarde</td>
      <td>Noche</td>
      <td>Total ingreso</td>
      <td>Egreso</td>
      <td>Total</td>
     </tr>
     <?php  $totalingreso=0;
            $total=0;
      ?>
     @if($ingreso!=null)
     <tr>
      <td>{{ $ingreso->manana}}</td>
      <td>{{ $ingreso->tarde}}</td>
      <td>{{ $ingreso->noche}}</td>
    <?php
    $totalingreso=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
    $total=$totalingreso-$egreso->egreso;
      ?>
      <td>{{$totalingreso}}</td>
       <td>{{$egreso->egreso}}</td>
        <td>{{$total}}</td>
    
     </tr>
     @endif
    </table>
   </div>
   @if($listaegreso!=null)
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <tr>
      <td>Categoria</td>
      <td>Detalles</td>
      <td>Costo</td>
     </tr>

     @foreach($listaegreso as $lista)
     <tr>
      @foreach($categorias as $categoria)
      @if($categoria->id==$lista->categoria)
      <td>{{ $categoria->nombre}}</td>
      @endif
      @endforeach
    
      <td>{{ $lista->razon}}</td>
      <td>{{ $lista->costo}}</td>
     </tr>
     @endforeach
    </table>
   </div>
   @endif
  </div>
 </body>
</html>
