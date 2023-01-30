<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppealRequest;
use App\Http\Requests\UpdateAppealRequest;
use App\Models\Appeal;
use App\Models\Messages;
use DataTables;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class AppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('appeals');
    }

    /**
     * @throws Exception
     */
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('appeals as a');
            return DataTables::of($data)
                ->editColumn('agreed', function ($row) {

                    if ($row->agreed !== 1) {
                        return "<button class=\"btn btn-sm bg-gradient-success\"><i class=\"far fa-check-circle\"></i></a>";
                    } else {
                        return "<button class=\"btn btn-sm bg-gradient-danger\"><i class=\"far fa-times-circle\"></i></a>";
                    }

                })
                ->addColumn('action', function ($row) {

                    return "<a href=\"" . route('appeals.accept', $row->id) . "\" class=\"btn btn-sm bg-gradient-primary\"><i class=\"fas fa-plus-circle\"></i></a>";
                })
                ->addColumn('delete', function ($row) {
                    return "<a href=\"" . route('appeals.destroy', $row->id) . "\" class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-trash-alt\"></i></a>";
                })
                ->rawColumns([
                    'agreed',
                    'action',
                    'delete',

                ])
                ->make(true);

        }
        return null;
    }

    /**
     * @throws Throwable
     */
    public function accept(Request $request, $id)
    {
        DB::transaction(function () use ($id): void {
            $appeals = Appeal::findOrFail($id);
            $messages = new Messages();
            $messages->fio = $appeals->fio;
            $messages->address = $appeals->address;
            $messages->house = $appeals->house;
            $messages->phone = $appeals->phone;
            $messages->admin_id = \Auth::user()->id;
            $messages->responsible_id = \Auth::user()->id;
            $messages->save();
            $appeals->delete();
        });
        return redirect()->back()->with('message_created', 'Обращение #' . $id . ' взято в обработку');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppealRequest $request
     * @return void
     */
    public function store(StoreAppealRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Appeal $appeal
     * @return Response
     */
    public function show(Appeal $appeal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Appeal $appeal
     * @return Response
     */
    public function edit(Appeal $appeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppealRequest $request
     * @param Appeal $appeal
     * @return void
     */
    public function update(UpdateAppealRequest $request, Appeal $appeal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Appeal $appeal
     * @param $id
     * @return RedirectResponse
     */
    public function destroy(Appeal $appeal, $id)
    {
        $appeal->findOrFail($id)->delete();
        return redirect()->back()->with('message_created', 'Обращение #' . $id . ' удалено');
    }
}
