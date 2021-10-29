<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoreCatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function showAllStoreCat(CategoryModel $CategoryModel)
    {
        return $CategoryModel->storeCatAll();

    }


    public function getOneStoreCat(Request $request, CategoryModel $CategoryModel)
    {
        $id = $request->id;
        return $CategoryModel->storeCatShowOne($id);
    }


    public function createStoreCat(Request $request, CategoryModel $CategoryModel)
    {
// return 33;
        // return $id = $request->input('');
        $CategoryModel = new CategoryModel;
        return 3;$CategoryModel->storeCatCreate($request);

        // return $
    }


    public function updateStoreCat($id, Request $request)
    {

        $this->validate($request, [
            'store_cat_title' => 'bail|unique:store_category|string',
            'store_cat_desc' => 'bail|string',
            'store_cat_image' => 'bail',
        ]);

        // return $request->store_cat_image;
        if($request->hasFile('store_cat_image')){
            return $image_name = $request->store_cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('store_cat_image')->move($destinationPath, $image_name);

        }

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();

            $CategoryModel = CategoryModel::findorFail($id);

            $CategoryModel->store_cat_title = $request->has('store_cat_title') ? $request->store_cat_title : $CategoryModel->store_cat_title;
            $CategoryModel->store_cat_desc = $request->has('store_cat_desc') ? $request->store_cat_desc : $CategoryModel->store_cat_desc;
            $CategoryModel->store_cat_image = $request->has('store_cat_image') ? $request->store_cat_image : $CategoryModel->store_cat_image;
            $CategoryModel->save();

            return response()->json([
                'data' => $CategoryModel,
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

    public function deleteStoreCat(Request $request, CategoryModel $CategoryModel)
    {
        $id = $request->id;
        return $CategoryModel->storeCatDeleteOne($id);
    }

    public function StoreCatHas($id){
        // return 33;
        try {
            $data = CategoryModel::find($id)->subCategory;
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
