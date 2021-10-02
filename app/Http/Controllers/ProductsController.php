<?php

namespace App\Http\Controllers;


use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showAllProducts() 
    {
        try{
            return response()->json([
            'data' => ProductsModel::all(),
            'statusCode' => 200,
            'msg' => 'Records returned successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'msg' => 'Product selection failed!',
                'statusCode' => 409
        ]);
    }
}
    

    public function showOneproduct(Request $request, $id)
    {
        return response()->json([
            'data' => ProductsModel::find($id),
            'msg' => 'Record returned successfully.',
            'statusCode' => 200
        ]);
    }


    public function createproduct(Request $request, ProductsModel $ProductsModel)
    {
        $val = $this->validate($request,
        [
            'cat_id' => 'bail|required|numeric|exists:product_categories,id',
            'sub_cat_title' => 'bail|required|unique:prod_sub_cat|string',
            'sub_cat_desc' => 'bail|string',
            'sub_cat_image' => 'bail|file',
        ]);

        if($request->hasFile('sub_cat_image')){
            $file = $request->sub_cat_image;
            $image_name = $request->sub_cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('sub_cat_image')->move($destinationPath, $image_name);
            
            if(!$request->file('sub_cat_image')->isValid()){
                return response()->json([
                    'msg' => 'Image upload not successful'
                ]);
            }
        }


        try{
            $ProductsModel = new ProductsModel;

            $ProductsModel->cat_id = $request->cat_id;
            $ProductsModel->sub_cat_title = $request->sub_cat_title;
            $ProductsModel->sub_cat_desc = $request->sub_cat_desc;
            $ProductsModel->sub_cat_image = $request->sub_cat_image;;
            $ProductsModel->save();

            return response()->json([
                'data' => $ProductsModel,
                'msg' => 'New Record created successfully',
                'statusCode' => 201
            ]);
        } catch(\Exception $e){
            return response()->json([
                'msg' => 'Product Sub_category creation failed!',
                'statusCode' => 409
            ]);
        }
    }


    public function updateproduct($id, Request $request)
    {

        // return $request->cat_title;
        $this->validate($request, [
            'cat_title' => 'bail|required|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'sub_cat_image' => 'bail|string',
        ]);

        $request->updated_at = Carbon::now()->toDateTimeString();


        $ProductsModel = ProductsModel::findorFail($id);

        $ProductsModel->cat_title = $request->cat_title;
        $ProductsModel->cat_desc = $request->cat_desc;
        $ProductsModel->sub_cat_image = $request->sub_cat_image;;
        $ProductsModel->save();

        // $ProductsModel->update($request->all());

        return response()->json([
            'data' => $ProductsModel, 
            'msg' => 'Records updated successfully.',
            'statusCode' => 200]);
    }


    public function deleteproduct($id)
    {

        ProductsModel::findorFail($id)->delete();
        return response([
            'msg' => 'Deleted successfully!', 
            'statusCode' => 200]);
    }

    //
}
