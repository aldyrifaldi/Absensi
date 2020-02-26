<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $guarded = ['id'];
    protected $table = 'guru';
}
