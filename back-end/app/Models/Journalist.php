<?php

namespace App\Models;
use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class Journalist extends Model
{
    protected $fillable = ['name','email','workplace','salary'];
    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
