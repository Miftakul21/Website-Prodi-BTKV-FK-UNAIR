<div>
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold">
                        <span>Tugas Akhir Tesis</span>
                        <button class="btn btn-primary btn-sm ms-2" title="Add Data" wire:click="create">
                            <i class="bi bi-plus-square"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive-sm">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Page</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tugas_akhir as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->title}}</td>
                                        <td>{!!$data->content!!}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item" wire:click="edit('{{$data->id_tugas_akhir}}')">
                                                            <i class="bi bi-pencil text-warning"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" onclick="confirmDelete('{{$data->id_tugas_akhir}}')">
                                                            <i class="bi bi-trash text-danger"></i> Delete
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item">
                                                            <i class="bi bi-eye text-info"></i> Preview
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="4">Data Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form wire:submit.prevent="{{$id_pages ? 'update' : 'store'}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{$id_pages ? 'Edit Data' : 'Add Data'}}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <label class="fw-bold">Page</label>
                        <input type="text" class="form-control" placeholder="Tugas Akhir Tesis" disabled>
                        <input type="hidden" wire:model="title">
                        <div wire:ignore>
                            <label class="fw-bold mt-2">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" style="height: 500px;">{!! $content !!}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" wire:click="closeModal">
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

    @push('js')
    <!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            let editorInstance;

            Livewire.on('initEditor', () => {
                // kasih delay biar modal keburu render
                setTimeout(() => {
                    if (editorInstance) return;

                    const el = document.getElementById('deskripsi')
                    if (!el) {
                        console.warn('CKEditor target tidak ditemukan!');
                        return;
                    }

                    ClassicEditor.create(el, {
                        toolbar: [
                            'heading',
                            '|', 'bold', 'italic', 'underline', 'link',
                            '|', 'bulletedList', 'numberedList',
                            '|', 'blockQuote', 'insertTable',
                            '|', 'undo', 'redo'
                        ]
                    }).then(editor => {
                        editorInstance = editor;
                        // update Livewire tiap ada perubahan
                        editor.model.document.on('change:data', () => {
                            Livewire.dispatch('updateKonten', {
                                value: editor.getData()
                            });
                        });

                        // load data ke editor
                        Livewire.on('loadKonten', konten => {
                            editor.setData(konten || '');
                        })
                    }).catch(error => console.error('Something wrong! ' + error));
                }, 100);
            });

            // reset editor kalau modal ditutup
            Livewire.on('resetEditor', () => {
                if (editorInstance) {
                    editorInstance.destroy();
                    editorInstance = null;
                }
            });
        });
    </script>
    @endpush
</div>