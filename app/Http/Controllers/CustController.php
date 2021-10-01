<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\CustomersModel;

class CustController extends Controller
{

    public function showAllCust()
    {
        try{
            return response()->json([
                'data' => CustomersModel::all(),
                'statusCode' => 200,
                'msg' => 'Records returned successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json(['msg' => 'No record retrieved!'], 409);
        }
    }
    

    public function showOneCust(Request $request, $id)
    {
        return response()->json([
            'data' => CustomersModel::find($id),
            'msg' => 'Record returned successfully.',
            'statusCode' => 200
        ]);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function registerCust(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'cust_fname' => 'bail|required|string',
            'cust_lname' => 'bail|required|string',
            'cust_phone' => 'bail|unique:customers',
            'cust_email' => 'bail|required|email|unique:customers',
            // 'cust_image' => 'bail|file',
            'cust_password' => 'bail|required|confirmed|min:8',
        ]);

        // file upload validation
        $file = 'cust_image';
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

        // send to DB
        try {

            $user = new CustomersModel;
            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->cust_email = $request->input('cust_email');
            $user->cust_phone = $request->input('cust_phone');
            $user->cust_image = $image_name;
            $plainPassword = $request->input('password');
            $user->cust_password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'msg' => 'Customer Registration successful'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['msg' => 'Customer Registration Failed!'], 409);
        }

    }
    

}

