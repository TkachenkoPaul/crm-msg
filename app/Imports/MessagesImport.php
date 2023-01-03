<?php

namespace App\Imports;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class MessagesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Messages|Model|null
     */
    public function model(array $row): Messages|Model|null
    {
        return new Messages([
            'fio' => $row[0],
            'address' => $row[1],
            'house' => $row[2],
            'type_id' => '1',
            'phone' => $row[3],
            'admin_id' => auth()->user()->id,
        ]);
    }
}
