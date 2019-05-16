<?php
/**
 * Created by PhpStorm.
 * User: owlting
 * Date: 2019-05-15
 * Time: 16:39
 */

namespace App\Repository;

use App\Image;


class ImageRepository
{
    public function createImage($request)
    {
        $file_name = $request->get('file_name');
        $url = $request->get('url');
        $size = $request->get('size');
        $user_id = $request->get('user_id');

        $data = Image::create([
            'file_name' => $file_name,
            'url' => $url,
            'size' => $size,
            'user_id' => $user_id
        ]);

        return $data;
    }
}