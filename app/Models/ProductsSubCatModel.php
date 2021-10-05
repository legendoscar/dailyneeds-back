<?php

namespace App\Models;


// use App\Models\ProductsCatModel;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

Class ProductsSubCatModel extends Model {

    use SoftDeletes;

    protected $table = 'prod_sub_cat';

    protected $fillable = ['cat_id', 'sub_cat_title', 'sub_cat_desc', 'sub_cat_image'];


    public function all_sub_categories(){
        return $this->all();
    }

    public function ProductCategory(){
        return $this->hasOne('App\Models\ProductsCatModel', 'id', 'cat_id');
    }
}
