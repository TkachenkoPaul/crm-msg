<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;
use App\Models\Messages;
use App\Models\MessageType;
use App\Models\Reply;
use App\Models\StatusType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View|Application
     */
    public function index(Request $request): Factory|View|Application
    {
        if ($request->has('date-range')){
            $data['request'] =  route('messages.list',['date-range'=> $request->input('date-range')]);
            $date = explode(' ',$request->input('date-range'));
            $data['status'] = StatusType::withCount(['messages'=> function (Builder $query) use ($date){
                $query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);
            }])->get();

        } else {
            $data['request'] =  route('messages.list');
            $data['status'] = StatusType::withCount('messages')->get();
        }
        $data['all'] = Messages::query()->count();
        return view('messages',compact('data'));
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('messages as m')
            ->leftJoin('users as a','m.admin_id','=','a.id')
            ->leftJoin('users as r','m.responsible_id','=','r.id')
            ->leftJoin('status_types as s','m.status_id','=','s.type_id')
            ->leftJoin('message_types as t','m.type_id','=','t.id')
            ->select(['m.*','a.id as aid','a.name as aname','r.id as rid','r.name as rname','s.type_id as sid','s.name as sname','t.id as tid','t.name as tname']);
            if ($request->has('date-range')){
                $date = explode(' ',$request->input('date-range'));
                $data = $data->whereBetween('closed',[$date[0].' 00:00:00',$date[2].' 23:59:59']);
            }

            return DataTables::of($data)
                ->addColumn('action', function($row){

                    return "<a href=\"".route('messages.show',$row->id)."\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                })
                ->addColumn('options', function($row){
                    if (isset($row->uid)) {
                        $uid = "<a class=\"btn btn-sm bg-success\"><i class=\"fas fa-check\"></i></a>";
                    } else {
                        $uid =  "<a class=\"btn btn-sm bg-danger\"><i class=\"fas fa-times\" style=\"font-size: 20px;\"></i></a>";
                    }
                    if ($row->contract == 1) {
                        $contract =  "<a class=\"btn btn-sm bg-success\"><i class=\"fas fa-check\"></i></a>";
                    }else {
                        $contract =  "<a class=\"btn btn-sm bg-danger\"><i class=\"fas fa-times\" style=\"font-size: 20px;\"></i></a>";
                    }
                     if ($row->photo == 1) {
                        $photo =  "<a class=\"btn btn-sm bg-success\"><i class=\"fas fa-check\"></i></a>";
                    } else{
                        $photo = "<a class=\"btn btn-sm bg-danger\"><i class=\"fas fa-times\" style=\"font-size: 20px;\"></i></a>";
                    }
                    $html = '<li class="mb-3">ID - '.$uid.'</li>
                            <li class="mb-3">Договор - '.$contract.'</li>
                            <li class="mb-3">Фото - '.$photo.'</li>';
                    return '<ul class="list-unstyled">'.$html.'</ul>';
                })
                ->editColumn('fio', function($row) {
                    return "<span class=\"username\"><a href=\"".route('messages.show',$row->id)."\">".$row->fio."</a></span>";
                })
                ->editColumn('contract', function($row) {
                    if ($row->contract == 1) {
                        return "<a class=\"btn btn-sm bg-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-danger\"><i class=\"fas fa-times\"></i></a>";
                })
                 ->editColumn('photo', function($row) {
                    if ($row->photo == 1) {
                        return "<a class=\"btn btn-sm bg-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-danger\"><i class=\"fas fa-times\"></i></a>";
                })
                 ->editColumn('address', function($row) {
                    return "<span class=\"username\"><a href=\"".route('messages.show',$row->id)."\">".$row->address."</a></span>";
                })
                ->rawColumns(['action','fio','address','contract','photo','options'])
                ->make(true);

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
        $data['types'] = MessageType::all();
        $data['users'] = User::all();
        $data['status'] = StatusType::all();
        return view('new-message',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessagesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMessagesRequest $request)
    {
        $message = Messages::create($request->merge(['admin_id'=>auth()->user()->id])->validated());
        return redirect()->route('messages.index')->with('message_created','Создана заявка с номером: '.$message->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Messages $messages
     * @param $id
     * @return Application|Factory|View
     */
    public function show(Messages $messages,$id)
    {
        $data['types'] = MessageType::all();
        $data['users'] = User::all();
        $data['status'] = StatusType::all();
        return view('message',[
            'data' => $data,
            'message' => $messages->findOrFail($id),
            'replies' => Reply::query()->with('admin')->where('message_id',$id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Messages $messages
     * @return Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMessagesRequest $request
     * @param Messages $messages
     * @return RedirectResponse
     */
    public function update(UpdateMessagesRequest $request, Messages $messages,$id)
    {
	$message = $messages->findOrFail($id);
	if((string)$message->status_id === "5"){
		if(auth()->user()->id !== 1){
                        return redirect()->back()->with('message','Big ERROR!!!!!!!!!!Very Big');
                }
        }
	if((string)$request->status_id === "5"){
		if(auth()->user()->id !== 1){
			return redirect()->back()->with('message','Big ERROR!!!!!!!!!!');		
		}
	}
        $message->update($request->validated());
        if ((string)$request->status_id === "1") {
            $message->update(['closed' => Carbon::now()->format('Y-m-d H:i:s')]);
        } elseif((string)$request->status_id === "0") {
            $message->update(['closed' => '0000-00-00 00:00:00' ]);
        }
        return redirect()->back()->with('message','Заявка изменена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Messages $messages
     * @return Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
