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
        return $CategoryModel->storeCatGetAll();

    }


    public function getOneStoreCat(Request $request, CategoryModel $CategoryModel)
    {
        $id = $request->id;
        return $CategoryModel->storeCatShowOne($id);
    }


    public function validData(Request $request){

        return $this->validate($request, [
            'cat_title' => 'bail|required|unique:categories|string',
            'cat_desc' => 'bail|string',
            'cat_type' => 'bail|numeric|required',
            'cat_image' => 'bail|file',
        ]);

    }

    public function storeCatCreate(Request $request, CategoryModel $CategoryModel)
    {

        $validData=$this->validData($request);

        $CategoryModel = new CategoryModel;

        return $CategoryModel->storeCatCreate($request);

    }


    public function storeCatUpdate(Request $request)
    {
        $this->validate($request, [
            'cat_title' => 'bail|unique:categories|string',
            'cat_desc' => 'bail|string',
            'cat_type' => 'bail|numeric',
            'cat_image' => 'bail|file',
        ]);

        $CategoryModel = new CategoryModel;

        return $CategoryModel->storeCatUpdate($request);
    }


    public function storeCatDelete(Request $request, CategoryModel $CategoryModel)
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
