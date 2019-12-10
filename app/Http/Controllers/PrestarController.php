<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Prestamo;



use App\Libro;
class PrestarController extends Controller
{
    
    public function prestarLibro(Request $request){
         if ($request->libro_id && $request->usuario_id) {
            $bookToBeBorrowed = Libro::find($request->libro_id);
            $response = 0;
            
            if ($bookToBeBorrowed->borrowed === 1 )  return array('code' => 404, 'error_msg' => ['Libro no disponible']);
            
                
            if ($bookToBeBorrowed->borrowed === 0) {
               
                try {
                    $prestamo = new Prestamo();
                    $prestamo->usuario_id = $request->usuario_id;
                    $prestamo->libro_id = $request->libro_id;
                    $prestamo->loan_date = Carbon::today(); 
                    $prestamo->return_date = Carbon::tomorrow();
                    $prestamo->loan_time = Carbon::today();
                    $bookToBeBorrowed->borrowed = 1;

                    $prestamo->save();
                    $bookToBeBorrowed->save();

                    $response = array('code' => 200, 'msg' => ['OK']);
                } catch (\Exception $exception) {
                    $response = array('code' => 500, 'error_msg' => $exception->getMessage());
                }
            } 
        }
        return $response;
    }

    public function devolverLibro(Request $request){
       $response = 0;
       
       
       if (isset($request->id)) {
            $prestamo = Prestamo::find($request->id);
         
            if (!empty($prestamo)) {
                try {
                    $prestamo->delete();
                    $response = array('code' => 200, 'msg' => ['OK']);
                } catch (\Exception $exception) {
                    $response = array('code' => 500, 'error_msg' => $exception->getMessage());
                }
            } else {
                $response = array('code' => 404, 'error_msg' => ['No existe ese prestamo']);
            }
        }
        return response()->json($response);
    }
}
