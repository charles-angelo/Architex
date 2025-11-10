<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Properties;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        // No pagination here since DataTables is used (you can paginate via AJAX later if needed)
        $blocks = Block::with('property')->latest()->get();
        $properties = Properties::all();

        return view('admin.blocks.index', compact('blocks', 'properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'block_number' => 'required|string|max:255',
        ]);

        $block = Block::create($request->only('property_id', 'block_number'));

        // Return JSON instead of redirect
        return response()->json([
            'id' => $block->id,
            'property_id' => $block->property_id,
            'property_name' => $block->property->name ?? 'N/A',
            'block_number' => $block->block_number,
        ]);
    }

    public function update(Request $request, Block $block)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'block_number' => 'required|string|max:255',
        ]);

        $block->update($request->only('property_id', 'block_number'));

        // Return JSON instead of redirect
        return response()->json([
            'id' => $block->id,
            'property_id' => $block->property_id,
            'property_name' => $block->property->name ?? 'N/A',
            'block_number' => $block->block_number,
        ]);
    }

    public function destroy(Block $block)
    {
        $block->delete();

        // Return JSON instead of redirect
        return response()->json(['success' => true]);
    }
}
