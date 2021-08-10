<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="fa fa-barcode"></i>Tienda<span class="caret"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" onclick="location.href='/tienda/todo'" method="POST">
     todo
    </a>
    @if(count($categorias)>0)
    @foreach($categorias as $categoria)
    @if($categoria->id!=12)
        <a class="dropdown-item" onclick="location.href='/tienda/{{$categoria->nombre}}'" method="POST">
      {{$categoria->nombre}}
    </a>
    @endif
      @endforeach
  @endif
</div>
</li>