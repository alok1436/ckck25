<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'companyName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
}
