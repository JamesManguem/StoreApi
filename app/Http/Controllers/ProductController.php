<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller{

    public function index(){
      
        $dataProduct= Product::all();

        return response()->json($dataProduct);

    }


    public function save(Request $request){
      

          $dataProduct = new Product; 
          
          $dataProduct -> Name = $request->Name;
          $dataProduct -> Description = $request->Description;
          $dataProduct -> Price = $request->Price;
          $dataProduct -> Stock = $request->Stock;
          $dataProduct -> Picture = $request->Picture;

          $dataProduct ->save();


        return response()->json($request);

    }

}