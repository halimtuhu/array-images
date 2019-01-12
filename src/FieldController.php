<?php
namespace Halimtuhu\ArrayImages;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class FieldController extends BaseController
{
    /**
     * upload selected images
     *
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        $disk = $request->disk ? $request->disk : 'local';
        $path = $request->path ? $request->path : '/';
        $images = $request->images;
        $data = array();

        foreach ($images as $image)
        {
            $savedImage = Storage::disk($disk)
                ->putFile($path, $image);

            $data[] = [
                'image' => $image->getClientOriginalName(),
                'url' => Storage::url($savedImage)
            ];
        }

        return $data;
    }

    public function delete($image)
    {
        Storage::delete($image);

        return "success";
    }
}
