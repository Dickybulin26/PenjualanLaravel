

@extends('template/template')
@section('title','Riwayat Pembelian Barang TokoSamsul.id')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button
                    class="btn btn-success btnBeliBarang"
                    data-bs-title='Tambah Stok Barang'
                    data-bs-target='#modalForm'
                    data-bs-toggle='modal'
                    attr-href="{{route('beli.tambah')}}"><i class="bi bi-plus"></i> Tambah Stok Barang</button>
            </div>
            <div class="card-body">
                <table class="table DataTable table-hovered table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
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
                        <button class="btn btn-success btnSimpanBarang"><i class="bi bi-save"></i> Simpan</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>

    </div>
@endsection


@section('footer')
<script type="module">

    const modalInstance = document.querySelector('#modalForm')
    const modal = bootstrap.Modal.getOrCreateInstance(modalInstance)

    let table = $('.DataTable').DataTable({
        processcing:true,
        serverSide:true,
        ajax : "{!! route('beli.data') !!}",
        columns : [
            {
                render : function(data,type,row){
                    return row.barang.kode_barang
                }
            },

            {
                render : function(data,type,row){
                    return row.barang.nama_barang
                }
            },

            {
                data: 'tanggal',
                name: 'tanggal',
            },
            
            {
                data: 'jumlah_beli',
                name: 'jumlah_beli',
            },
            
            {
                data: 'harga',
                name: 'harga',
            },

            {
                data: 'total',
                name: 'total',
            },

            {
                name: 'aksi',
                render: function(data,type,row){
                    return "<btn class='btn btn-primary btnEdit' data-bs-toggle='modal' data-bs-target='#modalForm' attr-href='{!!url('/barang/edit/"+row.id_barang+"')!!}'><i class='bi bi-pencil'></i> Edit </btn> <btn class='btn btn-danger btnHapusBarang' attr-id='"+row.id_barang+"'><i class='bi bi-trash'></i> Hapus </btn>";
                }
            }
        ]
    })


    //* Hapus callback
    $('.DataTable tbody').on('click','.btnHapusBarang',function(hapusEvent){
        let idBarang = $(this).closest('.btnHapusBarang').attr('attr-id')
        // alert(idBarang)
        Swal.fire({
            title: 'You want to delete this data,Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let hapusData = {
                    'id_barang' : idBarang,
                    'token' : '{{csrf_token()}}'
                }

                axios.post('{{url("barang/hapus")}}', hapusData).then(response =>{
                    if(response.data.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: response.data.pesan,
                            text: 'Data Anda Berhasil di Hapus'
                        }).then(()=>{
                            table.ajax.reload()
                        })
                    }else{

                    }
                })
            }
        })
    })

    //* Edit callback
    $('.DataTable tbody').on('click','.btnEdit',function(event){
        
        let modalForm = document.getElementById('modalForm')
        modalForm.addEventListener('shown.bs.modal',function(event){
            event.preventDefault()
            event.stopImmediatePropagation()
            let link = event.relatedTarget.getAttribute('attr-href')
            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data)
                $('.modal-title').html('EDIT DATA BARANG')
            })

            //* event simpan saat tombol simpan di klik
            $('.btnSimpanBarang').on('click',function(editSimpanEvent){
                editSimpanEvent.stopImmediatePropagation()
                // alert("Simpan");
                let dataEdit = {
                    'id_barang': $('#idBarang').val(),
                    'nama_barang' : $('#namaBarang').val(),
                    'kode_barang' : $('#kodeBarang').val(),
                    'harga_barang' : $('#hargaBarang').val(),
                    'token' : '{{csrf_token()}}'
                }

                axios.post('{{url("barang/simpan")}}',dataEdit).then(response =>{
                    if(response.data.status == 'success'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.data.pesan
                        }).then(() => {
                            table.ajax.reload()
                            modal.hide()
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.pesan
                        })
                    }
                })
            })
        })
    })


    //* Modal popup beli barang
    $('.btnBeliBarang').on('click',function(a){
        a.preventDefault()
        const modalForm = document.getElementById('modalForm')
        modalForm.addEventListener('shown.bs.modal',function(event){
            event.preventDefault()
            event.stopImmediatePropagation()
            const link = event.relatedTarget.getAttribute('attr-href')
            const modalData = document.querySelector('#modal .modal-body')
            // alert(link)
            $('.modal-header .modal-title').html('Beli Barang')
            axios.get(link).then(response =>{
                $('#modalForm .modal-body').html(response.data)
                $('.autoDropDownBarang').select2({
                    placeholder     : 'Pilih barang yang ingin dibeli',
                    theme           : 'bootstrap-5',
                    cache           : true,
                    dropdownParent  : $('.modal .modal-body'),
                    ajax            : {
                        url : "{!! route('barang.list') !!}",
                        dataType : 'json',
                        processResults : function(data){
                            $.each(data,function(i,d){
                                // i = iterasi ke n
                                // d = data dari iterasi i
                                data[i]['text'] = d.nama_barang
                                data[i]['id'] = d.id_barang
                            })
                            return {
                                results : data
                            }
                        }
                    }
                })
            })

            //* event simpan saat tombol simpan di klik
            $('.btnSimpanBarang').on('click',function(simpanEvent){
                // modal.hide()
                simpanEvent.preventDefault()
                simpanEvent.stopImmediatePropagation()
                let data = {
                    'id_barang' : $('#idBarang').val(),
                    'tanggal_beli' : $('#tanggalBeli').val(),
                    'jumlah_beli' : $('#jumlahBeli').val(),
                    'harga' : $('#hargaBeliSatuan').val(),
                    '_token' : '{{csrf_token()}}'
                }
                if(
                    data.id_barang !== '' &&
                    data.tanggal_beli  !== '' &&
                    data.jumlah_beli !== '' && 
                    data.harga !== '')
                    {
                    //* input data

                    axios.post('{{url("beli/simpan")}}',data).then(response =>{
                        if(response.data.status == 'success'){
                            Swal.fire({
                                'title' : 'Berhasil!',
                                'text' : response.data.pesan,
                                'icon' : 'success'
                            }).then(() => {
                                modal.hide()
                                table.ajax.reload()
                            })
                        } else {
                            Swal.fire({
                                'title' : 'Data gagal ditambahkan!',
                                'text' : response.data.pesan,
                                'icon' : 'error'
                            })
                        }
                    })
                } else {
                    alert('data tidak boleh kosong');
                }
            })
        })
    })
</script>

@endsection



