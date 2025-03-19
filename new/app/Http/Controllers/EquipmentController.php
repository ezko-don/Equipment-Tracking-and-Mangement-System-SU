<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /**
     * Display all equipment (For normal users)
     */
    public function index(Request $request)
    {
        // Redirect admins to the admin dashboard instead of equipment page
        public function index(Request $request)
        {
            // If an admin tries to access the equipment page, redirect them to the admin dashboard
            if (Auth::check() && Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
        
            $status = $request->query('status');
            $query = Equipment::query();
        
            if ($status) {
                $query->where('status', $status);
            }
        
            $equipment = $query->get();
            return view('equipment.index', compact('equipment'));
        }  
    }

    /**
     * Show the form for creating new equipment (Admin only)
     */
    public function create()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        return view('equipment.create');
    }

    /**
     * Store new equipment in the database (Admin only)
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('equipment_images', 'public')
            : null;

        Equipment::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment added successfully.');
    }

    /**
     * Display a single equipment item
     */
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show edit form (Admin only)
     */
    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update equipment details (Admin only)
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $equipment = Equipment::findOrFail($id);
        $imagePath = $equipment->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment_images', 'public');
        }

        $equipment->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment updated successfully.');
    }

    /**
     * Book equipment (User only)
     */
    public function book(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->status === 'booked') {
            return back()->with('error', 'Equipment is already booked.');
        }

        $equipment->update([
            'status' => 'booked',
            'booked_by' => Auth::id(),
            'event_name' => $request->event_name,
            'location' => $request->location,
            'booked_at' => now(),
        ]);

        return back()->with('success', 'Equipment booked successfully!');
    }

    /**
     * Approve Booking (Admin only)
     */
    public function approve($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    /**
     * Mark Equipment as Returned (Admin only)
     */
    public function markAsReturned($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Equipment marked as returned.');
    }

    /**
     * Delete Equipment (Admin only)
     */
    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('admin.equipment.index')->with('success', 'Equipment deleted successfully.');
    }

    /**
     * Admin Dashboard (Only for Admins)
     */
    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $totalEquipment = Equipment::count();
        $bookedEquipment = Equipment::where('status', 'booked')->count();
        $availableEquipment = Equipment::where('status', 'available')->count();
        $pendingEquipment = Equipment::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalEquipment',
            'bookedEquipment',
            'availableEquipment',
            'pendingEquipment'
        ));
    }

    /**
     * Admin Equipment List (Only for Admins)
     */
    public function adminIndex()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::latest()->get();
        return view('admin.equipment.index', compact('equipment'));
    }
}