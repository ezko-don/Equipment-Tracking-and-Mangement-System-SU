<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'category', 
        'description', 
        'status', 
        'image', 
        'booked_by', 
        'event_name', 
        'location', 
        'booked_at'
    ];

    protected $casts = [
        'booked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
}