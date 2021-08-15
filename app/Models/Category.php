<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable =
    [
        'id',
        'name',
        'slug',
        'date',
    ];

    public function post()
    {
        return $this->hasMany(Post::class,'category_id','id');
    }
}
