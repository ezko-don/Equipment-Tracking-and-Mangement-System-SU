<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests; // ✅ This should be used inside the class

    // ✅ Show all bookings (Admins only)
    public function index()
    {
        $this->authorize('viewAny', Booking::class); // Ensure only admins access this

        $bookings = Booking::with('user', 'equipment')->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    // ✅ User books equipment
    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->status === 'booked') {
            return back()->with('error', 'Equipment is already booked.');
        }

        // Create a booking record
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'equipment_id' => $request->equipment_id,
            'event_name' => $request->event_name,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending', // Initially pending approval
        ]);

        $equipment->update(['status' => 'pending']);

        return redirect()->route('dashboard')->with('success', 'Booking request sent!');
    }

    // ✅ Admin approves a booking
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $this->authorize('approve', $booking); // Ensure policy exists

        $booking->update(['status' => 'approved']);
        $booking->equipment->update(['status' => 'booked']);

        return back()->with('success', 'Booking approved successfully.');
    }

    // ✅ Admin marks as returned
    public function markAsReturned($id)
    {
        $booking = Booking::findOrFail($id);
        $this->authorize('return', $booking); // Ensure policy exists

        $booking->update(['status' => 'returned']);
        $booking->equipment->update(['status' => 'available']);

        return back()->with('success', 'Equipment marked as returned.');
    }

    // ✅ User cancels a booking (before approval)
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $booking->equipment->update(['status' => 'available']);
        $booking->delete();

        return back()->with('success', 'Booking canceled.');
    }
}