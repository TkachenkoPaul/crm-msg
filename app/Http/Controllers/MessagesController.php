<?php

namespace App\Http\Controllers;

use App\Exports\MessagesExport;
use App\Http\Requests\StoreMessagesRequest;
use App\Http\Requests\UpdateMessagesRequest;
use App\Imports\MessagesImport;
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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DataTables;
use DB;
use PDF;
use Zip;
use Excel;
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
        $data['status'] = StatusType::query();
        $paramArray = array();
        if ($request->has('status_id')){
            $data['status'] = $data['status']->where('type_id','=',$request->input('status_id'));
            $paramArray['status_id'] = $request->input('status_id');

        }
        if ($request->has('date-range')){
            $data['header'] = $request->input('date-range');
            $paramArray['date-range'] = $request->input('date-range');
            $date = explode(' ',$request->input('date-range'));
            $data['status'] = $data['status']->withCount(['messages'=> function (Builder $query) use ($date){
                $query->whereBetween('messages.closed',[$date[0].' 00:00:00',$date[2].' 23:59:59']);
            }])->get();

        } else {
            $data['status'] = $data['status']->withCount('messages')->get();
        }
        $data['request'] =  route('messages.list',$paramArray);
        return view('messages',compact('data'));
    }

    public function datatables(Request $request): ?JsonResponse
    {
        if ($request->ajax()) {
            $data = DB::table('messages as m')
                ->select(['m.*','a.id as aid','a.name as aname','r.id as rid','r.name as rname','s.type_id as sid','s.name as sname','t.id as tid','t.name as tname']);
            if ($request->has('status_id')){
                $data = $data->where('m.status_id','=',$request->input('status_id'));
            }
            if ($request->has('date-range')){
                $date = explode(' ',$request->input('date-range'));
                $data = $data->whereBetween('m.closed',[$date[0].' 00:00:00',$date[2].' 23:59:59']);
            }
            if ($request->has('amp;date-range')){
                $date = explode(' ',$request->input('amp;date-range'));
                $data = $data->whereBetween('m.closed',[$date[0].' 00:00:00',$date[2].' 23:59:59']);
            }
            $data = $data->leftJoin('users as a','m.admin_id','=','a.id')
                ->leftJoin('users as r','m.responsible_id','=','r.id')
                ->leftJoin('status_types as s','m.status_id','=','s.type_id')
                ->leftJoin('message_types as t','m.type_id','=','t.id');
            return DataTables::of($data)
                ->addColumn('action', function($row){

                    return "<a href=\"".route('messages.show',$row->id)."\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                })
                ->addColumn('options', function($row){
                    if (isset($row->uid)) {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn btn-sm bg-success\" ><i  style=\"font-size: .60rem;\" class=\"fas fa-satellite-dish\"></i></a>";
                    } else {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn btn-sm bg-success\"><i  style=\"font-size: .60rem;\" class=\"fas fa-satellite-dish\"></i></a>";
                    }
                    if ($row->contract == 1) {
                        $contract = "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-success\"><i style=\"font-size: .60rem;\" class=\"fas fa-file-contract\"></i></a>";
                    }else {
                        $contract = "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-danger\"><i style=\"font-size: .60rem;\" class=\"fas fa-file-contract\"></i></a>";
                    }
                     if ($row->photo == 1) {
                        $photo = "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-success\"><i style=\"font-size: .60rem;\" class=\"fas fa-images\"></i></a>";
                    } else{
                        $photo = "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-danger\"><i style=\"font-size: .60rem;\" class=\"fas fa-images\"></i></a>";
                    }
                    $html = '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">'.$uid.'</div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">'.$contract.'</div><div class="col-sm-4 col-md-12 col-lg-12 col-xl-4">'.$photo.'</div>';
                    return '<div class="row" style="font-size: 10px;">'.$html.'</div>';
                })
                ->addColumn('idNumber',function ($row){
                    if (isset($row->uid)) {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn btn-sm bg-gradient-success\" ><i class=\"fas fa-satellite-dish\"></i></a>";
                    } else {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-satellite-dish\"></i></a>";
                    }
                    return $uid;
                })
                ->addColumn('contractStatus',function ($row){
                    if ($row->contract == 1) {
                        return "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-success\"><i class=\"fas fa-file-contract\"></i></a>";
                    }else {
                        return "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-danger\"><i class=\"fas fa-file-contract\"></i></a>";
                    }
                })
                ->addColumn('photoStatus',function ($row){
                    if ($row->photo == 1) {
                        return "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-success\"><i class=\"fas fa-images\"></i></a>";
                    } else{
                        return "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-danger\"><i class=\"fas fa-images\"></i></a>";
                    }
                })
                ->editColumn('fio', function($row) {
                    return "<span class=\"username\"><a href=\"".route('messages.show',$row->id)."\">".$row->fio."</a></span>";
                })
                ->editColumn('contract', function($row) {
                    if ($row->contract == 1) {
                        return "<a class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-times\"></i></a>";
                })
                ->editColumn('photo', function($row) {
                    if ($row->photo == 1) {
                        return "<a class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-times\"></i></a>";
            })
                ->editColumn('address', function($row) {
                    return "<span class=\"username\"><a href=\"".route('messages.show',$row->id)."\">".$row->address."</a></span>";
                })
                ->editColumn('closed', function($row) {
                    return '<small>'.$row->closed.'</small>';
                })
                ->editColumn('plan', function($row) {
                    return '<small>'.$row->plan.'</small>';
                })
                ->rawColumns([
                    'action',
                    'fio',
                    'address',
                    'contract',
                    'photo',
                    'options',
                    'idNumber',
                    'contractStatus',
                    'photoStatus',
                    'closed',
                    'plan',
                ])
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
        return view('message-new',[
            'data' => $data,
            'message' => $messages->findOrFail($id),
            'replies' => Reply::query()->with('admin')->where('message_id',$id)->get()
        ]);
    }

    public function showPdf(Messages $messages,$id)
    {
        $message = $messages->findOrFail($id);
        $pdf = PDF::loadView('message-pdf', [
            'message' => $message,
            'replies' => Reply::query()->with('admin')->where('message_id',$id)->get()
        ]);
        return $pdf->download($message->fio.'.pdf');
    }
    public function exportPdf(Messages $messages)
    {
        $messages = $messages->where('status_id','=',6)->get();
        $zip = Zip::create(Carbon::now()->format('Y-m-d-H-i-s').'.zip');
        foreach ($messages as $message){
            $pdf = PDF::loadView('message-pdf', [
                'message' => $message,
                'replies' => Reply::query()->with('admin')->where('message_id',$message->id)->get()
            ]);
            $zip->addRaw($pdf->stream($message->fio.'.pdf'),$message->fio.'.pdf');
        }
        return $zip;
    }

    public function exportExcel(Messages $messages)
    {
        return Excel::download(new MessagesExport, 'report.xlsx');
    }

    public function importExcel(Request $request)
    {
        Excel::import(new MessagesImport,$request->file('file'));
        return redirect('/')->with('message_created', 'Импортировано');
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
        if((string)$request->status_id === "5" or (string)$request->status_id === "6" or  (string)$request->status_id === "7" ){
            if(!auth()->user()->hasRole(['admin','Super Admin'])){
                return redirect()->back()->with('message','Permission denied!');
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
