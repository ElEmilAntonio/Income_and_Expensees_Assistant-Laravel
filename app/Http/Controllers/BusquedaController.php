<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Role_user;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;
use Illuminate\View\Factory;
use App\Ingreso;
use App\Egreso;
use App\Entrada;
use App\Listaegreso;
use App\Categoria;
use App\Corte;
use App\Listacorte;

use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class BusquedaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main(Request $request,$fechasiguiente,$fechaanterior){
     $egresos=$this->busquedaegresos($fechasiguiente,$fechaanterior);
     $ingresos=$this->busquedaingresos($fechasiguiente,$fechaanterior);
     $tablagastos=$this->gastosporcategorias($egresos);
     $categorias=Categoria::get();
return view('administrador.busqueda',['egresos'=>$egresos,'ingresos'=>$ingresos,'fechaanterior'=>$fechaanterior,'fechasiguiente'=>$fechasiguiente,'tablagastos'=>$tablagastos,'categorias'=>$categorias]);
    }
    
public function buscardias(Request $request){
$fechahoy=date("Y-m-d");
$fechaanterior=date("Y-m-d",(strtotime ( '-5day' , strtotime ( $fechahoy) ) ));
 $Validator =Validator::make($request->all(),[
        'fechaanterior'=>['required','date'],
        'fechasiguiente'=>['required','date'],
        ]);
      if ($Validator->fails()){
        return redirect('/busqueda/'.$fechaanterior.'/'.$fechahoy)->withInput()->withErrors($Validator);
       }
return redirect('/busqueda/'.$request->fechasiguiente.'/'.$request->fechaanterior);
}


public function gastosporcategorias($egresos){
    $tablaegresos=collect();
    foreach($egresos as $egreso){
    $detalleegresos=Listaegreso::where('id_egreso',$egreso->id)->get();
    foreach($detalleegresos as $detalleegreso){
      $tablaegresos->push($detalleegreso);
  }
    }
      $tabla=$tablaegresos->values();
      $tabla->all();
    return $tabla;
   }
   
public function busquedacategoria($egresos,$categoria){
   $tablapush=collect();
   foreach($egresos as $egreso){
   $listaegreso=Listaegreso::where('id_egreso',$egreso->id)->get();
   foreach($listaegreso as $lista){
    if($lista->categoria==$categoria){
    $tablapush->push($lista);
    }}}
   $tabla=$tablapush->values();
    $tabla->all();
    dd($tabla);
    return $tabla;
   }

   public function irbusquedacategoria($categoria,$fechasiguiente,$fechaanterior){
 $egresos=$this->busquedaegresos($fechasiguiente,$fechaanterior);
 $tablagastos=$this->busquedacategoria($egresos,$categoria);
 $nombre=Categoria::FindOrFail($categoria)->pluck('nombre');
 return view('administrador.busquedacategorias',['categoria'=>$categoria,'egresos'=>$egresos,'tablagastos'=>$tablagastos,'fechasiguiente'=>$fechasiguiente,'fechaanterior'=>$fechaanterior]);
    }


   
    public function busquedaegresos($fechasiguiente,$fechaanterior){
     $egresos=null;
     if($fechaanterior<=$fechasiguiente)
      $egresos=Egreso::whereBetween('fecha',[$fechaanterior,$fechasiguiente])->orderBY('fecha','Desc')->get();
    else
    $egresos=Egreso::whereBetween('fecha',[$fechasiguiente,$fechaanterior])->orderBY('fecha','Desc')->get();
    return $egresos;
    }

    public function busquedaingresos($fechasiguiente,$fechaanterior){
     $ingresos=null;
     if($fechaanterior<=$fechasiguiente)
      $ingresos=Ingreso::whereBetween('fecha',[$fechaanterior,$fechasiguiente])->orderBY('fecha','Desc')->get();
    else
    $ingresos=Ingreso::whereBetween('fecha',[$fechasiguiente,$fechaanterior])->orderBY('fecha','Desc')->get();
     return $ingresos;
    }


    function excel(Request $request,$id)
    {
     $egreso=Egreso::FindOrFail($id);
     return Excel::download(new InvoicesExport($id), 'gestion_del_dia:'.$egreso->fecha.'.xlsx');
    }
  }