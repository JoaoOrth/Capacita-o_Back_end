<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\News;

class Photo extends Model
{
    protected $with = ['news'];
    protected $fillable = ['local','description','image','placeholder','news_id'];
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
