<?php

namespace App\Livewire;

use App\Models\Pengajar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Purifier;

class PengajarCrud extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $id_pengajar,
        $name,
        $posisi,
        $pendidikan               = [['pendidikan' => '']],
        $biografi,
        $pakar_penelitian,
        $kepentingan_klinis       = [['klinis'     => '']],
        $publikasi_penelitian     = [['judul'      => '', 'jurnal'    =>   '']],
        $prestasi_dan_penghargaan = [['prestasi'   => '']],
        $foto;

    public $isOpen = false;
    protected $listeners = ['deletePengajar' => 'delete'];

    // multiform automat
    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'publikasi_penelitian.')) {
            $index = explode('.', $propertyName)[1] ?? null;

            if ($index !== null && $index == count($this->publikasi_penelitian) - 1) {
                $last = $this->publikasi_penelitian[$index];

                if (!empty($last['judul']) || !empty($last['jurnal'])) {
                    $this->publikasi_penelitian[] = ['judul' => '', 'jurnal' => ''];
                }
            }
        } else if (str_starts_with($propertyName, 'prestasi_dan_penghargaan.')) {
            $index = explode('.', $propertyName)[1] ?? null;

            if ($index !== null && $index == count($this->prestasi_dan_penghargaan) - 1) {
                $last = $this->prestasi_dan_penghargaan[$index];

                if (!empty($last['prestasi'])) {
                    $this->prestasi_dan_penghargaan[] = ['prestasi' => ''];
                }
            }
        } else if (str_starts_with($propertyName, 'pendidikan.')) {
            $index = explode('.', $propertyName)[1] ?? null;

            if ($index !== null && $index == count($this->pendidikan) - 1) {
                $last = $this->pendidikan[$index];

                if (!empty($last['pendidikan'])) {
                    $this->pendidikan[] = ['pendidikan' => ''];
                }
            }
        } else if (str_starts_with($propertyName, 'kepentingan_klinis.')) {
            $index = explode('.', $propertyName)[1] ?? null;

            if ($index !== null && $index == count($this->kepentingan_klinis) - 1) {
                $last = $this->kepentingan_klinis[$index];

                if (!empty($last['klinis'])) {
                    $this->kepentingan_klinis[] = ['klinis' => ''];
                }
            }
        }
    }

    public function removePublikasi($index)
    {
        if (count($this->publikasi_penelitian) > 1) {
            unset($this->publikasi_penelitian[$index]);
            $this->publikasi_penelitian = array_values($this->publikasi_penelitian);
        }
    }

    public function removePrestasiDanPenghargaan($index)
    {
        if (count($this->prestasi_dan_penghargaan) > 1) {
            unset($this->prestasi_dan_penghargaan[$index]);
            $this->prestasi_dan_penghargaan = array_values($this->prestasi_dan_penghargaan);
        }
    }

    public function removePendidikan($index)
    {
        if (count($this->pendidikan) > 1) {
            unset($this->pendidikan[$index]);
            $this->pendidikan = array_values($this->pendidikan);
        }
    }

    public function removeKepentinganKlinis($index)
    {
        if (count($this->kepentingan_klinis) > 1) {
            unset($this->kepentingan_klinis[$index]);
            $this->kepentingan_klinis = array_values($this->kepentingan_klinis);
        }
    }

    public function render()
    {
        $page = $this->getPage();
        $pengajars = Cache::remember("pengajars_page_{$page}", 100, function () {
            return Pengajar::select(
                'id_pengajar',
                'name',
                'posisi',
                'pendidikan',
                'foto',
                'slug',
            )
                ->latest()
                ->paginate(10);
        });
        return view('livewire.pengajar-crud', [
            'pengajars' => $pengajars
        ]);
    }

    protected function clearPengajarCache()
    {
        $total = Pengajar::count();
        $lastPage = ceil($total / 3);
        foreach (range(1, $lastPage) as $i) {
            Cache::forget("pengajars_page_{$i}");
        }
    }

    public function create()
    {
        $this->resetFields();
        $this->foto = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pengajar                 = Pengajar::findOrFail($id);
        $this->id_pengajar        = $id;
        $this->name               = $pengajar->name;
        $this->posisi             = $pengajar->posisi;
        $this->biografi           = $pengajar->biografi;
        $this->pakar_penelitian   = $pengajar->pakar_penelitian;
        // $this->kepentingan_klinis = $pengajar->kepentingan_klinis;

        $this->pendidikan = collect($pengajar->pendidikan ?? [])
            ->map(fn($item)  => [
                'pendidikan' => $item['pendidikan'] ?? ''
            ])->toArray();

        // jika pendidikan kosong
        if (empty($this->pendidikan)) {
            $this->pendidikan = [
                ['pendidikan' => '']
            ];
        }

        $this->kepentingan_klinis = collect($pengajar->kepentingan_klinis ?? [])
            ->map(fn($item) => [
                'klinis' => $item['klinis'] ?? ''
            ])->toArray();

        // 
        if (empty($this->kepentingan_klinis)) {
            $this->kepentingan_klinis = [
                ['klinis' => '']
            ];
        }

        $this->publikasi_penelitian = collect($pengajar->publikasi_penelitian ?? [])
            ->map(fn($item) => [
                'judul'  => $item['judul'] ?? '',
                'jurnal' => $item['jurnal'] ?? ''
            ])->toArray();

        // jika publikasi penelitian kosong
        if (empty($this->publikasi_penelitian)) {
            $this->publikasi_penelitian = [[
                'judul' => '',
                'jurnal' => ''
            ]];
        }

        $this->prestasi_dan_penghargaan = collect($pengajar->prestasi_dan_penghargaan ?? [])
            ->map(fn($item) => [
                'prestasi' => $item['prestasi'] ?? '',
            ])->toArray();

        // jika prestasi dan penghargaan kosong
        if (empty($this->prestasi_dan_penghargaan)) {
            $this->prestasi_dan_penghargaan = [[
                'prestasi' => ''
            ]];
        }

        // reset file input setiap kali modal dibuka
        $this->foto = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'name'                                => 'required|string',
                'posisi'                              => 'required|string',
                'pendidikan.*.pendidikan'             => 'nullable|string',
                'biografi'                            => 'nullable|string',
                'pakar_penelitian'                    => 'nullable|string',
                'kepentingan_klinis.*.klinis'         => 'nullable|string',
                'publikasi_penelitian.*.judul'        => 'nullable|string',
                'publikasi_penelitian.*.jurnal'       => 'nullable|string',
                'prestasi_dan_penghargaan.*.prestasi' => 'nullable|string',
                'foto'                                => 'nullable|image|max:5120'
            ]);

            $pendidikan = collect($this->pendidikan)
                ->filter(fn($item) => !empty($item['pendidikan']))
                ->values()
                ->toArray();

            $kepentingan_klinis = collect($this->kepentingan_klinis)
                ->filter(fn($item) => !empty($item['klinis']))
                ->values()
                ->toArray();

            $publikasi = collect($this->publikasi_penelitian)
                ->filter(fn($item) => !empty($item['judul']) || !empty($item['jurnal']))
                ->values()
                ->toArray();

            $prestasi = collect($this->prestasi_dan_penghargaan)
                ->filter(fn($item) => !empty($item['prestasi']))
                ->values()
                ->toArray();

            $pengajar = Pengajar::create([
                'name'                     => Purifier::clean($this->name, 'custom'),
                'posisi'                   => Purifier::clean($this->posisi, 'custom'),
                'pendidikan'               => $pendidikan,
                'biografi'                 => Purifier::clean($this->biografi, 'custom'),
                'pakar_penelitian'         => Purifier::clean($this->pakar_penelitian, 'custom'),
                'kepentingan_klinis'       => $kepentingan_klinis,
                'publikasi_penelitian'     => $publikasi,
                'prestasi_dan_penghargaan' => $prestasi,
                'foto'                     => null,
            ]);

            if ($this->foto) {
                DB::afterCommit(function () use ($pengajar) {
                    $filename = Str::random(20) . '.' . $this->foto->getClientOriginalExtension();
                    $path     = $this->foto->storeAs('pengajar', $filename, 'public');
                    // update foto setelah file tersimpan ke database
                    $pengajar->update(['foto' => $path]);
                });
            }

            DB::commit();
            $this->clearPengajarCache();
            $this->closeModal();
            $this->dispatch('pengajarSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Pengajar store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('pengajarError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        DB::beginTransaction();

        try {
            $this->validate([
                'name'                                => 'required|string',
                'posisi'                              => 'required|string',
                'pendidikan.*.pendidikan'             => 'nullable|string',
                'biografi'                            => 'nullable|string',
                'pakar_penelitian'                    => 'nullable|string',
                'kepentingan_klinis.*.klinis'         => 'nullable|string',
                'publikasi_penelitian.*.judul'        => 'nullable|string',
                'publikasi_penelitian.*.jurnal'       => 'nullable|string',
                'prestasi_dan_penghargaan.*.prestasi' => 'nullable|string',
                'foto'                                => 'nullable|image|max:5120'
            ]);

            $pengajar = Pengajar::findOrFail($this->id_pengajar);

            $pendidikan = collect($this->pendidikan)
                ->filter(fn($item) => !empty($item['pendidikan']))
                ->values()
                ->toArray();

            $kepentingan_klinis = collect($this->kepentingan_klinis)
                ->filter(fn($item) => !empty($item['klinis']))
                ->values()
                ->toArray();

            $publikasi = collect($this->publikasi_penelitian)
                ->filter(fn($item) => !empty($item['judul']) || !empty($item['jurnal']))
                ->values()
                ->toArray();

            $prestasi = collect($this->prestasi_dan_penghargaan)
                ->filter(fn($item) => !empty($item['prestasi']))
                ->values()
                ->toArray();


            $pengajar->update([
                'name'                     => Purifier::clean($this->name, 'custom'),
                'posisi'                   => Purifier::clean($this->posisi, 'custom'),
                'pendidikan'               => $pendidikan,
                'biografi'                 => Purifier::clean($this->biografi, 'custom'),
                'pakar_penelitian'         => Purifier::clean($this->pakar_penelitian, 'custom'),
                'kepentingan_klinis'       => $kepentingan_klinis,
                'publikasi_penelitian'     => $publikasi,
                'prestasi_dan_penghargaan' => $prestasi,
            ]);

            if ($this->foto) {
                $oldPath = $pengajar->foto;
                DB::afterCommit(function () use ($pengajar, $oldPath) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $this->foto->getClientOriginalExtension();
                    $path    = $this->foto->storeAs('pengajar', $filename, 'public');
                    $pengajar->update(['foto' => $path]);
                });
            }

            DB::commit();
            $this->clearPengajarCache();
            $this->closeModal();
            $this->dispatch('pengajarSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Pengajar update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('pengajarError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $pengajar = Pengajar::findOrFail($id);
            $pengajar->delete();
            $this->clearPengajarCache();
            $this->dispatch('pengajarDeleted');
        } catch (\Throwable $e) {
            Log::error('Pengajar delete error: ' . $e->getMessage());
            $this->dispatch('pengajarError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
        $this->dispatch('resetEditor');
    }

    public function resetFields()
    {
        $this->id_pengajar              = '';
        $this->name                     = '';
        $this->posisi                   = '';
        $this->pendidikan               = [['pendidikan' => '']];
        $this->biografi                 = '';
        $this->pakar_penelitian         = '';
        $this->kepentingan_klinis       = [['klinis'     => '']];
        $this->publikasi_penelitian     = [['judul'      => '', 'jurnal' => '']];
        $this->prestasi_dan_penghargaan = [['prestasi'   => '']];
        $this->foto                     = null;
    }
}
