<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\withHealings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BooksExport implements FromArray, WithHealings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        return Book::getDataBooks();
    }

    public function headings(): array
    {
        return [
            'No'
            'Judul'
            'Penulis'
            'Tahun'
            'Penerbit'
        ];
    }
    public function collection()
    {
        return Book::all()
    }
}
