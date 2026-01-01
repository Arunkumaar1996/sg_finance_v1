<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'status', 'check_in', 'check_out', 'created_at', 'updated_at'];
    // protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
