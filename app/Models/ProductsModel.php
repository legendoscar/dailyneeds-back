<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class ProductsModel extends Model {

    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = ['cat_id', 'product_title', 'product_sub_title', 'product_desc',
     'availability_status', 'unit', 'product_image', 'amount'];
}
