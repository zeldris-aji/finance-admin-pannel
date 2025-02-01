<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FFiscYaer extends Model
{
    use HasFactory;
    protected $table = 'f_fisc_yaers';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];
}
