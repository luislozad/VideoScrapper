<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ProfileControl extends Component
{
    #[Validate('required|string')]
    public $username;
    #[Validate('string')]
    public $oldPassword;
    #[Validate('string')]
    public $newPassword;
    #[Validate('required|email')]
    public $email;

    public function render()
    {
        return view('livewire.admin.profile-control')->layout('layouts.admin');
    }

    public function save()
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        if (!empty($this->oldPassword) && $passwordMatch = Hash::check($this->oldPassword, $user->password)) {
            $user->fill([
                'name' => $this->username,
                'password' => Hash::make($this->newPassword),
                'email' => $this->email
            ]);

            if ($user->isDirty()) {
                $user->update($user->getDirty());
                Auth::login($user);
            }
        } else if (!empty($this->oldPassword) && $passwordMatch === false) {
            $this->addError('password', 'The password does not match the previous password.');
        } else {
            $user->fill([
                'name' => $this->username,
                'email' => $this->email
            ]);

            if ($user->isDirty()) {
                $user->update($user->getDirty());
                Auth::login($user);
            }
        }
    }

    public function mount()
    {
        $user = User::first();

        if ($user) {
            $this->username = $user->name;
            $this->email = $user->email;
        }
    }
}
