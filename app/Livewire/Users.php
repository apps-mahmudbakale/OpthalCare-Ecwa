<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Users extends Base
{
    public $sortBy = 'firstname';
    public function render()
    {

      if ($this->search) {
        $users = User::query()
          ->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'patient');
          })
          ->where(function ($query) {
            $query->where('firstname', 'like', '%' . $this->search . '%')
              ->orWhere('email', 'like', '%' . $this->search . '%');
          })
          ->paginate(10);

        return view(
          'livewire.users',
          ['users' => $users]
        );
      } else {
        $users = User::whereHas('roles', function ($query) {
          $query->where('name', '!=', 'patient');
        })->orderBy($this->sortBy, $this->sortDirection)
          ->paginate($this->perPage);

        return view(
          'livewire.users',
          ['users' => $users]
        );
      }
    }
}
