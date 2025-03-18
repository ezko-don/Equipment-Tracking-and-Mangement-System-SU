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
        'status',
        'booked_by', 
        'event_name', 
        'location', 
        'booked_at'
    ];
}