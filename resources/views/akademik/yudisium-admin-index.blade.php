@extends('layouts.layouts-admin')
@section('content')
<header class="mb-3">
    <a href="#" class="butger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>
<div class="page-heading">
    <h3>Yudisium</h3>
</div>
@livewire('yudisium-crud')
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
                Livewire.dispatch('deleteYudisiumAkhir', {
                    id: id
                });
            }
        })
    }

    document.addEventListener('livewire:init', () => {
        // delete success
        Livewire.on('yudisiumDeleted', () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            })
        })

        // store / update success
        Livewire.on('yudisiumSaved', (message) => {
            Swal.fire({
                title: 'Berhasil',
                text: message,
                icon: 'success',
                position: 'center',
                timer: 2000,
                showConfirmButton: false
            });
        })

        Livewire.on('yudisiumError', (message) => {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error'
            })
        })
    });
</script>
@endpush
@endsection