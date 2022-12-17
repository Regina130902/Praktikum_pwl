<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\withHealingRow;

class BooksImport implements withHeadingRow, ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Book([
            'judul' => $row['judul'],
            'penulis' => $row['penulis'],
            'tahun' => $row['tahun'],
            'penerbit' => $row['penerbit'],
            //
        ]);
    }
}
