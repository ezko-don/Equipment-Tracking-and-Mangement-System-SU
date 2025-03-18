<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    // Show all equipment (for both users and admins)
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Equipment::query();

        if ($status) {
            $query->where('status', $status);
        }

        $equipment = $query->get();
        return view('equipment.index', compact('equipment'));
    }

    // Show form to create new equipment (Admin only)
    public function create()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }
        return view('equipment.create');
    }

    // Store new equipment in the database (Admin only)
    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Store Image
        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('equipment_images', 'public') 
            : null;

        // Create Equipment
        Equipment::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath
        ]);

        return redirect()->route('equipment.index')->with('success', 'Equipment added successfully.');
    }

    // Show a single equipment item
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipment.show', compact('equipment'));
    }

    // Show edit form (Admin only)
    public function edit($id)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        return view('equipment.edit', compact('equipment'));
    }

    // Update equipment details (Admin only)
    public function update(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $equipment = Equipment::findOrFail($id);

        $imagePath = $equipment->image; // Keep old image if no new one is uploaded
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

        return redirect()->route('equipment.index')->with('success', 'Equipment updated successfully');
    }

    // ✅ Booking functionality (User)
    public function book(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->status == 'booked') {
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

    // ✅ Approve Booking (Admin)
    public function approve($id)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    // ✅ Mark as returned (Admin)
    public function markAsReturned($id)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Equipment marked as returned.');
    }

    // ✅ Delete equipment (Admin only)
    public function destroy($id)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('equipment.index')->with('error', 'Unauthorized access.');
        }

        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipment.index')->with('success', 'Equipment deleted successfully');
    }
}