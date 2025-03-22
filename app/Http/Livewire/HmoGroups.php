<?php

namespace App\Http\Livewire;

use App\Models\HmoGroup;
use Livewire\Component;

class HmoGroups extends Base
{
    public $sortBy = 'name';
    public $HmoId;
    public $HmoName;
    public $HmoPhone;
    public $HmoEmail;
    public $HmoAddress;

    public function selectHmo($id)
    {
        $hmo = HmoGroup::find($id);
        $this->HmoId = $hmo->id;
        $this->HmoName = $hmo->name;
        $this->HmoPhone = $hmo->phone;
        $this->HmoEmail = $hmo->email;
        $this->HmoAddress = $hmo->address;
        $this->dispatchBrowserEvent('HmoEditModal');
    }

    public function updateHmo()
    {
        HmoGroup::where('id', $this->HmoId)->update([
            'name' => $this->HmoName,
            'phone' => $this->HmoPhone,
            'email' => $this->HmoEmail,
            'address' => $this->HmoAddress
        ]);

        redirect()->route('app.settings.index')->with('success', 'HMO Updated');
    }

    public function render()
    {
        if ($this->search) {
            $hmos = HmoGroup::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);

            return view(
                'livewire.hmo-groups',
                ['hmos' => $hmos]
            );
        } else {
            $hmos = HmoGroup::query()
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage);
            return view(
                'livewire.hmo-groups',
                ['hmos' => $hmos]
            );
        }
    }
}
