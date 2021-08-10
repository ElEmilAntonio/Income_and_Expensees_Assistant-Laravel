<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use Response;
use redirect;
use App\User;
use App\Cliente;
use App\Role_user;
use App\Domiciliocliente;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    

    use RegistersUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'apellidos'=>['required','string','max:100'],
            'rfc'=>['required','string','regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})$/','min:12','max:14','unique:clientes'],
            'edad'=>['required','integer','min:18','max:130'],
            'salario'=>['required','integer','min:0'],
            'sexo'=>['required','in:0,1'],
            'foto'=>['required','mimes:jpeg,jpg,png,webp'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo'=>['required','integer'],
            'calle'=>['required','string','max:50'],
            'cp'=>['required','string','max:6'],
            'ciudad'=>['required','string','max:50'],
            'estado'=>['required','string','max:50'],

        ]);
    }

    protected function create(array $data)
    {
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'apellidos'=>$data['apellidos'],
            'password' => Hash::make($data['password']),
        ]);
        $tipo=$data['tipo'];
        if($tipo==="3") {
         $filename=null;
$userid = User::select('id')->where('email',$data['email'])->value('id');
if(File::exists($foto=$data['foto'])){
$path ='/images/';
$uploadedFile = $data['foto'];
$filename = time().$data['name'].$uploadedFile->getClientOriginalName();
Storage::disk('local')->putFileAs($path,$uploadedFile,$filename);
}
 $cliente=Cliente::create([
    'id'=>null,
    'id_usuario'=>$userid,
   'rfc'=>$data['rfc'],
   'nombres'=>$data['name'],
   'apellidos'=>$data['apellidos'],
   'edad'=>$data['edad'],
   'salario'=>$data['salario'],
   'sexo'=>$data['sexo'],
   'foto'=>$filename,
 ]); 
    $clienteid=Cliente::select('id')->where('id_usuario',$userid)->value('id');
     $Domicilio=Domiciliocliente::create([
      'id'=>null,
       'id_cliente'=>$clienteid,
       'calle_colonia'=>$data['calle'],
       'cp'=>$data['cp'],
       'ciudad'=>$data['ciudad'],
       'estado'=>$data['estado'],
     ]);
     $Role_user = Role_user::create(['role_id'=>3,'user_id'=>$userid]);
        }else if($tipo==="2"){
        $Role_user = Role_user::create(['role_id'=>2,'user_id'=>$userid]);
        }else{
              $Role_user = Role_user::create(['role_id'=>1,'user_id'=>$userid]);
        }
        return $user;
    }

    
}
