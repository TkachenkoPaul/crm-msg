<?php

namespace App\Exports;

use App\Models\Messages;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class MessagesExport implements FromCollection, WithCustomStartCell, WithMapping,ShouldAutoSize
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Messages::where('status_id','=',6)->get();
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
