<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DataTables;
use Hash;

use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Throwable;
use function Ramsey\Uuid\v1;
use function Termwind\render;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('users');
    }

     public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->with('master','roles');
            return DataTables::eloquent($data)
                ->addColumn('action', function($row){

                    return "<a href=\"".route('users.show',$row->id)."\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                })
                ->addColumn('role', function($row){
                    if (isset($row->roles[0])){
                        return $row->roles[0]->name;
                    }
                    return '-';
                })
                ->editColumn('name', function($row) {
                    return "<span class=\"username\"><a href=\"".route('users.show',$row->id)."\">".$row->name."</a></span>";
                })
                ->editColumn('edit', function($row) {
                    return '<form method="get" action="'.route('users.show',$row->id).'"><button class="btn btn-block bg-gradient-success">Изменить</button></form>';
                })
                ->addColumn('delete',function ($row){
                    return '<form method="get" action="'.route('users.destroy',$row->id).'"><button class="btn btn-block bg-gradient-danger">Удалить</button></form>';
                })
                ->rawColumns(['action','name','disable','role','edit','delete'])
                ->toJson();
        }
        return  null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('new-user',['roles'=> Role::query()->where('name','!=','Super Admin')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->login = $request->login;
        $user->name = $request->name;
        $user->admin_id = auth()->user()->id;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);
        return redirect()->route('users.index')->with('user_created','Пользователь '.$request->name.' успешно зарегистрирован');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        return view('user',['user' => User::findOrFail($id),'roles'=> Role::query()->where('name','!=','Super Admin')->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response|null
     */
    public function edit(int $id)
    {
        return null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request,User $user, $id)
    {
        $user = $user->findOrFail($id);
        if ($request->isNotFilled('password')) {
            $user->update($request->validated());
        } else {
            $user->name = $request->name;
            $user->login = $request->login;
            $user->disable = $request->disable;
            $user->password = Hash::make($request->password);
            $user->save();
        }
        $user->syncRoles($request->role);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(int $id)
    {
       User::findOrFail($id)->deleteOrFail();
       return redirect()->back()->with('user_created','Пользователь удален');
    }
}
