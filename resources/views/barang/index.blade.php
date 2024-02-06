

@extends('template/template')
@section('title','Data Barang TokoSamsul.id')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button 
                    class="btn btn-success btnTambahBarang"
                    data-bs-target='#modalForm'
                    data-bs-toggle='modal'
                    attr-href="{{route('barang.tambah')}}"><i class="bi bi-plus"></i> Tambah</button>
            </div>
            <div class="card-body">
                <table class="table DataTable table-hovered table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
            </div>
        </div>

        <!-- modal -->

        <div 
            class="modal fade"
            id="modalForm"
            data-bs-backdrop="static" 
            data-bs-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel" 
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btnSimpanBarang"><i class="bi bi-save"></i>Simpan</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>

    </div>
@endsection


@section('footer')
<script type="module">

    let table = $('.DataTable').DataTable({
        processcing:true,
        serverSide:true,
        ajax : "{!! route('barang.data') !!}",
        columns : [
            {
                name: 'kode_barang',
                data: 'kode_barang'
            },

            {
                name: 'nama_barang',
                data: 'nama_barang'
            },

            {
                name: 'stok',
                render: function(data,type,row){
                    return row.stok.jumlah_barang;
                }
            },

            {
                name: 'aksi',
                render: function(data,type,row){
                    return '<btn class="btn btn-primary"><i class="bi bi-pencil"></i>edit</btn> ' +
                            '<btn class="btn btn-danger"><i class="bi bi-trash"></i>Hapus</btn>';
                }
            }
        ]
    })


    $('.btnTambahBarang').on('click',function(a){
        a.preventDefault()
        const modalForm = document.getElementById('modalForm')
        modalForm.addEventListener('shown.bs.modal',function(event){
            event.preventDefault()
            event.stopImmediatePropagation()
            const link = event.relatedTarget.getAttribute('attr-href')
            const modalData = document.querySelector('#modal .modal-body')

            $('.modal-header .modal-title').html('Tambah Data Barang Baru')
            axios.get(link).then(response =>{
                $('.modal .modal-body').html(response.data)
            })



            /**
             * Contoh menggunakan ajax
             * 
             * $.ajax({
                url: link,
                method: 'GET',
                success: function(response){
                    $('#modal .modal-body').html(response.data)
                }
            })
             */

            
        })
    })
</script>

@endsection



