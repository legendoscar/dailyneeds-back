<?php

namespace App\Http\Controllers;

use App\Models\ProductsCatModel;
use App\Models\ProductsModel;
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
        return response()->json([
            'data' => ProductsCatModel::all(),
            'statusCode' => 200,
            'msg' => 'Records returned successfully.'
        ]);
    }
    

    public function showOneProdCat(Request $request, $id)
    {
        return response()->json([
            'data' => ProductsCatModel::find($id),
            'msg' => 'Record returned successfully.',
            'statusCode' => 200
        ]);
    }


    public function createProdCat(Request $request, ProductsCatModel $ProductsCatModel)
    {
        $val = $this->validate($request,
        [
            'cat_title' => 'bail|required|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'cat_image' => 'bail|file',
        ]);

        $file = 'cat_image';
        if($request->hasFile($file)){
            $file = $request->cat_image;
            $image_name = $request->cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file($file)->move($destinationPath, $image_name);
            
            if(!$request->file($file)->isValid()){
                return response()->json([
                    'msg' => 'Image upload not successful'
                ]);
            }
        }


        $ProductsCatModel = new ProductsCatModel;

        $ProductsCatModel->cat_title = $request->cat_title;
        $ProductsCatModel->cat_desc = $request->cat_desc;
        $ProductsCatModel->cat_image = $request->cat_image;;
        $ProductsCatModel->save();

        return response()->json([
            'data' => $ProductsCatModel,
            'msg' => 'New Record created successfully',
            'statusCode' => 201
        ]);
    }


    public function updateProdCat($id, Request $request)
    {

        // return $request->cat_title;
        $this->validate($request, [
            'cat_title' => 'bail|required|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'cat_image' => 'bail|string',
        ]);

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();


            $ProductsCatModel = ProductsCatModel::findorFail($id);

            $ProductsCatModel->cat_title = $request->cat_title;
            $ProductsCatModel->cat_desc = $request->cat_desc;
            $ProductsCatModel->cat_image = $request->cat_image;;
            $ProductsCatModel->save();

            // $ProductsCatModel->update($request->all());

            return response()->json([
                'data' => $ProductsCatModel, 
                'msg' => 'Records updated successfully.',
                'statusCode' => 200]);
        }
        catch(\Exception $e){
            return response()->json([
                'msg' => 'Product Sub_category creation failed!',
                'statusCode' => 409
            ]);
        }
    }

    public function deleteProdCat($id)
    {

        ProductsCatModel::findorFail($id)->delete();
        return response([
            'msg' => 'Deleted successfully!', 
            'statusCode' => 200]);
    }

    //
}
