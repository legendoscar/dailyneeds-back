<?php

namespace App\Http\Controllers;

// use App\Models\ProductsCatModel;
use App\Models\ProductsSubCatModel;
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

       try {
           $data = ProductsSubCatModel::all();
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
                'msg' => 'Ooops! Error encountered!!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }


    public function showOneprodSubCat(Request $request, $id)
    {
        try {
            $data = ProductsSubCatModel::find($id);
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


    public function createprodSubCat(Request $request, ProductsSubCatModel $ProductsSubCatModel)
    {
        $val = $this->validate($request,
        [
            'cat_id' => 'bail|required|numeric|exists:product_categories,id',
            'sub_cat_title' => 'bail|required|unique:prod_sub_cat|string',
            'sub_cat_desc' => 'bail|string',
            'sub_cat_image' => 'bail|file',
        ]);

        $image_name = $request->sub_cat_image;
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
            $ProductsSubCatModel->sub_cat_image = $image_name;
            $ProductsSubCatModel->save();

            return response()->json([
                'data' => $ProductsSubCatModel,
                'msg' => 'New Record created successfully',
                'statusCode' => 201
            ]);
        } catch(\Exception $e){
            return response()->json([
                'msg' => 'Product Sub_category creation failed!',
                'err' => $e->getMessage(),
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

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();


        $ProductsSubCatModel = ProductsSubCatModel::findorFail($id);

        $ProductsSubCatModel->cat_id = $request->has('cat_id') ? $request->cat_id : $ProductsSubCatModel->cat_id;
        $ProductsSubCatModel->sub_cat_title = $request->has('sub_cat_title') ? $request->sub_cat_title : $ProductsSubCatModel->sub_cat_title;
        $ProductsSubCatModel->sub_cat_desc = $request->has('sub_cat_desc') ? $request->sub_cat_desc : $ProductsSubCatModel->sub_cat_desc;
        $ProductsSubCatModel->sub_cat_image = $request->has('sub_cat_image') ? $request->sub_cat_image : $ProductsSubCatModel->sub_cat_image;
        $ProductsSubCatModel->save();

        // $ProductsSubCatModel->update($request->all());

        return response()->json([
            'data' => $ProductsSubCatModel,
            'msg' => 'Records updated successfully.',
            'statusCode' => 200]);
        }catch(\Exception $e){
            return response()->json([
                'msg' => 'Update operation failed!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }


    public function deleteprodSubCat($id)
    {

        // return $ProductsSubCatModel->ProductCategory();
        try {
            ProductsSubCatModel::findorFail($id)->delete();
            return response()->json([
                'msg' => 'Deleted successfully!',
                'statusCode' => 200]);
            }catch(\Exception $e){
                return response()->json([
                    'msg' => 'Delete operation failed!',
                    'err' => $e->getMessage(),
                    'statusCode' => 409
                ]);
        }
    }

    public function prodSubCatBelongsTo($id){
        try {
            $data = ProductsSubCatModel::find($id)->ProductCategory;
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

    }
    catch(\Exception $e){
            return response()->json([
                'msg' => 'Failed to retrieve data!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }
}
