<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publishers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description',
        'url',
    ];

    // public function book(){
    //     return $this->belongsTo(App\Models\Books.php, 'publisher_id', 'id');
    // }
}
