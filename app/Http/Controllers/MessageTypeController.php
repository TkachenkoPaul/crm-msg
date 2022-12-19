<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageTypeRequest;
use App\Http\Requests\UpdateMessageTypeRequest;
use App\Models\Messages;
use App\Models\MessageType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class MessageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('message-types');
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = MessageType::with(['admin']);
            return DataTables::eloquent($data)
                ->addColumn('action', function($row){
                    return '<a href="#" class="btn btn-app"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return null;
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
     * @param  \App\Http\Requests\StoreMessageTypeRequest  $request
     * @return Response
     */
    public function store(StoreMessageTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MessageType  $messageType
     * @return Response
     */
    public function show(MessageType $messageType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MessageType  $messageType
     * @return Response
     */
    public function edit(MessageType $messageType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageTypeRequest  $request
     * @param  \App\Models\MessageType  $messageType
     * @return Response
     */
    public function update(UpdateMessageTypeRequest $request, MessageType $messageType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MessageType  $messageType
     * @return Response
     */
    public function destroy(MessageType $messageType)
    {
        //
    }
}
