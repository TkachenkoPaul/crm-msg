<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Jobs\PrepareReportJob;
use App\Models\Report;
use Carbon\Carbon;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('reports');
    }

    public function human_filesize($bytes, $dec = 2): string
    {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public function datatables(Request $request): ?JsonResponse
    {
        if ($request->ajax()) {
            $data = DB::table('reports as r')
                ->select(['r.*', 'a.id as aid', 'a.name as aname', 'q.job_id as jobid', 'q.progress as progress']);
            $data = $data->leftJoin('users as a', 'r.admin_id', '=', 'a.id')
                ->leftJoin('queue_monitor as q', 'r.job_id', '=', 'q.job_id');
            return DataTables::of($data)
                ->addColumn('download', function ($row) {

                    return "<a href=\"" . route('reports.download', $row->id) . "\" class=\"btn btn-sm bg-gradient-info \"><i class=\"fas fa-download\"></i></a>";
                })
                ->addColumn('delete', function ($row) {
                    return "<a href=\"" . route('reports.destroy', $row->id) . "\" class=\"btn btn-sm  bg-gradient-danger\"><i class=\"fas fa-trash-alt\"></i></a>";
                })
                ->addColumn('progress', function ($row) {
                    if ($row->progress === 100) {
                        return "<i class=\"fas fa-check\"></i>";
                    }
                    return "<div class=\"progress\">
                                <div class=\"progress-bar bg-primary progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"" . $row->progress . "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " . $row->progress . "%\">
                                    <span class=\"sr-only\">" . $row->progress . "% Complete (success)</span>
                                </div>
                            </div>";
                })
                ->editColumn('size', function ($row) {
                    if (Storage::exists($row->path)) {
                        return $this->human_filesize(Storage::size($row->path));
                    }
                    return null;
                })
                ->rawColumns([
                    'delete',
                    'download',
                    'size',
                    'progress'
                ])
                ->make(true);

        }
        return null;
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
     * @param StoreReportRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReportRequest $request)
    {
        \Log::alert($request);
        $archive_name = Carbon::now()->format('Y-m-d-H-i-s') . '.zip';
        $report = new Report();
        $report->name = $request->input('name');
        $report->desc = $request->input('desc');
        $report->admin_id = auth()->user()->id;
        $report->file = $archive_name;
        $report->path = 'public/reports/' . $archive_name;
        $report->status = 0;
        $report->save();
        PrepareReportJob::dispatch($request, $archive_name, $report->id);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Report $report
     * @param $id
     * @return StreamedResponse
     */
    public function download(Report $report, $id)
    {
        $report = $report->findOrFail($id);
        return Storage::download($report->path);
    }

    /**
     * Display the specified resource.
     *
     * @param Report $report
     * @return void
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Report $report
     * @return void
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReportRequest $request
     * @param Report $report
     * @return void
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Report $report
     * @param $id
     * @return RedirectResponse
     */
    public function destroy(Report $report, $id)
    {
        $report = $report->findOrFail($id);
        if (Storage::exists($report->path)) {
            Storage::delete($report->path);
        }
        $report->delete();
        return redirect()->back()->with('response', 'Отчет #' . $id . ' удалён!');
    }
}
