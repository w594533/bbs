<?php

namespace App\Http\Controllers\API;

use App\Models\Image;
use Illuminate\Http\Request;
use App\TransFormers\ImageTransFormer;
use App\Http\Requests\API\ImageRequest;
use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\API\Controller;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        if ($request->image) {
            $type = $request->type;
            $max_width = '';
            if ($type == 'avatar') {
                $max_width = 300;
            }
            $path = $uploader->save($request->image, $type, $this->user()->id, $max_width);
            if ($path) {
                $image->user_id = $this->user()->id;
                $image->path = $path;
                $image->type = $type;
                $image->save();
                return $this->response->item($image, new ImageTransFormer)->setStatusCode(201);
            }
        }
    }

    public function upload(Request $request, ImageUploadHandler $uploader, Image $image)
    {
        if ($request->hasFile('file')) {
            \Log::info($request->file);
            $path = $uploader->save($request->file, 'test', 'deploy_test');
            if ($path) {
                // $image->user_id = $this->user()->id;
                $image->path = $path;
                $image->type = 'topic';
                $image->save();
                return $this->response->item($image, new ImageTransFormer)->setStatusCode(201);
            }
            return $this->response->noContent();
        }
        $this->response->error('请上传文件', 422);
    }
}
