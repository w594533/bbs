<?php
namespace App\TransFormers;

use App\Models\Image;
use League\Fractal\TransformerAbstract;

class ImageTransFormer extends TransformerAbstract
{
  public function transform(Image $image)
  {
    $normals = $image->toArray();
    $attends = [];
    return array_merge($normals, $attends);
  }
}
