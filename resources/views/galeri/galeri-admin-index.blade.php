@extends('layouts.layouts-admin')
@section('content')
<header>
    <a href="#" class="butger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>
<div class="page-heading">
    <h3>Galeri</h3>
</div>
@livewire('galeri-crud')
@push('js')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data ini tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteGaleri', {
                    id: id
                })
            }
        })
    }

    document.addEventListener('livewire:init', () => {
        // delete success
        Livewire.on('galeriDeleted', () => {
            Swal.fire({
                title: 'Berahasil',
                text: 'Data berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
            })
        });

        // store / update success
        Livewire.on('galeriSaved', (message) => {
            Swal.fire({
                title: 'Berhasil',
                text: message,
                icon: 'success',
                position: 'center',
                timer: 2000,
                showConfirmButton: false
            })
        })

        Livewire.on('galeriError', (message) => {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            })
        });
    })
</script>
@endpush
@endsection