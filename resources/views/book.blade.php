@extends('adminlte::page')

@section('title', 'Home Page')

@section('content_header')
    <h1>Data Buku</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-default">
        <div class="card-header">{{ __('Pengelolaan Buku') }}</div>
        <div class="card-body">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal">
                <i class="fa fa-plus"></i>
                Tambah Data
            </button>
            <a href="{{ route('admin.print.books') }}" target="blank" class="btn btn-secondary">
                <i class="fa fa-print"></i>
                Cetak PDF
            </a>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('admin.book.export') }}" class="btn btn-info" target="_blank">Export</a>
                <a href="class=btn btn-warning">Import</a>
            </div>
            <hr>
            <table id="table-data" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>NO</th>
                        <th>JUDUL</th>
                        <th>PENULIS</th>
                        <th>TAHUN</th>
                        <th>PENERBIT</th>
                        <th>COVER</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($books as $book)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$book->judul}}</td>
                            <td>{{$book->penulis}}</td>
                            <td>{{$book->tahun}}</td>
                            <td>{{$book->penerbit}}</td>
                            <td>
                                @if($book->cover !== null)
                                    <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px"/>
                                @else
                                    [Gambar Tidak Tersedia]
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic Example">
                                <button type="button" id="btn-edit-buku" class="btn btn-success" data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">Edit</button>
                                {{-- id="btn-hapus-buku" data-toggle="modal" data-target="#hapusBukuModal" data-id="{{$book->id}}" --}}
                                {{-- onclick="deleteConfirmation('{{$book->id}}', '{{$book->judul}}')" --}}
                                <button type="button" class="btn btn-danger" onclick="deleteConfirmation('{{$book->id}}', '{{$book->judul}}' )">Hapus</button>
                                </div>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- @endsection --}}

<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.book.submit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" class="form-control" name="penulis" id="penulis" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="year" class="form-control" name="tahun" id="tahun" required>
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" class="form-control" name="penerbit" id="penerbit" required>
                    </div>
                    <div class="form-group">
                        <label for="cover">Cover</label>
                        <input type="file" class="form-control" name="cover" id="cover" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.book.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-judul">Judul Buku</label>
                                <input type="text" class="form-control" name="judul" id="edit-judul" required/>
                            </div>
                            <div class="form-group">
                                <label for="edit-penulis">Penulis</label>
                                <input type="text" class="form-control" name="penulis" id="edit-penulis" required/>
                            </div>
                            <div class="form-group">
                                <label for="edit-tahun">Tahun</label>
                                <input type="year" class="form-control" name="tahun" id="edit-tahun" required/>
                            </div>
                            <div class="form-group">
                                <label for="edit-penerbit">Penerbit</label>
                                <input type="text" class="form-control" name="penerbit" id="edit-penerbit" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="image-area"></div>
                                <label for="edit-cover">Cover</label>
                                <input type="file" class="form-control" name="cover" id="edit-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit-id"/>
                    <input type="hidden" name="old_cover" id="edit-old-cover"/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop 

@section('js')
    <script>
        $(function(){

            $(document).on('click', '#btn-edit-buku', function(){
                let id = $(this).data('id');

                $('#image-area').empty();
                
                $.ajax({
                    type: "get",
                    url: "{{url('/admin/ajaxadmin/dataBuku')}}/"+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);
                        
                        if(res.cover !== null){
                            $('#image-area').append(
                                "<img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'/>"
                            );
                        } else {
                            $('#image-area').append('[Gambar Tidak Tersedia]');
                        }
                    },
                });
            });
        });

        function deleteConfirmation(npm, judul){
            swal.fire({
                title: "Hapus?",
                type: 'warning',
                text: "Apakah Anda yakin akan menghapus data buku dengan judul" + judul+"?",
                showCancelButton: !0,
                confirmButtonText: "Ya, lakukan!",
                cancelButtonText: "Tidak, batalkan!",
                reverseButtons: !0
            }).then(function(e){
                if(e.value === true){
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "books/delete/" + npm,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results){
                            if(results.success === true){
                                swal.fire("Done!", results.message, "success");
                                
                                //refresh page after 2 seconds
                                setTimeout(function(){
                                    location.reload();
                                },1000);
                            }else{
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            })
        }
    </script>
@stop

{{-- @endsection --}}
