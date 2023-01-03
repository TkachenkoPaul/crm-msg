<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('roles');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()){
            $data = DB::table('roles as r')->select(['r.*'])->where('r.name','!=','Super Admin');
            return DataTables::of($data)
                ->addColumn('edit',function ($row){
                    return '<form method="get" action="'.route('roles.show',$row->id).'"><button class="btn btn-block bg-gradient-success">Изменить</button></form>';
                })
                ->addColumn('delete',function ($row){
                    return '<form method="get" action="'.route('roles.destroy',$row->id).'"><button class="btn btn-block bg-gradient-danger">Удалить</button></form>';
                })
                ->rawColumns(['edit','delete'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return  view('new-role',['permissions' => Permission::orderBy('name')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'permissions.*' => 'required|integer|exists:permissions,id'
        ]);
        $newRole = Role::create(['name' => $request->name]);
        $permissions = Permission::query()->whereIn('id',$request->permissions)->get();
        $newRole->syncPermissions($permissions);
        return redirect()->back()->with('success','Создана роль '.$request->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
       return view('role',['role'=> Role::findOrFail($id),'permissions' => Permission::orderBy('name')->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'permissions' => 'required',
            'permissions.*' => 'required|integer|exists:permissions,id'
        ]);
        $role = Role::query()->where('name','!=','Super Admin')->findOrFail($id);
        $role->update(['name' => $request->name]);
        $permissions = Permission::query()->whereIn('id',$request->permissions)->get();
        $role->syncPermissions($permissions);
        return redirect()->back()->with('success','Роль изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(Role $role,$id)
    {
        Role::query()->where('name','!=','Super Admin')->findOrFail($id)->delete();
        return  redirect()->back()->with('success','Роль успешно удалена');
    }
}
