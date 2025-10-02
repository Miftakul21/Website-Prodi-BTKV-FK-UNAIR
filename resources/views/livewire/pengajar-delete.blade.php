<div>
    <div class="page-heading">
        <h3>Data Pengajar Terhapus</h3>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card border-top border-primary border-2">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>Data Pengajar</span>
                        <div>
                            <button class="btn btn-success btn-sm"
                                wire:click="restoreSelected"
                                wire:loading.attr="disabled"
                                :disabled="!@this.selectedPengajars.length">
                                Kembalikan
                            </button>
                            <button class="btn btn-danger btn-sm"
                                wire:click="deleteSelected"
                                wire:loading.attr="disabled"
                                :disabled="!@this.selectedPengajars.length">
                                Hapus
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" wire:click="toggleSelectAll" @checked($selectAll)></th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Image</th>
                                        <th>Jabatan Prodi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajars as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                                wire:model="selectedPengajars"
                                                value="{{$data->id_pengajar}}">
                                        </td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>
                                            @if($data->foto)
                                            <img src="{{asset('storage/'.$data->foto)}}"
                                                alt="foto"
                                                style="width: 50px; height: 50px;">
                                            @endif
                                        </td>
                                        <td>{{$data->posisi}}</td>
                                        <td></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data Not Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2">
                            {{$pengajars->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>