<?php namespace App\Http\Controllers\Admin;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Image;

class ImagesController extends Controller
{
    public function __construct()
    {
        
    }


    public function lists(Request $request)
    {
        $root = __DIR__.'/../../../../';
        $upload = $root . "public/upload/";
        
        $dir = opendir($upload);
        $files = [];
        //列出目录中的文件
        while (($file = readdir($dir)) !== false)
        {
            $path = $upload . $file;
            if(is_file($path)){    
                $img = new Image($file, date("Y-m-d H:i:s",filemtime($path)));                
                $files [] = $img;
            }
        }
        
        closedir($dir);
        
        usort($files, function($a, $b){
                return strtotime($b->ctime) - strtotime($a->ctime) ;
        });       

        return view("admin.image.list", ["files" => $files ]);
    }
    
    
    public function upload(Request $request) 
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $imgs = ['image'];
            foreach ($imgs as $c) {
                $file = array_get($input, $c);
                if ($file) {
                    $destinationPath = 'upload';
                    if (!is_dir(base_path('public/' . $destinationPath))) {
                        mkdir(base_path('public/' . $destinationPath));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $fileName = uniqid()  . '.' . $extension;
                    $upload_success = $file->move($destinationPath, $fileName);                   
                }
            }
            
            return redirect('/admin/images');
            
        }else{
            return view('admin.image.upload');
        }
    }
    
    public function remove(Request $request)
    {
        $root = __DIR__.'/../../../../';
        $upload = $root . "public/upload/";
        
        $file = $request['file'];     
        $path = $upload . $file;
        unlink($path);
        
        return redirect('/admin/images');
    }
}