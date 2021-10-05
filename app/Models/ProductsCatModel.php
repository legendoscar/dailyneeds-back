<?php

namespace App\Models;


// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class ProductsCatModel extends Model {

    use SoftDeletes;
    protected $table = 'product_categories';

    protected $fillable = ['cat_title', 'cat_desc', 'cat_image'];


    public function allCategories(){
        return $this->all();
    }

    public function subCategory(){
        return $this->hasMany('App\Models\ProductsSubCatModel', 'id');
    }
}
