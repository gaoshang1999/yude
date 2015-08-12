<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'books';

    protected $fillable = ['level', 'kind', 'name', 'price', 'discount', 'discount_price', 
                            'inventory', 'buytimes', 'author', 'cover', 'summary', 
                            'pagetitle', 'pagekeyword', 'pagedescription'];
}
