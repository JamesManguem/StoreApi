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


          

        return response()->json($request);

    }

}