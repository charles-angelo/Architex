<?php

namespace App\Http\Controllers;

use App\Models\Lots;
use App\Models\Block;
use App\Models\LotsCategory;
use App\Models\LotsFloorPlan;
use App\Models\LotsType;
use App\Models\LotsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lots = Lots::with(['block', 'category', 'type', 'images'])
            ->orderBy('id', 'asc')
            ->get();

        $blocks = Block::all();
        $types = LotsType::all();

        return view('admin.lots.index', compact('lots', 'blocks', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blocks = Block::all();
        $categories = LotsCategory::all();
        $types = LotsType::all();

        return view('admin.lots.create', compact('blocks', 'categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id'      => 'required|exists:blocks,id',
            'category_id'   => 'required|exists:lots_categories,id',
            'type_id'       => 'required|exists:lots_types,id',
            'lot_name'      => 'required|string|max:255',
            'listing_type'  => 'required|in:for_sale,for_rent', // ✅ added
            'area'          => 'required|numeric|min:0',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:available,sold,reserved',
            'description'   => 'nullable|string',
            'x'             => 'nullable|numeric',
            'y'             => 'nullable|numeric',
            'images.*'      => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'floor_plan.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        // ✅ Create the lot
        $lot = Lots::create($validated);

        // ✅ Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/lots'), $filename);

                LotsImage::create([
                    'lots_id' => $lot->id,
                    'image'   => 'storage/lots/' . $filename,
                ]);
            }
        }

        // ✅ Save floor plans
        if ($request->hasFile('floor_plan')) {
            foreach ($request->file('floor_plan') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/floorplan'), $filename);

                LotsFloorPlan::create([
                    'lots_id' => $lot->id,
                    'floor_plan' => 'storage/floorplan/' . $filename,
                ]);
            }
        }

        return redirect()
            ->route('admin.lots.index')
            ->with('success', 'Lot created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lots $lot)
    {
        $blocks = Block::all();
        $categories = LotsCategory::all();
        $types = LotsType::all();

        return view('admin.lots.edit', compact('lot', 'blocks', 'categories', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lots $lot)
    {
        Log::info('Lots update method called', [
            'lot_id' => $lot->id,
            'request' => $request->all(),
        ]);

        try {
            $validated = $request->validate([
                'block_id'          => 'nullable|exists:blocks,id',
                'category_id'       => 'nullable|exists:lots_categories,id',
                'type_id'           => 'nullable|exists:lots_types,id',
                'lot_name'          => 'required|string|max:255',
                'area'              => 'required|numeric|min:0',
                'price'             => 'required|numeric|min:0',
                'status'            => 'required|in:available,sold,reserved',
                'listing_type'      => 'required|in:for_sale,for_rent', // 👈 Added validation
                'description'       => 'nullable|string',
                'x'                 => 'nullable|numeric',
                'y'                 => 'nullable|numeric',
                'images.*'          => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
                'floor_plan.*'      => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
                'remove_images'     => 'nullable|array',
                'remove_floorplans' => 'nullable|array',
            ]);

            // Update lot details
            $lot->update($validated);

            /** 🗑️ Remove selected images */
            if ($request->filled('remove_images')) {
                foreach ($request->remove_images as $imgId) {
                    $img = LotsImage::find($imgId);
                    if ($img) {
                        if (file_exists(public_path($img->image))) {
                            unlink(public_path($img->image));
                        }
                        $img->delete();
                    }
                }
                Log::info('Removed selected images', ['lot_id' => $lot->id]);
            }

            /** 🗑️ Remove selected floor plans */
            if ($request->filled('remove_floorplans')) {
                foreach ($request->remove_floorplans as $fpId) {
                    $fp = LotsFloorPlan::find($fpId);
                    if ($fp) {
                        if (file_exists(public_path($fp->floor_plan))) {
                            unlink(public_path($fp->floor_plan));
                        }
                        $fp->delete();
                    }
                }
                Log::info('Removed selected floor plans', ['lot_id' => $lot->id]);
            }

            /** 📸 Add new images */
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/lots'), $filename);

                    LotsImage::create([
                        'lots_id' => $lot->id,
                        'image'   => 'storage/lots/' . $filename,
                    ]);
                }
                Log::info('New images added', ['lot_id' => $lot->id]);
            }

            /** 📐 Add new floor plans */
            if ($request->hasFile('floor_plan')) {
                foreach ($request->file('floor_plan') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/floorplan'), $filename);

                    LotsFloorPlan::create([
                        'lots_id'    => $lot->id,
                        'floor_plan' => 'storage/floorplan/' . $filename,
                    ]);
                }
                Log::info('New floor plans added', ['lot_id' => $lot->id]);
            }

            return redirect()->route('admin.lots.index')->with('success', 'Lot updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating lot', [
                'lot_id' => $lot->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong during update.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lot = Lots::findOrFail($id);

        // ✅ Delete all associated images
        foreach ($lot->images as $image) {
            if (file_exists(public_path($image->image))) {
                unlink(public_path($image->image));
                Log::info('Deleted lot image', ['image' => $image->image]);
            }
            $image->delete();
        }

        $lot->delete();
        Log::info('Lot deleted successfully', ['lot_id' => $id]);

        return redirect()->route('admin.lots.index')->with('success', 'Lot deleted successfully.');
    }

    public function destroyImage($id)
    {
        $image = LotsImage::findOrFail($id);

        // Delete image file from storage
        if (file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        Log::info('Lot image deleted', ['image_id' => $id]);

        return response()->json(['success' => true]);
    }
}
