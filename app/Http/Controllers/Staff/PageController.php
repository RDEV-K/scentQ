<?php

namespace App\Http\Controllers\Staff;

use App\Models\Page;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Ui\Presets\Vue;

class PageController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Page::query();
            $table = datatables($query);
            $table->addColumn('action', function (Page $page) {
                    // return '';
                    if (!$page->is_builtin) {
                        return '<div class="d-flex mt-1">
                                    <a href="' . route('staff.page.edit', $page->id) . '" class="btn btn-warning btn-edit btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $page->id . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>';
                    }
                    if (is_array($page->sections) && count($page->sections)) {
                        return '<a href="' . route('staff.page.show', $page->id) . '" class="btn btn-primary btn-edit btn-sm">Section</a>
                                <div class="d-flex mt-1">
                                    <a href="' . route('staff.page.edit', $page->id) . '" class="btn btn-warning btn-edit btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>';
                    }else{
                        return '<div class="d-flex mt-1">
                                    <a href="' . route('staff.page.edit', $page->id) . '" class="btn btn-warning btn-edit btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>';
                    }
            });
            $table->editColumn('status', function(Page $page){
                return $page->status == 'published' ? '<span class="badge badge-success">'.__('published').'</span>' : '<span class="badge badge-danger">'.__('Drafted').'</span>';
            });
            $table->rawColumns(['action', 'status']);
            return $table->make(true);
        }
        return view('staff.page.page-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.page.page-create');
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
            'title'       => 'required|string|max:191',
            'slug'        => 'required|alpha_dash|max:199|unique:pages,slug',
            'content'     => 'nullable|string',
            'status'      => 'required|in:published,drafted',
            'image'        => 'nullable|string',
        ]);

        $page = $request->only(['title', 'slug', 'content', 'status', 'image']);
        $res = Page::create(array_merge($page, [
            'type' => 'page',
            'template' => 'Page'
        ]));
        if (!$res) redirect()->back()->withInput()->withErrors('Unable to create Page');
        return redirect()->route('staff.page.index')->withSuccess('Page Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        if (!(is_array($page->sections) && count($page->sections))) return abort(404);
        if ($page->is_builtin)
            return view('staff.page.section.' . str_replace('/', '_', strtolower($page->template)), compact('page'));
        return view('staff.page.section.page', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('staff.page.editPage', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Page $page)
    {
        // return $page;
        $validate = [
            'title'       => 'required|string|max:191',
            'content'     => 'nullable|string',
            'status'      => 'required|in:published,drafted',
            'image'        => 'nullable|string',
        ];
        if ($page->is_builtin) {
            $validate['slug'] = 'nullable';
        }else{
            $validate['slug'] = 'required|alpha_dash|max:199|unique:pages,slug,'.$page->id;
        };
        $request->validate($validate);

        if ($page->is_builtin) {
            $param = ['title', 'content', 'status', 'image'];
        }else{
            $param = ['title', 'slug', 'content', 'status', 'image'];
        }

        $res = $page->update($request->only($param));
        if (!$res) redirect()->back()->withInput()->withErrors('Unable to update  Page');
        return redirect()->route('staff.page.index')->withSuccess('Page updated successfully');
    }

    /**
     * Update the page sections in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function updateSections(Request $request, Page $page)
    {
        $request->validate([
            'sections' => 'required|array'
        ]);

        try {
            $page->update(['sections' => $request->sections]);
            return redirect()->back()->withSuccess(__('Sections Updated successfully'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['sections' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (!$page) return abort(404);
        try {
            DB::beginTransaction();
            $page->metas()->delete();
            $res = $page->delete();
            if (!$res) throw new \Exception(__('Unable to delete Page'));
            DB::commit();
            return redirect()->back()->withSuccess(__('Page deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
}
