<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\User;
use App\Administrador;
use App\Empleado;
use App\Cliente;
use App\Categoria;
use App\Carritocliente;
use App\Tiendacarrito;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        //
    }


    public function boot()
    {
     //cargar categorias para el cliente
     view()->composer('layouts.navCliente',function($view){
      $Categorias=Categoria::get();
      $view->with('categorias',$Categorias);  
     });
     
       view()->composer('layouts.navproducto',function($view){
      $Categoriasadmin=Categoria::get();
      $view->with('categorias',$Categoriasadmin);  
     });
     

     view()->composer('layouts.navCarrito',function($view){
         $total=0;
       $id_usuario=Auth::User()->id;
       $Carritocliente=Carritocliente::where('id_usuario',$id_usuario)->first();
       if($Carritocliente!=null){
       $Carritoproductos=Tiendacarrito::where('id_carrito',$Carritocliente->id)->get();
       foreach ($Carritoproductos as $producto) {
        $total++;
       }
     }
      $view->with('total',$total);  
     });
    }
}
