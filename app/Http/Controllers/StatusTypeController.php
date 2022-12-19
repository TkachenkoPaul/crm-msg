<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusTypeRequest;
use App\Http\Requests\UpdateStatusTypeRequest;
use App\Models\Messages;
use App\Models\StatusType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class StatusTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('status-types');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusType::with(['admin']);
            return DataTables::eloquent($data)
                ->addColumn('action', function($row){
                    return '<a href="#" class="btn btn-app"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return  null;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusTypeRequest  $request
     * @return Response
     */
    public function store(StoreStatusTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatusType  $statusType
     * @return Response
     */
    public function show(StatusType $statusType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatusType  $statusType
     * @return Response
     */
    public function edit(StatusType $statusType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusTypeRequest  $request
     * @param  \App\Models\StatusType  $statusType
     * @return Response
     */
    public function update(UpdateStatusTypeRequest $request, StatusType $statusType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusType  $statusType
     * @return Response
     */
    public function destroy(StatusType $statusType)
    {
        //
    }
}
