<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;

use App\Models\Book;
use PDF;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function books(){
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }

    public function submit_book(Request $req){

        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' =>'required',
            'tahun' =>'required',
            'penerbit' => 'required',
        ]);

        $book = new Book;
        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');
        if($req->hasFile('cover')){
            $extension = $req->file('cover')->extension();
            $filename = 'cover_buku_'.time().'.'.$extension;
            $req->file('cover')->storeAs('public/cover_buku', $filename);
            $book->cover = $filename;
        }

        $book->save();

        $notification = array(
            'message' => 'Data Buku Berhasil Ditambahkan',
            'alert-type' => 'success'
        );
    
        return redirect()->route('admin.books')->with($notification);
    }    

    //AJAX PROCESS
    public function getDataBuku($id){
        $buku = Book::find($id);
        return response()->json($buku);
    }

    public function update_book(Request $req){
        $book = Book::find($req->get('id'));

        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if($req->hasFile('cover')){
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku_'.time().'.'.$extension;

            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );

            Storage::delete('public/cover_buku/'.$req->get('old_cover'));

            $book->cover = $filename;
        }

        $book->save();

        $notification = array(
            'message' => 'Data buku berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

    public function delete_book($id){
        
        $book = Book::find($id);

        Storage::delete('public/cover_buku/'.$book->cover);

        $book->delete();

        $success = true;
        $message = "Data buku berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function print_books(){
        $books = Book::all();

        $pdf = PDF::loadview('print_books',['books'=>$books]);
        return $pdf->download('data_buku.pdf');
    }
    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }
    public function import(Request $req)
    {
        Excel::import(new BooksImport, $req->file('file'));

        $notification = array(
            'message' => 'Impport data berhasil dilakukan',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.books')->with($notification);
    }
    
}
