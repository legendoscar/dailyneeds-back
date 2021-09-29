<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function showAllrestaurants()
    {
        return response()->json(Restaurant::all());
    }
    

    public function showOneRestaurant($id)
    {
        return response()->json(Restaurant::find($id));
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'rest_name' => 'bail|required|unique:restaurants|string',
            'rest_email' => 'bail|required|email:filter|unique:restaurants',
            'rest_address' => 'bail|required|string',
            'rest_phone' => 'bail|required|unique:restaurants|numeric|digits:11',
            'rest_admin_username' => 'bail|required|unique:restaurants|string',
            'rest_admin_password' => 'bail|required|min:8|string',

        ]);

        $rest = Restaurant::create($request->all());

        return response()->json($rest, 201);
    }


    public function update($id, Request $request)
    {
        $this->validate($request, [
            
        ]);

        $rest = Restaurant::findorFail($id);
        $rest->update($request->all());

        return response()->json($rest, 200);
    }


    public function delete($id)
    {

        Restaurant::findorFail($id)->delete();
        return response('Deleted successfully!', 200);
    }

    //
}
