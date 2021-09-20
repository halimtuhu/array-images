<?php
namespace Halimtuhu\ArrayImages;

use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
        $disk = $request->disk ?: 'local';
        $path = $request->path ?: '/';
        $images = $request->images;
        $data = array();

        $resize = null;
        if($request->has('resize')) {
            $explode = explode(':', $request->resize);
            $resize['aspectRatio'] = $explode[1];
            $resize['width'] = explode('*', $explode[0])[0];
            $resize['height'] = explode('*', $explode[0])[1];
        }

        foreach ($images as $image)
        {
            if(is_array($resize)) {
                $imgFile = Image::make($image->getRealPath());

                $destinationPath = storage_path('app/public');
                $file = Str::random() . '.' . $image->getClientOriginalExtension();

                $imgFile->resize($resize['width'], $resize['height'], function ($constraint) use($resize) {
                    if($resize['aspectRatio']) {
                        $constraint->aspectRatio();
                    }
                })->save($destinationPath . '/' . $file);

                $image->move($destinationPath, $path . $file, $disk);
                $savedImage = $file;
            }
            else {
                $savedImage = Storage::disk($disk)
                    ->putFile($path, $image);
            }

            $data[] = [
                'image' => $savedImage,
                'url' => Storage::disk($disk)->url($savedImage),
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
