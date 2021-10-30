<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Carbon\Carbon;

Class CategoryModel extends Model {

    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['cat_title', 'cat_desc', 'cat_type', 'cat_image'];


    public function allCategories(){
        return $this->all();
    }

    public function subCategory(){
        return $this->hasMany('App\Models\ProductsSubCatModel', 'id');
    }

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

    public function storeCatGetAll(){

        $data = $this->where('cat_type', 1)->get();
        return $this->exception($data);

    }

    public function storeCatShowOne($id){

        $data = $this->find($id);
        return $this->exception($data);
    }

    public function storeCatCreate(Request $request){

        $image_name = $request->cat_image;
        if($request->hasFile('cat_image')){
            $image_name = $request->cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('cat_image')->move($destinationPath, $image_name);

            if($request->file('cat_image')->isValid()){
                return response()->json([
                    'msg' => 'Image upload unsuccessful'
                ]);
            }
        }

        try {
            $CategoryModel = new CategoryModel;

            $CategoryModel->cat_title = $request->cat_title;
            $CategoryModel->cat_desc = $request->cat_desc;
            $CategoryModel->cat_image = $image_name;
            $CategoryModel->save();
// return 33;
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

    public function storeCatUpdate(Request $request){

        $image_name = $request->cat_image;
        if($request->hasFile('cat_image')){
            $image_name = $request->cat_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('cat_image')->move($destinationPath, $image_name);

            if($request->file('cat_image')->isValid()){
                return response()->json([
                    'msg' => 'Image upload unsuccessful'
                ]);
            }
        }

        try {
            $request->updated_at = Carbon::now()->toDateTimeString();

            $CategoryModel = CategoryModel::findorFail($request->id);

            $CategoryModel->cat_title = $request->has('cat_title') ? $request->cat_title : $CategoryModel->cat_title;
            $CategoryModel->cat_desc = $request->has('cat_desc') ? $request->cat_desc : $CategoryModel->cat_desc;
            $CategoryModel->cat_image = $request->has('cat_image') ? $request->cat_image : $CategoryModel->cat_image;
            $CategoryModel->cat_type = $request->has('cat_type') ? $request->cat_type : $CategoryModel->cat_type;
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

    public function storeCatDeleteOne($id){

        $data = $this->findorFail($id)->delete();
        return $this->exception($data, $success = 'Delete operation successful!', $failed = 'Delete operation failed! No record found for id: ' . $id . '!');

    }
}
