<?php

namespace App\Http\Controllers;

use App\Models\MessageType;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OperationController extends Controller
{
    public function index(Request $request)
    {
        $data['users'] = User::all();
        $data['status'] = StatusType::all();
        $paramArray = array();
        $data['request'] = route('operations.list', $paramArray);
        dump($request);
        return view('operations', compact('data'));
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('messages as m')
                ->select(['m.*', 'a.id as aid', 'a.name as aname', 'r.id as rid', 'r.name as rname', 's.type_id as sid', 's.name as sname', 't.id as tid', 't.name as tname']);
            if ($request->has('status_id')) {
                $data = $data->where('m.status_id', '=', $request->input('status_id'));
            }
            if ($request->has('date-range')) {
                $date = explode(' ', $request->input('date-range'));
                $data = $data->whereBetween('m.closed', [$date[0] . ' 00:00:00', $date[2] . ' 23:59:59']);
            }
            if ($request->has('amp;date-range')) {
                $date = explode(' ', $request->input('amp;date-range'));
                $data = $data->whereBetween('m.closed', [$date[0] . ' 00:00:00', $date[2] . ' 23:59:59']);
            }
            $data = $data->leftJoin('users as a', 'm.admin_id', '=', 'a.id')
                ->leftJoin('users as r', 'm.responsible_id', '=', 'r.id')
                ->leftJoin('status_types as s', 'm.status_id', '=', 's.type_id')
                ->leftJoin('message_types as t', 'm.type_id', '=', 't.id');
            return DataTables::of($data)
                ->addColumn('action', function ($row) {

                    return "<a href=\"" . route('messages.show', $row->id) . "\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                })
                ->addColumn('delete', function ($row) {
                    return "<a href=\"" . route('messages.destroy', $row->id) . "\" class=\"btn btn-sm bg-gradient-info\"><i class=\"fas fa-trash-alt\"></i></a>";
                })
                ->addColumn('idNumber', function ($row) {
                    if (isset($row->uid)) {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn  btn-sm bg-gradient-success\" ><i class=\"fas fa-satellite-dish\"></i></a>";
                    } else {
                        $uid = "<button data-toggle=\"tooltip\" title=\"ID оборудования\" class=\"btn  btn-sm bg-gradient-danger\"><i class=\"fas fa-satellite-dish\"></i></a>";
                    }
                    return $uid;
                })
                ->addColumn('contractStatus', function ($row) {
                    if ($row->contract == 1) {
                        return "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-file-contract\"></i></a>";
                    } else {
                        return "<button data-toggle='tooltip' title='Договор' class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-file-contract\"></i></a>";
                    }
                })
                ->addColumn('photoStatus', function ($row) {
                    if ($row->photo == 1) {
                        return "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-images\"></i></a>";
                    } else {
                        return "<button data-toggle='tooltip' title='Фотографии' class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-images\"></i></a>";
                    }
                })
                ->editColumn('id', function ($row) {
                    return "<span class=\"username\"><a href=\"" . route('messages.show', $row->id) . "\">" . $row->id . "</a></span>";
                })
                ->editColumn('fio', function ($row) {
                    return "<span class=\"username\"><a href=\"" . route('messages.show', $row->id) . "\">" . $row->fio . "</a></span>";
                })
                ->editColumn('contract', function ($row) {
                    if ($row->contract == 1) {
                        return "<a class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-times\"></i></a>";
                })
                ->editColumn('photo', function ($row) {
                    if ($row->photo == 1) {
                        return "<a class=\"btn btn-sm bg-gradient-success\"><i class=\"fas fa-check\"></i></a>";
                    }
                    return "<a class=\"btn btn-sm bg-gradient-danger\"><i class=\"fas fa-times\"></i></a>";
                })
                ->editColumn('address', function ($row) {
                    return "<span class=\"username\"><a href=\"" . route('messages.show', $row->id) . "\">" . $row->address . "</a></span>";
                })
                ->editColumn('closed', function ($row) {
                    return '<small>' . $row->closed . '</small>';
                })
                ->editColumn('plan', function ($row) {
                    return '<small>' . $row->plan . '</small>';
                })
                ->rawColumns([
                    'id',
                    'action',
                    'fio',
                    'address',
                    'contract',
                    'photo',
                    'delete',
                    'idNumber',
                    'contractStatus',
                    'photoStatus',
                    'closed',
                    'plan',
                ])
                ->make(true);

        }
    }
}
