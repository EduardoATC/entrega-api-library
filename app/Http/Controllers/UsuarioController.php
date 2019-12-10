<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Usuario;

class UsuarioController extends Controller
{
    
    public function postUsuario(Request $request)
    {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        $usuario = new Usuario;

        if(!$request->name || !$request->email || !$request->password)
            $response= array('error_msg' => "Tiene que rellenar todos los campos");
        else{
            try{
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->password = $request->password;
                $usuario->save();
                $response = array('error_code' => 200, 'error_msg' => 'OK');
            }
            catch(\Exception $e){
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }

        return response()->json($response);
       
    }



    public function putUsuarios(Request $request)
    {
        $response = array('error_code' => 404, 'error_msg' => 'Usuario no encontrado');
        $usuario = Usuario::find($request->id);
        if(!isset($usuario->id)){
        $response = array('error_code' => 404, 'error_msg' => 'Usuario no encontrado, el id no existe');
        }else{
            try{
                $usuario->name = $request->name;
                $usuario->email = $request->email;
                $usuario->password = $request->password;
            $usuario->save();
            $response = array('error_code' => 200, 'error_msg' => 'OK');
            }
            catch(\Exception $e){
            $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }
       
        return response()->json($response);
        
        
        
    }
    public function deleteUsuarios(Request $request)
    {
        $response = array('error_code' => 404, 'error_msg' => 'Usuario no encontrado');
        $usuario = Usuario::find($request->id);

        try{
            $usuario->delete();
            $response = array('error_code' => 200, 'error_msg' => 'OK');
        }catch(\Exception $e){
            $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
        }
        
        return response()->json($response);;
    }
}
