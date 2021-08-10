<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Entrada;
use App\Ingreso;
use App\Egreso;
class LoginController extends Controller{
    use AuthenticatesUsers;

protected function authenticated(Request $request, $user){
    $login=null;
          $id=Auth::User()->id;
     $user= Auth::user()->roles->pluck('name');
  $fecha=date("Y-m-d");
  $hora=date("H:i:s");
if ($user->contains('administrador')){
$login=Entrada::create([
'id'=>null,
'id_user'=>$id,
'fecha'=>$fecha,
'hora'=>$hora,
]);
for ($dia=0; $dia<=30 ; $dia++) { 
 $verificarfecha=date("Y-m-d",(strtotime ( '-'.$dia.'day' , strtotime ( $fecha) ) ));
 $buscaringreso=Ingreso::where('fecha',$verificarfecha)->first();
 if($buscaringreso==null){
$Ingreso=Ingreso::create([
'id'=>null,
'fecha'=>$verificarfecha,
'manana'=>"0.00",
'tarde'=>"0.00",
'noche'=>"0.00",
]);
$Egreso=Egreso::create([
'id'=>null,
'fecha'=>$verificarfecha,
'egreso'=>"0.00",
]);
}

}

    return redirect('/administrador/'.$fecha);
}else{
      return redirect()->route('login');
}
}

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

}