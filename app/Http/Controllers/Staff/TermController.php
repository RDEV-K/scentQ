<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Taxonomy;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->taxonomy_id) ValidationException::withMessages(['taxonomy' => 'Invalid Taxonomy']);
        $query = Term::query()->with(['metas'])->where('taxonomy_id', $request->taxonomy_id);
        $table = datatables($query);
        $table->editColumn('id', function ($term) {
            if ($term->image) {
                return sprintf('<div class="d-flex"><img src="%s" class="img-thumbnail mr-2" width="50" height="50"/><p>%s</p></div>', $term->image, $term->name);
            }
            return $term->name;
        });
        $table->editColumn('add_to', function ($taxonomy) {
            return $taxonomy->metas->where('name', 'add_to')->implode('content', ', ');
        });
        $table->addColumn('action', function ($term) {
            $matas = [];
            $matas['add_to'] = $term->metas->where('name', 'add_to')->pluck('content');
            $actions = sprintf('<button class="btn btn-sm btn-warning btn-edit mr-2" data-id="%s" data-taxonomy_id="%s" data-name="%s" data-slug="%s" data-image="%s" data-vector="%s" data-metas=\'%s\'><i class="fas fa-edit"></i></button>', $term->id, $term->taxonomy_id, $term->name, $term->slug, $term->image, $term->vector, json_encode($matas));
            $actions .= sprintf('<button class="btn btn-sm btn-danger btn-delete" data-id="%s"><i class="fas fa-trash"></i></button>', $term->id);
            return $actions;
        });
        $table->filterColumn('id', function ($query, $keyword) {
            $query->where('name', 'LIKE', "$keyword%");
        });
        $table->rawColumns(['id', 'action']);
        return $table->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199',
            'taxonomy_id' => 'required|numeric|exists:taxonomies,id',
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        try {
            DB::beginTransaction();
            /* @var Term $term */
            $term = Term::create($request->only(['taxonomy_id', 'name', 'slug', 'image', 'vector']));
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
                $term->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Term Added'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['name' => $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199',
            'taxonomy_id' => 'required|numeric|exists:taxonomies,id',
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        try {
            DB::beginTransaction();
            /* @var Term $term */
            $res = $term->update($request->only(['taxonomy_id', 'name', 'slug', 'image', 'vector']));
            if (!$res) throw new \Exception(__('Unable to update term'));
            $term->metas()->delete();
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
                $term->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Term Updated'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['name' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        if (!$term) return abort(404);
        try {
            DB::beginTransaction();
            $term->metas()->delete();
            $res = $term->delete();
            if (!$res) throw new \Exception(__('Unable to delete term'));
            DB::commit();
            return redirect()->back()->withSuccess(__('Term deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
}
