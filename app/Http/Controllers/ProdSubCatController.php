<?php

namespace App\Http\Controllers;

// use App\Models\ProductsCatModel;
use App\Models\ProductsSubCatModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProdSubCatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showAllProdSubCat()
    {
        return response()->json([
            'data' => ProductsSubCatModel::all(),
            'statusCode' => 200,
            'msg' => 'Records returned successfully.'
        ]);
    }
    

    public function showOneprodSubCat(Request $request, $id)
    {
        return response()->json([
            'data' => ProductsSubCatModel::find($id),
            'msg' => 'Record returned successfully.',
            'statusCode' => 200
        ]);
    }


    public function createprodSubCat(Request $request, ProductsSubCatModel $ProductsSubCatModel)
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
            $ProductsSubCatModel = new ProductsSubCatModel;

            $ProductsSubCatModel->cat_id = $request->cat_id;
            $ProductsSubCatModel->sub_cat_title = $request->sub_cat_title;
            $ProductsSubCatModel->sub_cat_desc = $request->sub_cat_desc;
            $ProductsSubCatModel->sub_cat_image = $request->sub_cat_image;;
            $ProductsSubCatModel->save();

            return response()->json([
                'data' => $ProductsSubCatModel,
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


    public function updateprodSubCat($id, Request $request)
    {

        // return $request->cat_title;
        $this->validate($request, [
            'cat_title' => 'bail|required|unique:product_categories|string',
            'cat_desc' => 'bail|string',
            'sub_cat_image' => 'bail|string',
        ]);

        $request->updated_at = Carbon::now()->toDateTimeString();


        $ProductsSubCatModel = ProductsSubCatModel::findorFail($id);

        $ProductsSubCatModel->cat_title = $request->cat_title;
        $ProductsSubCatModel->cat_desc = $request->cat_desc;
        $ProductsSubCatModel->sub_cat_image = $request->sub_cat_image;;
        $ProductsSubCatModel->save();

        // $ProductsSubCatModel->update($request->all());

        return response()->json([
            'data' => $ProductsSubCatModel, 
            'msg' => 'Records updated successfully.',
            'statusCode' => 200]);
    }


    public function deleteprodSubCat($id)
    {

        ProductsSubCatModel::findorFail($id)->delete();
        return response([
            'msg' => 'Deleted successfully!', 
            'statusCode' => 200]);
    }

    //
}
