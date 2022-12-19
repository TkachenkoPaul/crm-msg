<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use DataTables;

class UserReportController extends Controller
{
    public function index(Request $request)
    {
            if ($request->has('date-range')) {
                $data['request-user-report'] =  route('user-report.list',['date-range'=> $request->input('date-range')]);
            } else {
                $data['request-user-report'] =  route('user-report.list');
            }
        return view('user-report',['users'=>User::withCount(['opened','closed','done','edit','plan','paid'])->get(),'data'=>$data ]);
    }

    public function datatables(Request $request)
    {
        if ($request->ajax()) {
             if ($request->has('date-range')){
                $date = explode(' ',$request->input('date-range'));
                $data['users'] = User::withCount([
                    'opened' => function (Builder $query) use ($date) {$query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
                    'closed' => function (Builder $query) use ($date) {$query->whereBetween('messages.closed',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
                    'done' => function (Builder $query) use ($date) {$query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
                    'edit' => function (Builder $query) use ($date) {$query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
                    'plan' => function (Builder $query) use ($date) {$query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
		    'paid'=> function (Builder $query) use ($date) {$query->whereBetween('messages.created_at',[$date[0].' 00:00:00',$date[2].' 23:59:59']);},
                ]);
            } else {
                $data['users'] = User::withCount(['opened','closed','done','edit','plan','paid']);
            }
            return DataTables::eloquent($data['users'])
                    ->addColumn('action', function($row){
                        return "<a href=\"".route('messages.show',$row->id)."\" class=\"btn btn-app\"><i class=\"fas fa-edit\"></i></a>";
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }
        return  null;
    }
}
