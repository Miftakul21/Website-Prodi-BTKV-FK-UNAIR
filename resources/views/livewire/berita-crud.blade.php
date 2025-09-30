<div>
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <h3>Berita</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold">
                        <span>Data Berita</span>
                        <!-- nanti ya -->
                        <button class="btn btn-primary btn-sm ms-2" title="Add Data" wire:click="create">
                            <i class="bi bi-plus-square"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table table-hover">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Image Thumbnail</th>
                                            <th>Tanggal</th>
                                            <th>Content</th>
                                            <th>Editor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($beritas as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->judul}}</td>
                                            <td>
                                                @if($data->thumbnail_image)
                                                <img src="{{asset('storage/'.$data->thumbnail_image)}}" alt="thubmnail_image" style="width: 50px; height: 50px;">
                                                @endif
                                            </td>
                                            <td>{{$data->tgl_berita}}</td>
                                            <td>{!!$data->konten_berita!!}</td>
                                            <td>{{$data->user?->name}}</td>
                                            <td>
                                                <button onclick="confirmDelete('{{$data->id_berita}}')" class=" btn btn-sm btn-danger" title="delete"><i class="bi bi-trash"></i></button>
                                                <button wire:click="edit('{{$data->id_berita}}')" class="btn btn-sm btn-warning text-white" title="edit"><i class="bi bi-pencil"></i></button>
                                                <!-- Nanti ya -->
                                                <a href="#" class="btn btn-sm btn-info" title="preview"><i class="bi bi-eye"></i>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Data Not Found</td>
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
    </div>
    <!-- Modal -->
    @if($isOpen)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form wire:submit.prevent="{{ $id_berita ? 'update' : 'store' }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id_berita ? 'Edit Data' : 'Add Data' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <label class="fw-bold">Judul Berita</label>
                        <input type="text" class="form-control" placeholder="Judul Berita" wire:model="judul">

                        <label class="fw-bold mt-2">Tanggal</label>
                        <input type="date" class="form-control" placeholder="Tanggal Berita" wire:model="tgl_berita">

                        <label class="fw-bold mt-2">Kategori</label>
                        <select class="form-select" wire:model="kategori">
                            <option value="Berita" selected>Berita</option>
                            <option value="Event">Event</option>
                        </select>

                        <div wire:ignore class="mt-2">
                            <label class="fw-bold mt-2">Konten Berita</label>
                            <textarea class="form-control" id="konten_berita" style="height: 500px;">{!! $konten_berita !!}</textarea>
                        </div>

                        <label class="fw-bold mt-2">Image Thumbnail</label>
                        <input type="file" class="form-control" wire:model="thumbnail_image">

                        <!-- indikator upload -->
                        <div wire:loading wire:target="thumbnail_image" class="text-info">
                            Sedang upload thumbnail...
                        </div>

                        <!-- preview file baru -->
                        @if ($thumbnail_image)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{ $thumbnail_image->getClientOriginalName() }}</span>
                            <br>
                            <img src="{{ $thumbnail_image->temporaryUrl() }}" class="img-thumbnail mt-1" width="150">
                        </div>
                        @endif

                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_berita && $thumbnail_image == null)
                        <small class="text-muted">
                            <span class="text-danger">*</span>Kosongkan jika tidak mengganti thumbnail image
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

                    const el = document.getElementById('konten_berita');
                    if (!el) {
                        console.warn("CKEditor target tidak ditemukan!");
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
                            ckfinder: {
                                uploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}"
                            }
                        })
                        .then(editor => {
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
                            });

                            // listen error upload
                            editor.plugins.get('FileRepository').on('uploadComplete', (evt, data) => {
                                if (data.error) {
                                    Swal.fire({
                                        title: 'Upload gagal',
                                        text: data.error,
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })
                                }
                            })
                        })
                        .catch(error => console.error(error));
                }, 100); // delay 100ms
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