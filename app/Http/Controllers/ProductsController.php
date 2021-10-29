<?php

namespace App\Http\Controllers;

// use App\Models\ProductsCatModel;
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

       try {
           return response()->json([
            'data' => ProductsModel::all(),
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


    public function showOneProduct(Request $request, $id)
    {
        try {
        $data = ProductsModel::find($id);
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


    public function createProduct(Request $request, ProductsModel $ProductsModel)
    {

        $ProductsModel = new ProductsModel;
        $this->validate($request,
        [
            'cat_id' => 'bail|required|numeric|exists:prod_sub_cat,id',
            'product_title' => 'bail|required|unique:products|string',
            'product_desc' => 'bail|string',
            'product_image' => 'bail|file',
            'availability_status' => 'bail|string',
            'amount' => 'numeric'
            // prod_sub_cat
        ]);

        $image_name = $request->product_image;
        if($request->hasFile('product_image')){
            $file = $request->product_image;
            $image_name = $request->product_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('product_image')->move($destinationPath, $image_name);

            if(!$request->file('product_image')->isValid()){
                return response()->json([
                    'msg' => 'Image upload not successful'
                ]);
            }
        }


        try{
            $ProductsModel = new ProductsModel;

            $ProductsModel->cat_id = $request->cat_id;
            $ProductsModel->product_title = $request->product_title;
            $ProductsModel->product_desc = $request->product_desc;
            $ProductsModel->availability_status = $request->availability_status;
            $ProductsModel->availability_status = $request->availability_status;
            $ProductsModel->unit = $request->unit;
            $ProductsModel->product_image = $image_name;
            $ProductsModel->amount = $request->amount;
            $ProductsModel->save();

            return response()->json([
                'data' => $ProductsModel,
                'msg' => 'New Record created successfully',
                'statusCode' => 201
            ]);
        } catch(\Exception $e){
            return response()->json([
                'msg' => 'Product creation failed!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }


    public function updateProduct($id, Request $request)
    {

        // return $request->cat_title;
        $this->validate($request,
        [
            'cat_id' => 'bail|numeric|exists:prod_sub_cat,id',
            'product_title' => 'bail|unique:products|string',
            'product_desc' => 'bail|string',
            'product_image' => 'bail',
            'availability_status' => 'bail|string',
            'amount' => 'numeric'
        ]);

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();


        $ProductsModel = ProductsModel::findorFail($id);

        $ProductsModel->cat_id = $request->has('cat_id') ? $request->cat_id : $ProductsModel->cat_id;
        $ProductsModel->product_title = $request->has('product_title') ? $request->product_title : $ProductsModel->product_title;
        $ProductsModel->product_sub_title = $request->has('product_sub_title') ? $request->product_sub_title : $ProductsModel->product_sub_title;
        $ProductsModel->product_desc = $request->has('product_desc') ? $request->product_desc : $ProductsModel->product_desc;
        $ProductsModel->availability_status = $request->has('availability_status') ? $request->availability_status : $ProductsModel->availability_status;
        $ProductsModel->product_image = $request->has('product_image') ? $request->product_image : $ProductsModel->product_image;
        $ProductsModel->save();

        // $ProductsModel->update($request->all());

        return response()->json([
            'data' => $ProductsModel,
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


    public function deleteProduct($id)
    {

        // return $ProductsModel->ProductCategory();
        try {
            ProductsModel::findorFail($id)->delete();
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

    public function ProductBelongsTo($id){
        try {
            $data = ProductsModel::find($id)->ProductsCategory;
            return response()->json([
                'msg' => 'Category selection successful!',
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

    //
}
