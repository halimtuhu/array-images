# Laravel Nova Field - Array Images
A laravel nova field that will let you save your uploaded images path to your database in array format.

# Usage
Create array images just call `Halimtuhu\ArrayImages\ArrayImages` class and use `make` static method to create a field.
```
...
use Halimtuhu\ArrayImages\ArrayImages;
...
public function fields(Request $request)
    {
        return [
            ...
            ArrayImages::make('Images', 'images'),
            ...
        ];
    }
...
```
That will create a field with name `Images`. Stored data will look like this.
```
[{
    "url": "http://laranov.halimtuhu.test/storage/wB04AbprHGxHw4I3sizXmuw9L4LBcG0wv0QEacAo.jpeg",
    "name": "wB04AbprHGxHw4I3sizXmuw9L4LBcG0wv0QEacAo.jpeg"
}, {
    "url": "http://laranov.halimtuhu.test/storage/eOuxUCjHGNokkHdOXYB7gGObxCvf7m30ridFpBpy.jpeg",
    "name": "eOuxUCjHGNokkHdOXYB7gGObxCvf7m30ridFpBpy.jpeg"
}, {
    "url": "http://laranov.halimtuhu.test/storage/nLkZp4vfpATEp56NStJfeAtKoHvmN2hapfxoNrEN.jpeg",
    "name": "nLkZp4vfpATEp56NStJfeAtKoHvmN2hapfxoNrEN.jpeg"
}]
```

# Notes
- make sure you have specified correct `APP_URL` on your application
- make sure you have specified default `FILESYSTEM_DRIVER` on your application
