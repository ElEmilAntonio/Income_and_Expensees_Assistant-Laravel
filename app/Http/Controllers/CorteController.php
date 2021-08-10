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
use App\login;
use App\Listaegreso;
use App\Categoria;
use App\Corte;
use App\Listacorte;
use App\Exports\InvoicesExportCorte;
use Maatwebsite\Excel\Facades\Excel;
class CorteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main(Request $request,$id)
    {
    $añoactual=date("Y");
    $corteactual=null;
    $listacorte=null;
    $egresopush=collect();
     $ingresopush=collect();
    $lista_egresos=null;
    $lista_ingresos=null;
    $cortes=Corte::orderBY('inicio','Desc')->take(54)->get(); 
   
    if($id==="inicio"){
    $corteactual=Corte::orderBY('final','Desc')->first();
    }else{
    $corteactual=Corte::findOrFail($id);
    }
    if($corteactual!=null){
    $listacortes=Listacorte::where('id_corte',$corteactual->id)->get();
foreach ($listacortes as $listacorte) {
$egreso=Egreso::where('fecha',$listacorte->fecha)->first();
$egresopush->push($egreso);
$ingreso=Ingreso::where('fecha',$listacorte->fecha)->first();
$ingresopush->push($ingreso);
}
$lista_egresos=$egresopush->values();
$lista_egresos->all();
$lista_ingresos=$ingresopush->values();
$lista_ingresos->all(); 
    }
   
    return view('administrador.cortes',['cortes'=>$cortes,'lista_egresos'=>$lista_egresos,'lista_ingresos'=>$lista_ingresos,'corteactual'=>$corteactual]);
    }

    public function generarcorte($fechaanterior,$fechasiguiente){
      $cortepush=collect();
      $cortesregistrados=null;
      $lista_egresosregistrados=null;
      $egresos=$this->busquedaegresos($fechasiguiente,$fechaanterior);
      $ingresos=$this->busquedaingresos($fechasiguiente,$fechaanterior);
foreach ($egresos as $egreso) {
$listacorte=Listacorte::where('fecha',$egreso->fecha)->first();
if($listacorte!=null) $cortepush->push($listacorte);
}
if($cortepush->isNotEmpty()){
$cortesregistrados=$cortepush->values();
$lista_egresosregistrados=$cortesregistrados->all();
}
return view('administrador.generarcorte',['lista_egresosregistrados'=>$lista_egresosregistrados,'egresos'=>$egresos,'ingresos'=>$ingresos,'fechaanterior'=>$fechaanterior,'fechasiguiente'=>$fechasiguiente]);
    }

public function buscardias(Request $request){
$fechasiguiente=date("Y-m-d");
$fechaanterior=date("Y-m-d",(strtotime ( '-15day' , strtotime ( $fechasiguiente) ) ));
$Validator =Validator::make($request->all(),[
        'fechaanterior'=>['required','date'],
        'fechasiguiente'=>['required','date'],
        ]);
      if (!$Validator->fails()){
      $fechasiguiente=$request->fechasiguiente;
$fechaanterior=$request->fechaanterior;
      }

return redirect('/generar_corte/'.$fechaanterior.'/'.$fechasiguiente);
}


public function createcorte(Request $request){
$ultimo=true;
$inicio=null;
$final=null;
$ingresototal=0;
$egresototal=0;
$total=0;
foreach ($request->checkegreso as $id) {
  $egreso=Egreso::findOrFail($id);
  $ingreso=Ingreso::where('fecha',$egreso->fecha)->first();
$ingresototal+=$ingreso->manana+$ingreso->tarde+$ingreso->noche;
$egresototal+=$egreso->egreso;
if($ultimo){
$final=$egreso->fecha;  
$ultimo=false;
}else{
$inicio=$egreso->fecha;  
}

}
$total=$ingresototal-$egresototal;
$corte=Corte::create([
'id'=>null,
'inicio'=>$inicio,
'final'=>$final,
'ingreso'=>$ingresototal,
'egreso'=>$egresototal,
'total'=>$total,
]);

$cortecreado=Corte::where('inicio',$inicio)->where('final',$final)->first();
foreach ($request->checkegreso as $id) {
$egreso=Egreso::findOrFail($id);
$listacorte=Listacorte::Create([
'id'=>null,
'id_corte'=>$cortecreado->id,
'fecha'=>$egreso->fecha,
]);
}
return redirect('/cortes/inicio');
}

public function buscardiasedit(Request $request,$id){
$fechasiguiente=date("Y-m-d");
$fechaanterior=date("Y-m-d",(strtotime ( '-15day' , strtotime ( $fechasiguiente) ) ));
$Validator =Validator::make($request->all(),[
        'fechaanterior'=>['required','date'],
        'fechasiguiente'=>['required','date'],
        ]);
      if (!$Validator->fails()){
      $fechasiguiente=$request->fechasiguiente;
$fechaanterior=$request->fechaanterior;
      }
return redirect('/gestion_corte/'.$id.'/'.$fechaanterior.'/'.$fechasiguiente);
}

 public function ireditcorte(Request $request,$id,$fechaanterior,$fechasiguiente){
 $corte=Corte::findOrFail($id);
 $fechaanterior=$corte->inicio;
 $fechasiguiente=$corte->final;
 return redirect('/gestion_corte/'.$id.'/'.$fechaanterior.'/'.$fechasiguiente);
 }
  public function editcorte(Request $request,$id,$fechaanterior,$fechasiguiente){
      $cortepush=collect();
      $cortesregistrados=null;
      $lista_egresosregistrados=null;
      $Corteactual=Corte::findOrFail($id);
      $egresos=$this->busquedaegresos($fechasiguiente,$fechaanterior);
      $ingresos=$this->busquedaingresos($fechasiguiente,$fechaanterior);
foreach ($egresos as $egreso) {
$listacorte=Listacorte::where('fecha',$egreso->fecha)->first();
if($listacorte!=null){$cortepush->push($listacorte);}
}
if($cortepush->isNotEmpty()){
$cortesregistrados=$cortepush->values();
$lista_egresosregistrados=$cortesregistrados->all();
}
return view('administrador.editarcorte',['corte_actual'=>$Corteactual,'id_corte'=>$id,'lista_egresosregistrados'=>$lista_egresosregistrados,'egresos'=>$egresos,'ingresos'=>$ingresos,'fechasiguiente'=>$fechasiguiente,'fechaanterior'=>$fechaanterior]);
    }

public function updatecorte(Request $request,$idcorte){
$borrarcorte=Corte::findOrFail($idcorte)->delete();
$borraregresoscorte=Listacorte::where('id_corte',$idcorte)->delete();
return $this->createcorte($request);
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
  

function excelcorte(Request $request,$id)
    {
    $corte=Corte::findOrFail($id);
     return Excel::download(new InvoicesExportCorte($id), 'Corte periodo: '.$corte->inicio.'-'.$corte->final.'.xlsx');
    }
}