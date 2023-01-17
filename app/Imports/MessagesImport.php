<?php

namespace App\Imports;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class MessagesImport implements ToModel, WithValidation
{
    /**
     * @param array $row
     *
     * @return Messages|Model|null
     */
    public function model(array $row): Messages|Model|null
    {
        dump($row);
        return new Messages([
            'fio' => $row[0],
            'address' => $row[1],
            'house' => $row[2],
            'type_id' => '1',
            'phone' => $row[3],
            'admin_id' => auth()->user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => 'required|string|min:10|max:255',
            '1' => 'required|min:3|max:255|string',
            '2' => 'required|string|min:1|max:20',
            '3' => 'required|string|min:6|max:20',
        ];
    }

    public function customValidationAttributes(): array
    {
        return [
            '0' => 'ФИО',
            '1' => 'Адрес',
            '2' => 'Дом\квартира',
            '3' => 'Телефон',
        ];
    }
}
