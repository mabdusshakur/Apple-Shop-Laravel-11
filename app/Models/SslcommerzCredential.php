<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SslcommerzCredential extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'store_passwd',
        'currency',
        'success_url',
        'fail_url',
        'cancel_url',
        'ipn_url',
        'init_url',
    ];
}