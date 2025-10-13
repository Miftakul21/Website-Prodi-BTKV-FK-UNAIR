<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UserCrud extends Component
{
    public $users;
    public $name, $email, $phone_number, $role, $password;
    public $id_user;
    public $isOpen = false;

    protected $listeners = ['deleteUser' => 'delete'];


    public function render()
    {
        $this->users = Cache::remember('users_all', 180, function () {
            return User::select(
                'id_user',
                'name',
                'email',
                'nomor_telepon',
                'role',
                'permission',
                'password'
            )->get();
        });
        return view('livewire.user-crud');
    }

    public function create()
    {
        $this->resetFields();
        $this->isOpen = true;
    }

    public function store()
    {
        try {
            $this->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $this->id_user . ',id_user',
                'role' => 'required|string',
                'password' => $this->id_user ? 'nullable|min:8' : 'required|min:8'
            ]);

            // Nanti Buat Hash untuk password agar tidak mudah di brute force
            User::updateOrCreate(['id_user' => $this->id_user], [
                'name' => $this->name,
                'email' => $this->email,
                'nomor_telepon' => $this->phone_number,
                'role' => $this->role,
                'password' => $this->password ?
                    Hash::make(env('SALT_PASSWORD') . $this->password  . env('SALT_PASSWORD')) :
                    User::find($this->id_user)->password
            ]);

            Cache::forget('users_all');
            $this->closeModal();
            $this->resetFields();

            $message = $this->id_user ? 'Berhasil diperbarui!' : 'Berhasil ditambahkan!';
            $this->dispatch('userSaved', $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstMessage = collect($e->errors())->flatten()->first();
            $this->dispatch('validationError', $firstMessage);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->id_user = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->nomor_telepon;
        $this->role = $user->role;
        $this->password = '';

        $this->isOpen = true;
    }

    public function delete($id)
    {
        User::find($id)->delete();
        Cache::forget('users_all');
        $this->dispatch('userDeleted');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->id_user = '';
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->role = 'Administrator';
        $this->password = '';
    }
}
