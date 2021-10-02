<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;

Class CustomersModel extends Model implements AuthenticatableContract, AuthorizableContract{

    use Authenticatable, Authorizable, HasFactory;
    use SoftDeletes;
    protected $table = 'customers';

 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['cust_fname', 'cust_lname', 'cust_phone', 'cust_email', 'cust_image'];

   /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function all_categories(){
        return $this->all();
    }
}
