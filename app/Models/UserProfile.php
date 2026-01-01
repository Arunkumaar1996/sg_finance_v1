<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

   protected $fillable = [
    'user_id', 'uid', 'employee_id', 'role', 
    'blood_group', 'contact_number', 
    'emergency_contact_number', 'dob',
    'profile_image', 'barcode_image'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getProfileUrlAttribute()
{
    return route('profile.public', $this->uid);
}
}