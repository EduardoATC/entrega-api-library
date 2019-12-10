<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Libro;

class LibroController extends Controller
{
    public function bookList()
    {
    	$libro = Libro::all(['id','title','sinopsis','genrer', 'author', 'borrowed']);

    	return $libro;
    }

    public function addBook(Request $request)
    {
        $response = array('error_code' => 400, 'error_msg' => 'Error');
        $libro = new Libro;

        if(!$request->title || !$request->sinopsis || !$request->genrer|| !$request->author)
            $response= array('error_msg' => "Rellene todo los campos, por favor.");

        else{

            try{
                $libro->genrer = $request->genrer;
                $libro->author = $request->author;
                $libro->title = $request->title;
                $libro->sinopsis = $request->sinopsis;
                $libro->borrowed = 0;

                $libro->save();

                $response = array('error_code' => 200, 'error_msg' => 'OK');
            }
            catch(\Exception $e){
                
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }

        return response()->json($response);
    }



    public function updateBook(Request $request)
    {   
        $response = array('error_code' => 404, 'error_msg' => 'Libro no encontrado');
        $libro = Libro::find($request->id);
        if(empty($libro->id)){
        $response = array('error_code' => 404, 'error_msg' => 'Libro no encontrado, el id no existe');
        }else{
            try{
            $libro->title = $request->title;
            $libro->sinopsis = $request->sinopsis;
            $libro->genrer = $request->genrer;
            $libro->author = $request->author;
            $libro->borrowed = $request->borrowed;
            $libro->save();
            $response = array('error_code' => 200, 'error_msg' => 'OK');
            }
            catch(\Exception $e){
            $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }
       
        return response()->json($response);
    }
    public function deleteBook(Request $request)
    {
        $response = array('error_code' => 404, 'error_msg' => 'Libro no encontrado');
        $libro = Libro::find($request->id);
        if(!empty($libro)){
            
            if($libro->borrowed===1)
                $response = array('error_code' => 400, 'error_msg' => "Error al borrar, el libro se encuentra prestado");
            else{
                try{
                    $libro->delete();
                    $response = array('error_code' => 200, 'error_msg' => 'OK');
                }catch(\Exception $e){
                    $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
                }
            }
        }
        return response()->json($response);;
    }
}
