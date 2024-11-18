<?php

namespace App\Http\Controllers\Staff;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MenuController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Menu::query();
            $table = datatables($query);
            $table->addColumn('action', function (Menu $menu) {
                $actions = sprintf('<a href="%s" class="btn btn-sm btn-success mr-2">%s</a>', route('staff.menu.show', $menu->id), __('Items'));
                $actions .= sprintf('<button class="btn btn-edit btn-sm btn-warning mr-2" data-id="%s" data-title="%s" data-location="%s">%s</button>', $menu->id, $menu->title, $menu->location, __('Edit'));
                $actions .= sprintf('<button class="btn btn-sm btn-delete btn-danger" data-id="%s">%s</button>', $menu->id, __('Delete'));
                return $actions;
            });
            $table->editColumn('location', function (Menu $menu) {
                    return config('menu.menu.locations')[$menu->location];
            });
            $table->rawColumns(['action']);
            return $table->make(true);
        }
        return view('staff.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required|string|max:191',
            'location' => 'required|max:191'
        ]);
        try {
            DB::beginTransaction();
            $menu = Menu::create($request->only(['title', 'location']));
            if (!$menu instanceof Menu) throw new \Exception('Unable to save menu');
            DB::commit();
            return redirect()->back()->withSuccess('Menu added successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    public function updateItems(Request $request, Menu $menu)
    {
        $request->validate([
            'data' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $menu->items()->delete();
            if (is_array($request->data)) {
                $this->orderMenu($menu->id, $request->data, null);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['data' => $exception->getMessage()]);
        }
        DB::commit();
    }

    private function orderMenu($menuID, array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::create([
                    'menu_id'=>$menuID,
                    'text'=> $menuItem['text'],
                    'url'=>$menuItem['url'],
                    'target'=>$menuItem['target'],
                    'type'=>$menuItem['type'],
                    'parent_id'=>$parentId,
                    'order'=>($index + 1)
            ]);
            if (isset($menuItem['children'])) {
                $this->orderMenu($menuID, $menuItem['children'], $item->id);
            }
        }
    }

    public function getItems(Request $request, Menu $menu)
    {
        // return $menu;
        $menuItems = Menu::where('id', '=', $menu->id)
            ->with(['items' => function($q) {
                $q->with(['children' => function($q2) {
                    $q2->orderBy('order', 'asc');
                }])->whereNull('parent_id')->orderBy('order', 'asc');
            }])
            ->first();
        return response($menuItems->items);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        if (!$menu) return abort(404);
        $cards = array_map(function ($class_name) {
            $item = [
                'id' => Str::slug($class_name::getLabel()),
                'name' => $class_name::getLabel(),
                'records' => $class_name::menurecords()
            ];
            return $item;
        }, config('menu.menuables'));
        // return $cards;
        return view('staff.menu.show', compact('cards', 'menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if (!$menu) return abort(404);
        $request->validate([
            'title' => 'required|string|max:191',
            'location' => 'required|max:191'
        ]);
        try {
            DB::beginTransaction();
            $res = $menu->update($request->only(['title', 'location']));
            if (!$res) throw new \Exception('Unable to update menu');
            DB::commit();
            return redirect()->back()->withSuccess('Menu updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if (!$menu) return abort(404);
        try {
            DB::beginTransaction();
            $res = $menu->delete();
            if (!$res) throw new \Exception('Unable to delete menu');
            DB::commit();
            return redirect()->back()->withSuccess('Menu deleted successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }
}
