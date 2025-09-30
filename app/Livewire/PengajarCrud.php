<?php

namespace App\Livewire;

use App\Models\Pengajar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Purifier;

class PengajarCrud extends Component
{
    use WithFileUploads;

    public $pengajars;
    public $id_pengajar,
        $name,
        $posisi,
        $pendidikan,
        $biografi,
        $pakar_penelitian,
        $kepentingan_klinis,
        $publikasi_penelitian,
        $prestasi_dan_penghargaan,
        $foto;

    public $isOpen = false;
    protected $listeners = [
        'deletePengajar' => 'delete',
    ];

    public function render()
    {
        $this->pengajars = Cache::remember('pengajars_all', 100, function () {
            return Pengajar::select('id_pengajar', 'name', 'posisi', 'pendidikan', 'foto')
                ->latest()
                ->get();
        });
        return view('livewire.pengajar-crud');
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
        $pengajar = Pengajar::findOrFail($id);
        $this->id_pengajar = $id;
        $this->name = $pengajar->name;
        $this->posisi = $pengajar->posisi;
        $this->pendidikan = $pengajar->pendidikan;
        $this->biografi = $pengajar->biografi;
        $this->pakar_penelitian = $pengajar->pakar_penelitian;
        $this->kepentingan_klinis = $pengajar->kepentingan_klinis;
        $this->publikasi_penelitian = $pengajar->publikasi_penelitian;
        $this->prestasi_dan_penghargaan = $pengajar->prestasi_dan_penghargaan;

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
                'name' => 'required|string',
                'posisi' => 'required|string',
                'pendidikan' => 'nullable|string',
                'biografi' => 'nullable|string',
                'pakar_penelitian' => 'nullable|string',
                'kepentingan_klinis' => 'nullable|string',
                'publikasi_penelitian' => 'nullable|string',
                'prestasi_dan_penghargaan' => 'nullable|string',
                'foto' => 'nullable|image|max:5120'
            ]);

            $pengajar = Pengajar::create([
                'name' => Purifier::clean($this->name, 'custom'),
                'posisi' => Purifier::clean($this->posisi, 'custom'),
                'pendidikan' => Purifier::clean($this->pendidikan, 'custom'),
                'biografi' => Purifier::clean($this->biografi, 'custom'),
                'pakar_penelitian' => Purifier::clean($this->pakar_penelitian, 'custom'),
                'kepentingan_klinis' => Purifier::clean($this->kepentingan_klinis, 'custom'),
                'publikasi_penelitian' => Purifier::clean($this->publikasi_penelitian, 'custom'),
                'prestasi_dan_penghargaan' => Purifier::clean($this->prestasi_dan_penghargaan, 'custom'),
                'foto' => null,
            ]);

            if ($this->foto) {
                DB::afterCommit(function () use ($pengajar) {
                    $filename = Str::random(20) . '.' . $this->foto->getClientOriginalExtension();
                    $path = $this->foto->storeAs('pengajar', $filename, 'public');

                    // update foto setelah file tersimpan ke database
                    $pengajar->update(['foto' => $path]);
                });
            }

            DB::commit();

            Cache::forget('pengajars_all');
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
                'name' => 'required|string',
                'posisi' => 'required|string',
                'pendidikan' => 'nullable|string',
                'biografi' => 'nullable|string',
                'pakar_penelitian' => 'nullable|string',
                'kepentingan_klinis' => 'nullable|string',
                'publikasi_penelitian' => 'nullable|string',
                'prestasi_dan_penghargaan' => 'nullable|string',
                'foto' => 'nullable|image|max:5120'
            ]);

            $pengajar = Pengajar::findOrFail($this->id_pengajar);
            $pengajar->update([
                'name' => Purifier::clean($this->name, 'custom'),
                'posisi' => Purifier::clean($this->posisi, 'custom'),
                'pendidikan' => Purifier::clean($this->pendidikan, 'custom'),
                'biografi' => Purifier::clean($this->biografi, 'custom'),
                'pakar_penelitian' => Purifier::clean($this->pakar_penelitian, 'custom'),
                'kepentingan_klinis' => Purifier::clean($this->kepentingan_klinis, 'custom'),
                'publikasi_penelitian' => Purifier::clean($this->publikasi_penelitian, 'custom'),
                'prestasi_dan_penghargaan' => Purifier::clean($this->prestasi_dan_penghargaan, 'custom'),
            ]);

            if ($this->foto) {
                $oldPath = $pengajar->foto;

                DB::afterCommit(function () use ($pengajar, $oldPath) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }

                    $filename = Str::random(20) . '.' . $this->foto->getClientOriginalExtension();
                    $path = $this->foto->storeAs('pengajar', $filename, 'public');
                    $pengajar->update(['foto' => $path]);
                });
            }

            DB::commit();

            Cache::forget('pengajars_all');
            $this->closeModal();
            $this->dispatch('pengajarSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
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

            if ($pengajar->foto && file_exists(public_path($pengajar->foto))) {
                @unlink(public_path($pengajar->foto));
            }

            $pengajar->delete();
            Cache::forget('pengajars_all');
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
        $this->id_pengajar = '';
        $this->name = '';
        $this->posisi = '';
        $this->pendidikan = '';
        $this->biografi = '';
        $this->pakar_penelitian = '';
        $this->kepentingan_klinis = '';
        $this->publikasi_penelitian = '';
        $this->prestasi_dan_penghargaan = '';
        $this->foto = null;
    }
}
