<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{

    protected $fillable = ['admin_id','action','model','description'];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
