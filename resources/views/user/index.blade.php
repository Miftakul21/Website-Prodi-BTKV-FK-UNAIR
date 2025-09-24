@extends('layouts.layouts-admin')
@section('content')

@livewire('user-crud');

@push('js')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteUser', {
                    id: id
                })
            }
        })
    }

    document.addEventListener('livewire:init', () => {
        // delete success
        Livewire.on('userDeleted', () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            })
        });

        // store / update success
        Livewire.on('userSaved', (message) => {
            Swal.fire({
                title: 'Berhasil!',
                tixt: message,
                icon: 'success',
                position: 'center',
                timer: 2000,
                showConfirmButton: false,
            })
        })
    })
</script>
@endpush
@endsection