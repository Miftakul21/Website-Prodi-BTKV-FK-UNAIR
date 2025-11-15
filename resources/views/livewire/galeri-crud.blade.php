<div>
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold">
                        <span>Data Galeri</span>
                        <!-- nanti ya -->
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
                                        <th>Judul Galeri</th>
                                        <th>Image Utama</th>
                                        <th>Deskripsi</th>
                                        <th>Image Lainnya</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($galeris as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->judul_galeri}}</td>
                                        <td>
                                            @if($data->image_utama)
                                            <img src="{{asset('storage/'.$data->image_utama)}}" alt="image_utama" style="width: 60px">
                                            @endif
                                        </td>
                                        <td>
                                            {!! $data->deskripsi !!}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if($data->image_first || $data->image_second || $data->image_third || $data->image_fourth)
                                                <img src="{{asset('storage/'.$data->image_first)}}" alt="" style="width: 60px;">
                                                <img src="{{asset('storage/'.$data->image_second)}}" alt="" style="width: 60px;">
                                                <img src="{{asset('storage/'.$data->image_third)}}" alt="" style="width: 60px;">
                                                <img src="{{asset('storage/'.$data->image_fourth)}}" alt="" style="width: 60px;">
                                                @endif
                                            </div>
                                        </td>
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
                                                        <button class="dropdown-item" wire:click="edit('{{$data->id_galeri}}')">
                                                            <i class="bi bi-pencil text-warning"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" onclick="confirmDelete('{{$data->id_galeri}}')">
                                                            <i class="bi bi-trash text-danger"></i> Delete
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="/detail-galeri/{{$data->slug}}" class="dropdown-item">
                                                            <i class="bi bi-eye text-info"></i> Preview
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{$galeris->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rbga(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $id_galeri ? 'update' : 'store'}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id_galeri ? 'Edit Data' : 'Add Data' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <label class="fw-bold mt-2">Judul Galeri</label>
                        <input type="text" class="form-control" placeholder="Judul Galeri" wire:model="judul_galeri">

                        <div wire:ignore>
                            <label class="fw-bold mt-2">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" style="height: 500px;">{!! $deskripsi !!}</textarea>
                        </div>

                        <label class="fw-bold mt-2">Kategori</label>
                        <select class="form-select" wire:model="kategori">
                            <option selected>Pilih</option>
                            <option value="Penelitian">Penelitian</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Event">Event</option>
                        </select>

                        <label class="fw-bold mt-2">Thumbnail Galeri</label>
                        <input type="file" class="form-control" wire:model="image_utama">
                        <!-- indikator upload -->
                        <div wire:loading wire:target="image_utama" class="text-info">
                            Sedang upload thumbnail galeri
                        </div>
                        <!-- preview file baru -->
                        @if($image_utama)
                        <div class="mt-2">
                            <span class="text-success"> File terpilih: {{$image_utama->getClientOriginalName()}}</span>
                            <br>
                            <img src="{{$image_utama->temporaryUrl()}}" class="img-thumbnail mt-1" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_galeri && $image_utama == null)
                        <small class="text-muted d-block">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti thumbnail galeri
                        </small>
                        @endif

                        <label class="fw-bold mt-2">Image Galeri Lainnya 1</label>
                        <input type="file" class="form-control" wire:model="image_first">
                        <!-- indikator  -->
                        <div wire:loading wire:target="image_first" class="text-info">
                            Sedang upload image galeri lainnya 1
                        </div>
                        <!-- preview file baru -->
                        @if($image_first)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{$image_first->getClientOriginalName()}}</span>
                            <br>
                            <img src="{{$image_first->temporaryUrl()}}" class="img-thumbnail mt-2" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_galeri && $image_first == null)
                        <small class="text-muted d-block">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti image galeri lainnya 1
                        </small>
                        @endif

                        <label class="fw-bold mt-2">Image Galeri Lainnya 2</label>
                        <input type="file" class="form-control" wire:model="image_second">
                        <!-- indikator  -->
                        <div wire:loading wire:target="image_first" class="text-info">
                            Sedang upload image galeri lainnya 2
                        </div>
                        <!-- preview file baru -->
                        @if($image_second)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{$image_second->getClientOriginalName()}}</span>
                            <br>
                            <img src="{{$image_second->temporaryUrl()}}" class="img-thumbnail mt-2" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_galeri && $image_second == null)
                        <small class="text-muted d-block">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti image galeri lainnya 2
                        </small>
                        @endif

                        <label class="fw-bold mt-2">Image Galeri Lainnya 3</label>
                        <input type="file" class="form-control" wire:model="image_third">
                        <!-- indikator  -->
                        <div wire:loading wire:target="image_thrid" class="text-info">
                            Sedang upload image galeri lainnya 3
                        </div>
                        <!-- preview file baru -->
                        @if($image_third)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{$image_third->getClientOriginalName()}}</span>
                            <br>
                            <img src="{{$image_thrid->temporaryUrl()}}" class="img-thumbnail mt-2" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_galeri && $image_third == null)
                        <small class="text-muted d-block">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti image galeri lainnya 3
                        </small>
                        @endif

                        <label class="fw-bold mt-2">Image Galeri Lainnya 4</label>
                        <input type="file" class="form-control" wire:model="image_fourth">
                        <!-- indikator  -->
                        <div wire:loading wire:target="image_fourth" class="text-info">
                            Sedang upload image galeri lainnya 4
                        </div>
                        <!-- preview file baru -->
                        @if($image_fourth)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{$image_fourth->getClientOriginalName()}}</span>
                            <br>
                            <img src="{{$image_fourth->temporaryUrl()}}" class="img-thumbnail mt-2" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_galeri && $image_fourth == null)
                        <small class="text-muted">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti image galeri lainnya 4
                        </small>
                        @endif
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

                    const el = document.getElementById('deskripsi');
                    if (!el) {
                        console.warn("CKeditor target tidak ditemukan!");
                        return;
                    }

                    ClassicEditor.create(el, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'link',
                            '|', 'bulletedList', 'numberedList',
                            '|', 'blockQuote', 'insertTable',
                            '|', 'imageUpload',
                            '|', 'undo', 'redo'
                        ],
                    }).then(editor => {
                        editorInstance = editor;

                        // update livewire tiap ada perubahan
                        editor.model.document.on('change:data', () => {
                            Livewire.dispatch('updateDeskripsi', {
                                value: editor.getData()
                            });
                        });

                        // load data ke editor
                        Livewire.on('loadDeskripsi', deskripsi => {
                            editor.setData(deskripsi || '');
                        });
                    }).catch(error => console.error('Something wrong!'));
                }, 100);
            });

            Livewire.on('resetEditor', () => {
                if (editorInstance) {
                    editorInstance.destroy();
                    editorInstance = null;
                }
            })
        });
    </script>
    @endpush

</div>