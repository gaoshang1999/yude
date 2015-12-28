<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function unCacheView()
    {
        $dir = __DIR__.'/../../../';
        $cachedViewsDirectory=$dir.'/storage/framework/views/';
        $files = glob($cachedViewsDirectory.'*');
        foreach($files as $file) {
            if(is_file($file)) {
                @unlink($file);
            }
        }
    }
}
