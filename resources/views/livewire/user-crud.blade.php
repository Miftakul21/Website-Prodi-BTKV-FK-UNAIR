<div>
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Anggota</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold">
                        <span class="text-primary">Data Anggota</span>
                        <button class="btn btn-primary btn-sm ms-2" title="Add Data" wire:click="create">
                            <i class="bi bi-plus-square"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th>Last Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->nomor_telepon}}</td>
                                        <td>{{$data->role}}</td>
                                        <td></td>
                                        <td>
                                            <button onclick="confirmDelete('{{ $data->id_user }}')" class="btn btn-sm btn-danger" title="delete"><i class="bi bi-trash"></i></button>
                                            <button wire:click="edit('{{$data->id_user}}')" class="btn btn-sm btn-warning text-white" title="edit"><i class="bi bi-pencil"></i></button>
                                            <!-- Nanti ya ditambahkan hak permission -->
                                            <button class="btn btn-sm btn-info"><i class="bi bi-shield-plus text-white fw-bold" title="add permission"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Data Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- add form modal -->
    @if($isOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id_user ? 'Edit Anggota' : 'Add Anggota' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="fw-bold">Name</label>
                        <input type="text" class="form-control" wire:model="name">

                        <label class="fw-bold mt-2">Email</label>
                        <input type="email" class="form-control" wire:model="email">

                        <label class="fw-bold mt-2">Phone Number</label>
                        <input type="text" class="form-control" wire:model="phone_number">

                        <label class="fw-bold mt-2">Role</label>
                        <select class="form-select" wire:model="role">
                            <option value="Administrator">Administrator</option>
                            <option value="Editor">Editor</option>
                        </select>

                        <label class="fw-bold mt-2">Password</label>
                        <input type="password" class="form-control" wire:model="password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-light-secondary">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>