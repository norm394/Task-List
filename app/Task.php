<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['status', 'status_color', 'owner', 'title', 'description'];
}
