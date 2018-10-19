<?php
namespace Halimtuhu\ArrayImages\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArrayImagesController extends Controller
{
    public function index(Request $request)
    {
        return "array images by halimtuhu";
    }

    public function upload(Request $request)
    {
        $image = Storage::putFile('/', $request->file('image'));

        $data = [
            'name' => $image,
            'url' => Storage::url($image),
        ];

        return $data;
    }

    public function delete($image)
    {
        Storage::delete($image);

        return "success";
    }
}
