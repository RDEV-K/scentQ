<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TaxonomyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Taxonomy::query()->with('metas');
            $table = datatables($query);
            $table->editColumn('add_to', function ($taxonomy) {
                return $taxonomy->metas->where('name', 'add_to')->implode('content', ', ');
            });
            $table->addColumn('action', function ($taxonomy) {
                $matas = [];
                $matas['add_to'] = $taxonomy->metas->where('name', 'add_to')->pluck('content');
                $actions = sprintf('<a href="%s" class="btn btn-sm btn-success mr-2"><i class="fas fa-network-wired"></i></a>', route('staff.taxonomy.show', $taxonomy->id));
                $actions .= sprintf('<button class="btn btn-sm btn-warning btn-edit mr-2" data-id="%s" data-name="%s" data-slug="%s" data-image="%s" data-vector="%s" data-metas=\'%s\'><i class="fas fa-edit"></i></button>', $taxonomy->id, $taxonomy->name, $taxonomy->slug, $taxonomy->image, $taxonomy->vector, json_encode($matas));
                if ($taxonomy->is_builtin) return $actions;
                $actions .= sprintf('<button class="btn btn-sm btn-danger btn-delete" data-id="%s"><i class="fas fa-trash"></i></button>', $taxonomy->id);
                return $actions;
            });
            return $table->make(true);
        }
        return view('staff.taxonomy.index');
    }

    public function show(Taxonomy $taxonomy)
    {
        if (!$taxonomy) return abort(404);
        return view('staff.taxonomy.terms', compact('taxonomy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199|unique:taxonomies,slug',
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        $p = $request->only(['name', 'slug', 'image', 'vector']);
        try {
            DB::beginTransaction();
            $taxonomy = Taxonomy::create($p);
            if (is_array($request->meta)) {
                $metas = [];
                foreach ($request->meta as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $sv) {
                            $metas[] = [
                                'name' => $k,
                                'content' => $sv
                            ];
                        }
                    } else {
                        $metas[] = [
                            'name' => $k,
                            'content' => $v
                        ];
                    }
                }
                $taxonomy->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Taxonomy added successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    public function update(Request $request, Taxonomy $taxonomy)
    {
        if (!$taxonomy) return abort(404);
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199|unique:taxonomies,slug,' . $taxonomy->id,
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        $p = $request->only(['name', 'slug', 'image', 'vector']);
        try {
            DB::beginTransaction();
            $res = $taxonomy->update($p);
            if (!$res) throw new \Exception(__('Unable to update taxonomy'));
            $taxonomy->metas()->delete();
            if (is_array($request->meta)) {
                foreach ($request->meta as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $sv) {
                            $metas[] = [
                                'name' => $k,
                                'content' => $sv
                            ];
                        }
                    } else {
                        $metas[] = [
                            'name' => $k,
                            'content' => $v
                        ];
                    }
                }
                $taxonomy->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Taxonomy updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    public function destroy(Taxonomy $taxonomy)
    {
        if (!$taxonomy) return abort(404);
        if ($taxonomy->is_builtin) return abort(404);
        try {
            DB::beginTransaction();
            $taxonomy->metas()->delete();
            $res = $taxonomy->delete();
            if (!$res) throw new \Exception(__('Unable to delete taxonomy'));
            DB::commit();
            return redirect()->back()->withSuccess(__('Taxonomy deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
    
}
