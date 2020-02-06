<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // All this Are not compulsory only if you want to change the name of your table
    // Table Name
    protected $table="posts";
    // Primary key
    public $primaryKey='id';
    // Timestamps
    public $timestamps=true;

    public function user(){
        return $this->belongsTo('App\User');
    }

}
