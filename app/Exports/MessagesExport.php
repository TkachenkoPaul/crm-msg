<?php

namespace App\Exports;

use App\Models\Messages;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MessagesExport implements FromCollection, WithCustomStartCell, WithMapping, ShouldAutoSize, WithHeadings
{
    protected $date;
    protected $status_id;
    protected $responsible_id;
    protected $updated_at;

    public function __construct($date, $status_id, $responsible_id, $updated_at)
    {
        $this->date = $date;
        $this->status_id = $status_id;
        $this->responsible_id = $responsible_id;
        $this->updated_at = $updated_at;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $messages = Messages::query()->with('type');
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
        if (isset($this->updated_at)) {
            $messages = $messages->whereBetween('updated_at', [$this->updated_at . ' 00:00:00', $this->updated_at . ' 23:59:59']);;
        }
        return $messages->get();
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            '№',
            'ФИО',
            'Контактный телефон',
            'Адрес',
            'Дом/квартира',
            'Установка/замена',
            'Льготная категория',
            'Дата обращения',
            'Статус подключения',
            'ID приемника',
        ];
    }

    public function map($row): array
    {
        return [
            $row->number,
            $row->fio,
            $row->phone,
            $row->address,
            $row->house,
            'Установка',
            $row->type->name,
            $row->created_at,
            'Выполнена',
            $row->uid,
        ];
    }

    public function prepareRows($rows)
    {
        $number = 1;
        foreach ($rows as $row) {
            $row->number = $number;
            $number++;
        }
        return $rows;
    }
}
