<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    use HasFactory;
    protected $table = 'recharge_request';
    protected $primaryKey='request_id';
    public $timestamps=false;

}
