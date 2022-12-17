<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
public static function getDataBooks()
{
    use Illuminateuse\DatabaseExcel\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Elaquent\Model;

    class Book extends Model
    {
        use HasFactory;

        protected $fillable = [
            'judul',
            'penulis',
            'tahun',
            'penerbit'
        ];
    }
    
    $books = Book::all();

    $books_filter = [];

    $no = 1;
    for ($i=0; $i < $books->count(); $i++) {
        $books_filter[$i]['no'] = $no++;
        $books_filter[$i]['judul'] = $books[$i]->judul;
        $books_filter[$i]['penulis'] = $books[$i]->penulis;
        $books_filter[$i]['tahun'] = $books[$i]->tahun;
        $books_filter[$i]['penerbit'] = $books[$i]->penerbit;

    }

    return $books_filter;
}
