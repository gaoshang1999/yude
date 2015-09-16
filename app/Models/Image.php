<?php

namespace App\Models;


class Image{
    
    public function __construct($name, $ctime)
    {
        $this->name = $name;
        $this->ctime = $ctime;
    }
    
    public $name;
    
    public $ctime;
    
}