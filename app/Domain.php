<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content_length',
        'status_code',
        'body',
        'h1',
        'keywords',
        'description',
    ];
}
