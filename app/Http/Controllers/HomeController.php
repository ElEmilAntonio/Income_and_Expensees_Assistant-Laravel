<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Closure;
use Response;
use redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Collection;
use App\Role_user;
use App\User;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function redirigir(){
$id= Auth::user()->id;
$rol=Role_user::findOrFail($id);
if ($rol->role_id==3) {
 return redirect()->route('cliente');
}elseif ($rol->role_id==2) {  
return redirect()->route('empleado');
}elseif ($rol->role_id==1) {  
return redirect()->route('administrador/'.date("Y-m-d"));
}
}
}