<?php

namespace App\Imports;

use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportWord implements ToModel
{
    /**
     * @param array $row
     *
     * @return Model|Word|null
     */
    public function model(array $row): Model|Word|null
    {
        return new Word([
            'word'       => $row[0],
            'created_at' => now()
        ]);
    }
}
