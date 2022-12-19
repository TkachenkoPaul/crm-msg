<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Hash;

use function Ramsey\Uuid\v1;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users');
    }

     public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->with('master');
            return DataTables::eloquent($data)
                ->addColumn('action', function($row){

                    return "<a href=\"".route('users.show',$row->id)."\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                })
                ->editColumn('name', function($row) {
                    return "<span class=\"username\"><a href=\"".route('users.show',$row->id)."\">".$row->name."</a></span>";
                })
                ->rawColumns(['action','name','disable'])
                ->toJson();
        }
        return  null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new-user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->login = $request->login;
        $user->name = $request->name;
        $user->admin_id = auth()->user()->id;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.index')->with('user_created','Пользователь '.$request->name.' успешно зарегистрирован');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('user',['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
