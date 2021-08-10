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

class InvoicesExport implements FromView
{

	protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
      $listaegreso=null;
    $egreso=Egreso::FindOrFail($this->id);
    $listaegreso=Listaegreso::where('id_egreso',$this->id)->get();
    $ingreso=Ingreso::FindOrFail($this->id);
    $categorias=Categoria::get();
     return view('administrador.exceldia',['egreso'=>$egreso,'ingreso'=>$ingreso,'listaegreso'=>$listaegreso,'categorias'=>$categorias]);
    }
}