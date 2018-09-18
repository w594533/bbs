<?php
namespace App\Handlers;
use Image;

class ImageUploadHandler {
    public function save($file,  $folder,$file_prefix,$max_width='')
    {
      $extension = $file->extension();

      $filename = $file_prefix.'_'.time()."_".str_random(10).'.'.$extension;

      $upload_path = "uploads/$folder/" . date("Ym/d", time());
      // dd($upload_path);

      $path = $file->storeAs("public/$upload_path", $filename);

      if($max_width) {
        $filepath = storage_path("app/$path");
        $this->resize($filepath, $max_width);//resize第一个参数需要完整的物理路径
      }
      
      return $upload_path . "/" . $filename;
    }

    public function resize($filepath, $max_width)
    {
      $image = Image::make($filepath);
      $image->resize($max_width, null, function($con){
        $con->aspectRatio();//按比例裁剪
        $con->upsize();
      });
      $image->save();
    }
}
