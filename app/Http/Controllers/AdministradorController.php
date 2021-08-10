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

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mainadministrador(Request $request,$fecha)
    {
    $login=$this->checklogin();
    $categorias=Categoria::get();
    $egresos=Egreso::orderBY('fecha','Desc')->take(60)->get();
    $ingresos=Ingreso::orderBY('fecha','Desc')->take(60)->get();
    $detalleingreso=Ingreso::where('fecha',$fecha)->first();
    $detalleegreso=Egreso::where('fecha',$fecha)->first();
    $listaegreso=Listaegreso::where('id_egreso',$detalleegreso->id)->get();
    $añoactual=date("Y");
    $ingresosaño=Ingreso::whereYear('fecha','=',$añoactual)->get(); 
     $lava = new Lavacharts; // See note below for Laravel
$sales = $lava->DataTable();
$sales->addDateColumn('Date')->addNumberColumn('Orders');
foreach ($ingresosaño as $ingresoaño) {
        $totalingreso=$ingresoaño->manana+$ingresoaño->tarde+$ingresoaño->noche;
        $sales->addRow([$ingresoaño->fecha,$totalingreso]);
    }


$lava->CalendarChart('Sales', $sales, [
    'title' => 'Ingresos del año',
    'unusedMonthOutlineColor' => [
        'stroke'        => '#ECECEC',
        'strokeOpacity' => 0.75,
        'strokeWidth'   => 1
    ],
    'dayOfWeekLabel' => [
        'color'    => '#4f5b0d',
        'fontSize' => 16,
        'italic'   => true
    ],
    'noDataPattern' => [
        'color' => '#DDD',
        'backgroundColor' => '#11FFFF'
    ],
    'colorAxis' => [
        'values' => [0,10000],
        'colors' => ['gray', 'red']
    ]
]);

    return view('administrador.administrador',['login'=>$login,'ingresos'=>$ingresos,'egresos'=>$egresos,'detalleingreso'=>$detalleingreso,'detallegreso'=>$detalleegreso,'listaegresos'=>$listaegreso,'categorias'=>$categorias,'lava'=>$lava]);
    }

    public function gestiondia(Request $request,$fecha){
      $categorias=Categoria::get();
     $detalleingreso=Ingreso::where('fecha',$fecha)->first();
    $detalleegreso=Egreso::where('fecha',$fecha)->first();
    $listaegreso=Listaegreso::where('id_egreso',$detalleegreso->id)->get();

    $registrocorte=null;
    $checkregistro=Listacorte::where('fecha',$detalleegreso->fecha)->first();
    if($checkregistro!=null){
    $registrocorte=Corte::FindOrFail($checkregistro->id_corte);
    }
     return view('administrador.gestiondia',['detalleingreso'=>$detalleingreso,'detallegreso'=>$detalleegreso,'listaegresos'=>$listaegreso,'categorias'=>$categorias,'registrocorte'=>$registrocorte]);
    }
    

    public function updateingreso(Request $request,$fecha){
    $Validator = Validator::make($request->all(),[
        'manana'=>['required','regex:/^\d+(\.\d{1,2})?$/'],
        'tarde'=>['required','regex:/^\d+(\.\d{1,2})?$/'],
        'noche'=>['required','regex:/^\d+(\.\d{1,2})?$/'],
        ]);
      if ($Validator->fails()){
        return redirect('/gestion_dia/'.$fecha)->withInput()->withErrors($Validator);
       }
     $this->balanceingresocorte($request,$fecha);
     $detalleingreso=Ingreso::where('fecha',$fecha)->first();
     $detalleingreso->manana=$request->manana;
     $detalleingreso->tarde=$request->tarde;
     $detalleingreso->noche=$request->noche;
     $detalleingreso->update();

     return redirect('/gestion_dia/'.$fecha);
    }

    public function balanceingresocorte($request,$fecha){
      $checkingreso=Ingreso::where('fecha',$fecha)->first();
     $checktotalingreso=$checkingreso->manana+$checkingreso->tarde+$checkingreso->noche;
     $ingresonuevo=$request->manana+$request->tarde+$request->noche;
     $diferencia=$ingresonuevo-$checktotalingreso;
     $checkcorte=Listacorte::where('fecha',$checkingreso->fecha)->first();
     if($checkcorte!=null){
     $corte=Corte::where('id',$checkcorte->id_corte)->first();
     $corte->ingreso=$corte->ingreso+$diferencia;
     $corte->total=($corte->ingreso)-$corte->egreso;
     $corte->update();
     }
    }
    
    public function createegreso(Request $request,$fecha){
     $validator=\Validator::make($request->all(),[
     'categoria.*'=>['string'],
     'razon.*'=>['max:200'],
     'costo.*'=>['regex:/^\d+(\.\d{1,2})?$/'],
     ]);
    
       if($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
  }
     for ($i=1; $i <=count($request->costo); $i++) {

     if($request->categoria[$i]==="ninguno"||$request->costo[$i]<=0){
     
     }else{
      $egresoactual=Egreso::where('fecha',$fecha)->first();
      $listaegreso=Listaegreso::create([
      'id'=>null,
      'id_egreso'=>$egresoactual->id,
      'costo'=>$request->costo[$i],
      'categoria'=>$request->categoria[$i],
      'razon'=>$request->razon[$i],
      ]);
      $actualizaregreso=Egreso::where('fecha',$fecha)->first();
      $actualizaregreso->egreso=($actualizaregreso->egreso+$request->costo[$i]);
      $actualizaregreso->update();
     }
     }
       return redirect('/gestion_dia/'.$fecha);
    }

    public function updateegreso(Request $request,$fecha){
     $validator=\Validator::make($request->all(),[
     'idedit.*'=>['required'],
     'categoriaedit.*'=>['string'],
     'razonedit.*'=>['max:200'],
     'costoedit.*'=>['regex:/^\d+(\.\d{1,2})?$/'],
     ]);
    
       if($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
  }
     for ($i=1; $i <=count($request->costoedit); $i++) {
      $listaegresoaeliminar=Listaegreso::where('id',$request->idedit[$i])->first();
      $egresoanterior=Egreso::where('fecha',$fecha)->first();
      $egresoanterior->egreso=$egresoanterior->egreso-$listaegresoaeliminar->costo;
      $egresoanterior->update();
      $listaegresoactualizar=Listaegreso::where('id',$request->idedit[$i])->first();
      $listaegresoactualizar->categoria=$request->categoriaedit[$i];
      $listaegresoactualizar->razon=$request->razonedit[$i];
      $listaegresoactualizar->costo=$request->costoedit[$i];
      $listaegresoactualizar->update();
      $egresonuevo=Egreso::where('fecha',$fecha)->first();
      $egresonuevo->egreso=$egresonuevo->egreso+$request->costoedit[$i];
      $egresonuevo->update();
     }
       return redirect('/gestion_dia/'.$fecha);
    }
    
    public function destroyegreso(Request $request,$fecha,$id){
    $egreso=Egreso::where('fecha',$fecha)->first();
    $listaegreso=Listaegreso::FindOrFail($id);
    $egreso->egreso=$egreso->egreso-$listaegreso->costo;
    $egreso->update();
    $egresoeliminar=Listaegreso::FindOrFail($id);
    $egresoeliminar->delete();
    return redirect('/gestion_dia/'.$fecha);
    }


 

    function excel(Request $request,$id)
    {
     $egreso=Egreso::FindOrFail($id);
     return Excel::download(new InvoicesExport($id), 'gestion_del_dia:'.$egreso->fecha.'.xlsx');
    }

        public function checklogin(){
    $login=Entrada::orderBY('id','Desc')->first();
    $loginpasado=Entrada::FindOrFail((int)$login->id-1);
    if($loginpasado==null){
    $loginpasado="primer inicio de sesion";
    }
    return $loginpasado;
    }
}