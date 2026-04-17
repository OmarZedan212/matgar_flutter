<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['group', 'products'])
            ->orderBy('name')
            ->get()
            ->map(function ($cat) {
                return [
                    'id'                 => $cat->id,
                    'name'               => $cat->name,
                    'slug'               => $cat->slug,
                    'status'             => $cat->status ?? 'active',
                    'product_count'      => $cat->products->count(),
                    'category_group_id'  => $cat->category_group_id,
                    'group_name'         => optional($cat->group)->name,
                ];
            });

        $categoryGroups = CategoryGroup::select('id', 'name')->orderBy('name')->get();

        return view('admin.categories', compact('categories', 'categoryGroups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'category_group_id' => 'nullable|integer|exists:category_groups,id',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['status'] = $data['status'] ?? 'active';

        $cat = Category::create($data);
        $cat->load('group:id,name');
        $cat->setAttribute('group_name', optional($cat->group)->name);
        unset($cat->group);
        return response()->json(['category' => $cat]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required|exists:categories,id',
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'category_group_id' => 'nullable|integer|exists:category_groups,id',
        ]);

        $cat = Category::findOrFail($data['id']);
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['status'] = $data['status'] ?? 'active';
        $cat->update($data);
        $cat->load('group:id,name');
        $cat->setAttribute('group_name', optional($cat->group)->name);
        unset($cat->group);
        return response()->json(['category' => $cat]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:categories,id',
        ]);
        Category::where('id', $request->id)->delete();

        return response()->json(['success' => true]);
    }
}