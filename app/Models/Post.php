<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category ;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable =
    [
        'id',
        'title',
        'slug',
        'body',
        'image',
        'user_id',
        'category_id',
        'date',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
       return  $this->belongsTo(Category::class , 'category_id','id');
    }

    public function user()
    {
       return  $this->belongsTo(User::class , 'user_id','id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName()
    {
       return 'slug';
    }

}
