<?php 
namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Ingreso;
use App\Egreso;
use App\login;
use App\Listaegreso;
use App\Categoria;
use App\Corte;
use App\Listacorte;

class InvoicesExportCorte implements FromView
{

	protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
      $añoactual=date("Y");
    $listacorte=null;
    $egresopush=collect();
    $ingresopush=collect();
    $gastopush=collect();
    $lista_egresos=null;
    $lista_ingresos=null;
    $lista_gastos=null;
    $categorias=Categoria::get();
    $corte=Corte::findOrFail($this->id); 

    $listacortes=Listacorte::where('id_corte',$corte->id)->get();
foreach ($listacortes as $listacorte) {
$egreso=Egreso::findOrFail($listacorte->id_egreso);
$egresopush->push($egreso);
$ingreso=Ingreso::findOrFail($listacorte->id_egreso);
$ingresopush->push($ingreso);
}
$Egresos=$egresopush->values();
$lista_egresos=$Egresos->all();
$Ingresos=$ingresopush->values();
$lista_ingresos=$Ingresos->all(); 
foreach ($lista_egresos as $egreso) {
$gasto=Listaegreso::where('id_egreso',$egreso->id)->first();
if($gasto!=null){
$gastopush->push($gasto);
}
}
$gastos=$gastopush->values();
$lista_gastos=$gastos->all();

    return view('administrador.excelcorte',['corte'=>$corte,'lista_egresos'=>$lista_egresos,'lista_ingresos'=>$lista_ingresos,'categorias'=>$categorias,'lista_gastos'=>$lista_gastos]);
    }

}