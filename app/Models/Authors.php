<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description',
        'url',
    ];

    public function book(){
        return $this->belongsTo(App\Models\Books.php, 'author_id', 'id');
    }

}
