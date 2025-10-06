<div>
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold">
                        <span>Data Pengajar</span>
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
                                        <th>Nama</th>
                                        <th>Image</th>
                                        <th>Jabatan Prodi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajars as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>
                                            @if($data->foto)
                                            <img src="{{asset('storage/'.$data->foto)}}" alt="foto" style="width: 50px; height: 50px;">
                                            @endif
                                        </td>
                                        <td>{{$data->posisi}}</td>
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
                                                        <button class="dropdown-item" wire:click="edit('{{$data->id_pengajar}}')">
                                                            <i class="bi bi-pencil text-warning"></i> Edit
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" wire:click="confirmDelete('{{$data->id_pengajar}}')">
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
                                        <td colspan="5" class="text-center">Data Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $pengajars->links() }}
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
                <form wire:submit.prevent="{{ $id_pengajar ? 'update' : 'store' }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id_pengajar ? 'Edit Data' : 'Add Data' }}</h4>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <label class="fw-bold">Name</label>
                        <input type="text" class="form-control" placeholder="Name" wire:model="name">
                        <label class="fw-bold mt-2">Jabatan Prodi</label>
                        <input type="text" class="form-control" placeholder="Jabatan Prodi" wire:model="posisi">
                        <label class="fw-bold mt-2">Pendidikan</label>
                        <textarea class="form-control" placeholder="Pendidikan" wire:model="pendidikan" style="height: 300px">{!!$pendidikan!!}</textarea>
                        <label class="fw-bold mt-2">Biografi</label>
                        <textarea class="form-control" placeholder="Biografi" wire:model="biografi" style="height: 300px">{!!$biografi!!}</textarea>
                        <label class="fw-bold mt-2">Pakar Penelitian</label>
                        <textarea class="form-control" placeholder="Pakar Penelitian" wire:model="pakar_penelitian" style="height: 300px">{!!$pakar_penelitian!!}</textarea>
                        <label class="fw-bold mt-2">Kepentingan Klinis</label>
                        <textarea class="form-control" placeholder="Kepentingan Klinis" wire:model="kepentingan_klinis" style="height: 300px">{!!$kepentingan_klinis!!}</textarea>
                        <!-- publikasi penelitian -->
                        <label class="fw-bold mt-2">Publikasi Penelitian</label>
                        @foreach($publikasi_penelitian as $index => $pub)
                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Judul Penelitan" wire:model.live="publikasi_penelitian.{{$index}}.judul">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Jurnal, Tahun" wire:model.live="publikasi_penelitian.{{$index}}.jurnal">
                            </div>
                            <div class="col-1">
                                @if(count($publikasi_penelitian) > 1)
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removePublikasi({{$index}})">X</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <!-- <textarea class="form-control" placeholder="Publikasi Penelitian" wire:model="publikasi_penelitian" style="height: 300px">{!!$kepentingan_klinis!!}</textarea> -->
                        <!-- prestasi dan penghargaan -->
                        <label class="fw-bold mt-2">Prestasi dan Penghargaan</label>
                        @foreach($prestasi_dan_penghargaan as $index => $pre)
                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Prestasi dan Penghargaan" wire:model.live="prestasi_dan_penghargaan.{{$index}}.prestasi">
                            </div>
                            <div class="col-1">
                                @if(count($prestasi_dan_penghargaan) > 1)
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removePrestasiDanPenghargaan({{$index}})">X</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <label class="fw-bold mt-2">Foto</label>
                        <input type="file" class="form-control" wire:model="foto">
                        <!-- indikator upload -->
                        <div wire:loading wire:target="foto" class="text-info">
                            Sedang upload foto...
                        </div>
                        <!-- preview file baru -->
                        @if ($foto)
                        <div class="mt-2">
                            <span class="text-success">File terpilih: {{ $foto->getClientOriginalName() }}</span>
                            <br>
                            <img src="{{ $foto->temporaryUrl() }}" class="img-foto mt-1" width="150">
                        </div>
                        @endif
                        <!-- pesan kalau edit tapi belum pilih gambar -->
                        @if($id_pengajar && $foto == null)
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
</div>