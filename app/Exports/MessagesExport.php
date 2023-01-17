<?php

namespace App\Exports;

use App\Models\Messages;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class MessagesExport implements FromCollection, WithCustomStartCell, WithMapping, ShouldAutoSize
{
    protected $date;
    protected $status_id;
    protected $responsible_id;

    public function __construct($date, $status_id, $responsible_id)
    {
        $this->date = $date;
        $this->status_id = $status_id;
        $this->responsible_id = $responsible_id;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $messages = Messages::query();
        if (isset($this->date)) {
            $date = explode(' ', $this->date);
            $messages = $messages->whereBetween('closed', [$date[0] . ' 00:00:00', $date[2] . ' 23:59:59']);;
        }
        if (isset($this->status_id)) {
            $messages = $messages->where('status_id', '=', $this->status_id);
        }
        if (isset($this->responsible_id)) {
            $messages = $messages->where('responsible_id', '=', $this->responsible_id);
        }
        return $messages->get();
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->fio,
            $row->address,
            $row->house,
            $row->uid,
        ];
    }
}
