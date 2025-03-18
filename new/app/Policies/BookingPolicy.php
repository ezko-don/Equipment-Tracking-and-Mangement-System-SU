<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

class BookingPolicy
{
    /**
     * Determine if the user can view all bookings (Admin Only).
     */
    public function viewAny(User $user)
    {
        return $user->role === 'admin'; // Ensure only admins can access
    }

    /**
     * Determine if the user can approve bookings (Admin Only).
     */
    public function approve(User $user, Booking $booking)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can mark equipment as returned (Admin Only).
     */
    public function return(User $user, Booking $booking)
    {
        return $user->role === 'admin';
    }
}