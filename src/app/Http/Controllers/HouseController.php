<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::with(['images' => function ($query) {
            $query->limit(1);
        }])->paginate(6);

        return view('houses.sections.index', compact('houses'));
    }

    public function show(House $house)
    {
        $house->load('images');

        return view('houses.sections.show', compact('house'));
    }

    public function create()
    {
        return view('houses.sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images') && count($request->file('images')) > 5) {
            return redirect()->back()->with('error', 'You can only upload up to 5 images.');
        }

        $house = auth()->user()->houses()->create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/houses', 'public');
                $house->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('houses.show', $house)->with('success', 'House created successfully.');
    }

    public function edit(House $house)
    {
        if (auth()->id() !== $house->owner_id) {
            return redirect()->route('houses.show', $house)->with('error', 'You are not authorized to edit this house.');
        }

        return view('houses.sections.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        if (auth()->id() !== $house->owner_id) {
            return redirect()->route('houses.show', $house)->with('error', 'You are not authorized to update this house.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'isAvailable' => 'boolean',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $currentImagesCount = $house->images()->count();
        $newImagesCount = $request->hasFile('new_images') ? count($request->file('new_images')) : 0;
        $deletedImagesCount = $request->has('deleted_images') ? count($request->deleted_images) : 0;

        if (($currentImagesCount - $deletedImagesCount + $newImagesCount) > 5) {
            return redirect()->back()->with('error', 'You can only have a maximum of 5 images.');
        }

        $house->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price_per_night' => $validated['price_per_night'],
            'location' => $validated['location'],
            'contact_phone' => $validated['contact_phone'],
            'contact_email' => $validated['contact_email'],
            'isAvailable' => $validated['isAvailable'],
        ]);

        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $imageId) {
                $image = $house->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('images/houses', 'public');
                $house->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('houses.show', $house)->with('success', 'House updated successfully.');
    }

    public function destroy(House $house)
    {
        if (auth()->id() !== $house->owner_id) {
            return redirect()->route('houses.show', $house)->with('error', 'You are not authorized to delete this house.');
        }

        foreach ($house->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $house->delete();

        return redirect()->route('houses.index')->with('success', 'House deleted successfully.');
    }

    public function myHouses()
    {
        $houses = auth()->user()->houses()->latest()->get();

        return view('houses.sections.my', compact('houses'));
    }
}
