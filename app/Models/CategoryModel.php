<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

Class CategoryModel extends Model {

    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['cat_title', 'cat_desc', 'cat_type', 'cat_image'];


    public function allCategories(){
        return $this->all();
    }

    // public function subCategory(){
    //     return $this->hasMany('App\Models\ProductsSubCatModel', 'id');
    // }

    public function exception($data, $success = 'Records returned successfully.', $failed = 'No Record found.'
// $successCode =200
    ){

        try{
             !empty($data)
                 ? $ret = response()->json([
                     'data' => $data,
                     'statusCode' => 200,
                     'msg' => $success
         ])
         : $ret = response()->json([
             'data' => $data,
             'msg' => $failed,
             'statusCode' => 404
         ]);

         return $ret;


         }catch(\Exception $e){
             return response()->json([
                 'msg' => 'Ooops!! Error encountered!',
                 'err' => $e->getMessage(),
                 'statusCode' => 409
             ]);
         }
    }

    public function storeCatAll(){

        $data = $this->where('cat_type', 1)->get();
        return $this->exception($data);

    }

    public function storeCatShowOne($id){

        $data = $this->find($id);
        return $this->exception($data);
    }

    public function storeCatCreate(Request $request){
        $this->validate($request, [
            'cat_title' => 'bail|required|unique:categories|string',
            // 'store_cat_title' => [Rule::unique('users')->whereNull('deleted_at')],
            'cat_desc' => 'bail|string',
            'cat_type' => 'bail|numeric|required|in:[1,2]',
            'cat_image' => 'bail|string',
        ]);

        return 33;
        $image_name = $request->store_cat_image;
        if($request->hasFile('store_cat_image')){
            $image_name = $request->store_cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('store_cat_image')->move($destinationPath, $image_name);

            // if($request->file('store_cat_image')->isValid()){
            //     return response()->json([
            //         'msg' => 'Image upload successful'
            //     ]);
            // }
        }


        try {
            $CategoryModel = new CategoryModel;

            $CategoryModel->store_cat_title = $request->store_cat_title;
            $CategoryModel->store_cat_desc = $request->store_cat_desc;
            $CategoryModel->store_cat_image = $image_name;
            $CategoryModel->save();

            return response()->json([
                'data' => $CategoryModel,
                'msg' => 'New Store category created successfully',
                'statusCode' => 201
            ]);
         }catch(\Exception $e){
            return response()->json([
                'msg' => 'Store Category creation failed!',
                'err' => $e->getMessage(),
                'statusCode' => 409
            ]);
        }
    }


    public function storeCatDeleteOne($id){

        $data = $this->findorFail($id)->delete();
        return $this->exception($data, $success = 'Delete operation successful!', $failed = 'Delete operation failed! No record found for id: ' . $id . '!');

    }
}
