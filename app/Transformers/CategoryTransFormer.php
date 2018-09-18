<?php
namespace App\TransFormers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransFormer extends TransformerAbstract {

  public function transform(Category $category){
    $normals = $category->toArray();
    $attends = [

    ];
    return array_merge($normals, $attends);
  }

}
