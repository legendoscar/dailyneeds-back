<?php

namespace App\Http\Controllers;

use App\Models\ProductsCatModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProdCatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showAllProdCat()
    {
        try{
            return response()->json([
            'data' => ProductsCatModel::all(),
            'statusCode' => 200,
            'msg' => 'Records returned successfully.'
        ]);
        }catch(\Exception $e){
            return response()->json([
                'msg' => 'No record found!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }
    

    public function showOneProdCat(Request $request, $id)
    {
        try{
            $data = ProductsCatModel::find($id);
            !empty($data) 
                ? $ret = response()->json([
                    'data'=> $data,
                    'msg' => 'Record returned successfully.', 
                    'statusCode' => 200
                ])
                : $ret = response()->json([
                'msg' => 'No Record found.',
                'statusCode' => 404
            ]);
    
            return $ret;
    
            }catch(\Exception $e){
                return response()->json([
                    'msg' => 'Ooops! Error encountered!',
                    'err' => $e->getMessage(),
                    'statusCode' => 409
                ]);
            }
    }


    public function createProdCat(Request $request, ProductsCatModel $ProductsCatModel)
    {

        $this->validate($request, [
            'cat_title' => 'bail|required|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'cat_image' => 'bail|file',
        ]);

        
        if($request->hasFile('cat_image')){
            $image_name = $request->cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('cat_image')->move($destinationPath, $image_name);
            
            // if($request->file('cat_image')->isValid()){
            //     return response()->json([
            //         'msg' => 'Image upload successful'
            //     ]);
            // }
        }


        try {
            $ProductsCatModel = new ProductsCatModel;

            $ProductsCatModel->cat_title = $request->cat_title;
            $ProductsCatModel->cat_desc = $request->cat_desc;
            $ProductsCatModel->cat_image = $image_name;
            $ProductsCatModel->save();

            return response()->json([
                'data' => $ProductsCatModel,
                'msg' => 'New Product category created successfully',
                'statusCode' => 201
            ]);
         }catch(\Exception $e){
            return response()->json([
                'msg' => 'Product Category creation failed!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }


    public function updateProdCat($id, Request $request)
    {

        $this->validate($request, [
            'cat_title' => 'bail|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'cat_image' => 'bail', 
        ]);

        // return $request->cat_image;
        if($request->hasFile('cat_image')){
            return $image_name = $request->cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('cat_image')->move($destinationPath, $image_name);
            
        }

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();

            $ProductsCatModel = ProductsCatModel::findorFail($id);

            $ProductsCatModel->cat_title = $request->has('cat_title') ? $request->cat_title : $ProductsCatModel->cat_title;
            $ProductsCatModel->cat_desc = $request->has('cat_desc') ? $request->cat_desc : $ProductsCatModel->cat_desc;
            $ProductsCatModel->cat_image = $request->has('cat_image') ? $request->cat_image : $ProductsCatModel->cat_image;
            $ProductsCatModel->save();

            return response()->json([
                'data' => $ProductsCatModel, 
                'msg' => 'Records updated successfully.',
                'statusCode' => 200]);
        }
        catch(\Exception $e){
            return response()->json([
                'msg' => 'Update operation failed!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }

    public function deleteProdCat($id)
    {

        try{
            ProductsCatModel::findorFail($id)->delete();
            return response([
            'msg' => 'Delete operation successful!', 
            'statusCode' => 200]);
        }catch(\Exception $e){
            // return $e->getMessage();
            return response()->json([
                'msg' => 'Delete operation failed! No record found for id: ' . $id . '!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }

    public function prodCatHas($id){
        // return 33;
        try {
            $data = ProductsCatModel::find($id)->subCategory;
            return response()->json([
                'msg' => 'Sub Category selection successful!', 
                'data' => $data,
                'statusCode' => 200]);
        }catch(\Exception $e){
            return response()->json([
                'msg' => 'Failed to retrieve data!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }
}
