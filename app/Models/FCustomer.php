<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCustomer extends Model
{
    use HasFactory;
    protected $table = 'f_customer';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'code',
        'name',
        'number',
        'address',
        'parent_name',
        'number_two',
        'status',
    ];
}
