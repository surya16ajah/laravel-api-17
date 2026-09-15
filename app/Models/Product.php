<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock', 'description', 'kategori_id'];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}