<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NewsCategories;
class News extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(NewsCategories::class);
    }
}
