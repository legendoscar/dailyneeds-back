<?php

namespace App\Http\Controllers;


  //import auth facades
  use Illuminate\Support\Facades\Auth;
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
            'cust_image' => 'bail|file|mimes:png,jpg',
            'cust_password' => 'bail|required|min:8',
        ]);

        // file upload validation
        // $file = 'cust_image';
        if($request->hasFile('cust_image')){
            // $file = $request->cust_image;
            // return 3;
            $image_name = $request->cust_image->getClientOriginalName();

            $path = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
            $destinationPath = app()->basePath($path);
            $request->file('cust_image')->move($destinationPath, $image_name);
            
            // if($request->file('cust_image')->isValid()){
            //     return response()->json([
            //         'msg' => 'Image upload not successful'
            //     ]);
            // }
        }

        // send to DB
        try {

            $user = new CustomersModel;
            $user->cust_fname = $request->input('cust_fname');
            $user->cust_lname = $request->input('cust_lname');
            $user->cust_email = $request->input('cust_email');
            $user->cust_phone = $request->input('cust_phone');
            $user->cust_image = $image_name;
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'msg' => 'Customer Registration successful'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['msg' => 'Customer Registration Failed!'], 409);
        }

    }

    
    public function loginCust(Request $request){
        
        $this->validate($request, [
            'cust_email' => 'bail|required|email',
            'cust_password' => 'bail|required|string'
        ]);
        // return $request->all();

        $cred = $request->only('cust_email', 'cust_password');

        if (Auth::login($cred)) {
            // return response()->json(['message' => 'Unauthorized'], 401);
            return 33;
        }
    }
    

}

