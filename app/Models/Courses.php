<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    protected $fillable = ['level', 'kind', 'name', 'enable', 'buytimes', 'hours', 
                            'totalprice', 'subname', 'subprice', 'zongheprice', 
                            'nengliprice', 'cover', 'video', 'trialvideo', 'summary', 
                            'pagetitle', 'pagekeyword', 'pagedescription'];
}
