<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryGroupController extends Controller
{
    public function index()
    {
        $groups = CategoryGroup::withCount('categories')
            ->orderBy('name')
            ->get()
            ->map(function ($g) {
                return [
                    'id'              => $g->id,
                    'name'            => $g->name,
                    'slug'            => $g->slug,
                    'status'          => $g->status ?? 'active',
                    'categories_count'=> $g->categories_count ?? 0,
                ];
            });

        return view('admin.category_groups', [
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:category_groups,slug',
            'status' => 'nullable|in:active,inactive',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['status'] = $data['status'] ?? 'active';

        $group = CategoryGroup::create($data);

        return response()->json(['group' => $group]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required|exists:category_groups,id',
            'name'   => 'required|string|max:255',
            'slug'   => 'nullable|string|max:255|unique:category_groups,slug,' . $request->id,
            'status' => 'nullable|in:active,inactive',
        ]);

        $group = CategoryGroup::findOrFail($data['id']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['status'] = $data['status'] ?? 'active';

        $group->update($data);

        return response()->json(['group' => $group]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:category_groups,id',
        ]);

        $group = CategoryGroup::findOrFail($request->id);

        // لو مش عايز تمسح الجروب اللي عليه كاتيجوريز:
        if ($group->categories()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete group with categories attached.',
            ], 422);
        }

        $group->delete();

        return response()->json(['success' => true]);
    }
}
