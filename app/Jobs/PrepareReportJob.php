<?php

namespace App\Jobs;

use App\Models\Messages;
use App\Models\Reply;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Integer;
use Zip;
use PDF;
use romanzipp\QueueMonitor\Traits\IsMonitored;

class PrepareReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use IsMonitored;

    public int $timeout = 600;

    private mixed $status_id;
    private mixed $responsible_id;
    private mixed $updated_at;
    private array $date;
    private mixed $archive_name;
    protected $report_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $archive_name, $report_id)
    {
        $this->status_id = $request->input('status_id');
        $this->responsible_id = $request->input('responsible_id');
        $this->updated_at = $request->input('updated_at');
        $this->date = explode(' ', $request->input('date-range'));
        $this->archive_name = $archive_name;
        $this->report_id = $report_id;
    }

    /**
     * Execute the job.
     *
     * @param Messages $messages
     * @param Report $report
     * @return int
     */
    public function handle(Messages $messages, Report $report): int
    {
        $this->queueProgress(0);
        if (isset($this->date[0]) and isset($this->date[2])) {
            if ($this->date[0] !== null and $this->date[2] !== null) {
                $messages = $messages->whereBetween('closed', [$this->date[0] . ' 00:00:00', $this->date[2] . ' 23:59:59']);
            }
        }
        if (isset($this->updated_at)) {
            $messages = $messages->whereBetween('updated_at', [$this->updated_at . ' 00:00:00', $this->updated_at . ' 23:59:59']);
        }
        if (isset($this->status_id)) {
            if ($this->status_id !== 'all') {
                $messages = $messages->where('status_id', '=', $this->status_id);
            }

        }
        if (isset($this->responsible_id)) {
            if ($this->responsible_id !== 'all') {
                $messages->where('responsible_id', '=', $this->responsible_id);
            }
        }
        $report->findOrFail($this->report_id)->update(['count' => $messages->get()->count(), 'job_id' => $this->job->getJobId()]);
        $zip = Zip::create($this->archive_name);
        $messages = $messages->get();
        $messagesCount = $messages->count();
        $i = 0;
        foreach ($messages as $message) {
            $pdf = PDF::loadView('message-pdf', [
                'message' => $message,
                'replies' => Reply::query()->with('admin')->where('message_id', $message->id)->get()
            ]);
            $zip->addRaw($pdf->stream($message->fio . '.pdf'), $message->fio . '_' . $message->id . '.pdf');
            $i++;
            $this->queueProgress(($i / $messagesCount) * 100);
        }
        $zip->saveTo(public_path('storage/reports'));
        $this->queueProgress(100);
        return 0;
    }

    public function progressCooldown(): int
    {
        return 10; // Wait 10 seconds between each progress update
    }
}
