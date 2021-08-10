<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Categoria;
use App\Listaegreso;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
    $Categorias=Categoria::get();
    $ver=null;
    $Categoriaedit=null;
    return view('administrador.categorias',['categorias'=>$Categorias,'ver'=>$ver,'categoriaedit'=>$Categoriaedit]);
    }

     public function createcategoria(Request $request){
       $Validator = Validator::make($request->all(),[
        'nombre'=>['required','string','max:50']
        ]);
      if ($Validator->fails()){
        return redirect('/categorias')->withInput()->withErrors($Validator);
       }
       $Categoria=Categoria::create([
    'id'=>null,
    'nombre'=>$request->nombre,
 ]); 
        return redirect('/categorias');
     }

    public function editcategoria(Request $request,$id){
     $Categoriaedit=Categoria::where('id',$id)->first();
      $Categorias=Categoria::get();
       $ver=1;
     return view('administrador.categorias',['categorias'=>$Categorias,'ver'=>$ver,'categoriaedit'=>$Categoriaedit]);
    }

    public function updatecategoria(Request $request,$id){
       $Validator = Validator::make($request->all(),[
        'nombre'=>['required','string','max:50']
        ]);
       if ($Validator->fails()){
        return redirect('/categorias')->withInput()->withErrors($Validator);
       }
       $Categoria=Categoria::findOrFail($id);
       $Categoria->Nombre=$request->nombre;
       $Categoria->update();
       return redirect('/categorias');
    }

    public function destroycategoria(Request $request,$id){
     $categoria=Categoria::findOrFail($id)->delete();
     $Productos=Listaegreso::where('categoria',$id)->get();
      $indefinido=5;
      foreach ($Productos as $producto) {
       $producto->idcategoria=$indefinido;
     $producto->update();
     }
    
    
  return redirect('/categorias');
    }  

}
