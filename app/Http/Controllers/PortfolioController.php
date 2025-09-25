<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Certificate;
use App\Models\Career;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function arrange()
    {
        $portfolioItems = PortfolioItem::orderBy('order')->get();
        $projects = Project::whereNotIn('id', $portfolioItems->where('item_type', Project::class)->pluck('item_id'))->get();
        $certificates = Certificate::whereNotIn('id', $portfolioItems->where('item_type', Certificate::class)->pluck('item_id'))->get();
        $careers = Career::whereNotIn('id', $portfolioItems->where('item_type', Career::class)->pluck('item_id'))->get();

        return view('portfolio.arrange', compact('portfolioItems', 'projects', 'certificates', 'careers'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'sometimes|exists:portfolio_items,id',
            'items.*.type' => 'required|in:project,certificate,career',
            'items.*.item_id' => 'required|integer'
        ]);

        // Eliminar todos los items actuales
        PortfolioItem::truncate();

        // Insertar los nuevos items con el orden correcto
        foreach ($request->items as $index => $item) {
            PortfolioItem::create([
                'item_id' => $item['item_id'],
                'item_type' => match($item['type']) {
                    'project' => Project::class,
                    'certificate' => Certificate::class,
                    'career' => Career::class,
                },
                'order' => $index + 1
            ]);
        }

        return response()->json(['message' => 'Orden actualizado correctamente']);
    }
}
