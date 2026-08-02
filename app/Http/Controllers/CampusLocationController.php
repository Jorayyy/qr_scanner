<?php

namespace App\Http\Controllers;

use App\Models\CampusLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CampusLocationController extends Controller
{
    public function index()
    {
        $campusLocations = CampusLocation::ordered()->get();

        return view('admin.campus-locations', compact('campusLocations'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateLocation($request);

        CampusLocation::create($validated);

        return back()->with('success', 'Campus location added successfully!');
    }

    public function update(Request $request, CampusLocation $campusLocation)
    {
        $validated = $this->validateLocation($request, $campusLocation->id);

        $campusLocation->update($validated);

        return back()->with('success', 'Campus location updated successfully!');
    }

    public function destroy(CampusLocation $campusLocation)
    {
        $campusLocation->delete();

        return back()->with('success', 'Campus location removed successfully!');
    }

    private function validateLocation(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('campus_locations', 'name')
                    ->where(fn ($query) => $query->where('usage_scope', $request->usage_scope))
                    ->ignore($ignoreId),
            ],
            'usage_scope' => ['required', 'in:visit,scanner,shared'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}