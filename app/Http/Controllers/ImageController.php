<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ImageRepository;
use Melihovv\Base64ImageDecoder\Base64ImageDecoder;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $ImageRepository;

    public function __construct(ImageRepository $ImageRepository)
    {
        $this->ImageRepository = $ImageRepository;
    }

    public function uploadImage(Request $request)
    {

//        $image_file = $request->file('image');
//
//        $extension = $image_file->clientExtension();
//
//        $image_name = time() . '.' . $extension;
//
//        Storage::disk('local')->put($image_name,$image_file);

        try {
            $image_file = $request->file('image');
            $decoder = new Base64ImageDecoder($image_file, ['jpeg', 'jpg', 'png', 'gif']);

            //dd($decoder);
            $fileName =  strtoupper(Str::uuid) . "." . $decoder->getFormat();
            Storage::disk('local')->put($fileName,$decoder->getDecodedContent());

        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    public function readImage(Request $request)
    {
        $file_name = $request->get('img_name');

        $image = Storage::disk('local')->get('S__90325032.jpg');
        $image = base64_encode($image);
        return $image;
    }
}
