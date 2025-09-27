<div>
    <div class="page-heading">
        <h3>Data Berita Terhapus</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>Data Berita</span>
                        <div>
                            <button class="btn btn-success btn-sm"
                                wire:click="restoreSelected"
                                wire:loading.attr="disabled"
                                :disabled="!@this.selectedBeritas.length">
                                Kembalikan
                            </button>

                            <button class="btn btn-danger btn-sm"
                                wire:click="deleteSelected"
                                wire:loading.attr="disabled"
                                :disabled="!@this.selectedBeritas.length">
                                Hapus
                            </button>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" wire:click="toggleSelectAll" @checked($selectAll)>
                                        </th>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Image Thumbnail</th>
                                        <th>Tanggal</th>
                                        <th>Content</th>
                                        <th>Editor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($beritas as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                                wire:model="selectedBeritas"
                                                value="{{ $data->id_berita }}">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->judul }}</td>
                                        <td>
                                            @if($data->thumbnail_image)
                                            <img src="{{ asset($data->thumbnail_image) }}"
                                                alt="thumbnail"
                                                style="width: 50px; height: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $data->tgl_berita }}</td>
                                        <td>{!! $data->konten_berita !!}</td>
                                        <td>{{ $data->user?->name }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $beritas->links() }}
                        </div>

                        {{-- Debug sementara --}}
                        {{-- <pre>{{ json_encode($selectedBeritas) }}</pre> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>