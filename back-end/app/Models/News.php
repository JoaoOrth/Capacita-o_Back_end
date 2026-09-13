<?php

namespace App\Models;
use App\Models\Journalist;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title','date','link','description'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function journalists()
    {
        return $this->belongsToMany(Journalist::class);
    }
}

