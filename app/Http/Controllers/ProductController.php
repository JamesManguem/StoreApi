<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller{

    public function index(){
      
        $dataProduct= Product::all();

        return response()->json($dataProduct);

    }


    public function save(Request $request){
      

          $dataProduct = new Product; 

          if($request->hasFile('Picture')) { 

            $nombreArchivoOriginal=$request->file('Picture')->getClientOriginalName();

            $nuevoNombre= Carbon::now()->timestamp."_".$nombreArchivoOriginal;

            $carpetaDestino='./upload/';

            $request->file('Picture')->move($carpetaDestino, $nuevoNombre);

            
          $dataProduct -> Name = $request->Name;

          $dataProduct -> Description = $request->Description;

          $dataProduct -> Price = $request->Price;

          $dataProduct -> Stock = $request->Stock;

          $dataProduct -> Picture = ltrim($carpetaDestino,'.').$nuevoNombre;

          $dataProduct ->save();

          }


          

        return response()->json($nuevoNombre);

    }

    public function ver($id){
        $dataProduct = new Product;
        $dataFind=$dataProduct->find($id);
       return response()->json($dataFind);

    } 
    public function delete($id){

        $dataProduct= Product::find($id);

        if($dataProduct){

            $rutaArchivo=base_path('public').$dataProduct->Picture;
          
            if(file_exists($rutaArchivo)){
              unlink($rutaArchivo);
            }
          $dataProduct->delete();  
        }

        return response()->json("Archive Deleted");
    }
    public function update(Request $request,$id){
        
        $dataProduct = Product::find($id);


        if($request->hasFile('Picture')) { 



            if($dataProduct){

                $rutaArchivo=base_path('public').$dataProduct->Picture;
              
                if(file_exists($rutaArchivo)){
                  unlink($rutaArchivo);
                }
              $dataProduct->delete();  
            }



            $nombreArchivoOriginal=$request->file('Picture')->getClientOriginalName();

            $nuevoNombre= Carbon::now()->timestamp."_".$nombreArchivoOriginal;

            $carpetaDestino='./upload/';

            $request->file('Picture')->move($carpetaDestino, $nuevoNombre);

           $dataProduct -> Picture = ltrim($carpetaDestino,'.').$nuevoNombre;

           $dataProduct ->save(); 
        }


        
        if($request->input('Name')){
            $dataProduct->Name=$request->input('Name');
        }
         
        if($request->input('Description')){
            $dataProduct->Description=$request->input('Description');
        }


        if($request->input('Price')){
            $dataProduct->Price=$request->input('Price');
        }

        if($request->input('Stock')){
            $dataProduct->Stock=$request->input('Stock');
        }






        $dataProduct ->save();



        return response()->json("Updated Data");
         
    }



}