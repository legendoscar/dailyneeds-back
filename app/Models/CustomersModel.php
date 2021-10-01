<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class CustomersModel extends Model {

    use SoftDeletes;
    protected $table = 'customers';

    protected $fillable = ['cust_fname', 'cust_lname', 'cust_phone', 'cust_email', 'cust_image'];


    public function all_categories(){
        return $this->all();
    }
}
