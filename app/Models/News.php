<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NewsCategories;
class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    public function category()
    {
        return $this->belongsTo(NewsCategories::class,'category_id');
    }
}
