<?php

namespace App\Livewire;

use App\Models\AntenatalPackage;
use App\Models\Drug;
use App\Models\Laboratory;
use App\Models\Procedure;
use App\Models\Radiology;

class AntenatalPackages extends Base
{
    public $sortBy = 'name';

    public $pkgId;
    public $pkgName        = '';
    public $pkgDescription = '';
    public $pkgPrice       = '';
    public $pkgExpiry      = '';

    // Each entry: ['type'=>'', 'id'=>0, 'name'=>'', 'qty'=>1]
    public $selectedServices = [];

    protected $rules = [
        'pkgName'  => 'required|string|max:255',
        'pkgPrice' => 'required|numeric|min:0',
        'pkgExpiry'=> 'nullable|date',
        'selectedServices.*.qty' => 'nullable|integer|min:1',
    ];

    public function openCreate()
    {
        $this->pkgId          = null;
        $this->pkgName        = '';
        $this->pkgDescription = '';
        $this->pkgPrice       = '';
        $this->pkgExpiry      = '';
        $this->selectedServices = [];
    }

    public function openEdit($id)
    {
        $pkg = AntenatalPackage::findOrFail($id);
        $this->pkgId            = $pkg->id;
        $this->pkgName          = $pkg->name;
        $this->pkgDescription   = $pkg->description ?? '';
        $this->pkgPrice         = $pkg->price;
        $this->pkgExpiry        = $pkg->expiry_date ? $pkg->expiry_date->format('Y-m-d') : '';
        $this->selectedServices = $pkg->services_covered ?? [];
        $this->dispatchBrowserEvent('open-pkg-modal');
    }

    public function toggleService($type, $id, $name)
    {
        $idx = collect($this->selectedServices)
            ->search(fn($s) => $s['type'] === $type && (int)$s['id'] === (int)$id);

        if ($idx !== false) {
            $services = $this->selectedServices;
            array_splice($services, $idx, 1);
            $this->selectedServices = array_values($services);
        } else {
            $this->selectedServices[] = ['type' => $type, 'id' => (int)$id, 'name' => $name, 'qty' => 1];
        }
    }

    public function isSelected($type, $id): bool
    {
        return collect($this->selectedServices)
            ->contains(fn($s) => $s['type'] === $type && (int)$s['id'] === (int)$id);
    }

    public function getQty($type, $id): int
    {
        $item = collect($this->selectedServices)
            ->first(fn($s) => $s['type'] === $type && (int)$s['id'] === (int)$id);
        return $item['qty'] ?? 1;
    }

    public function updateQty($type, $id, $qty)
    {
        $services = $this->selectedServices;
        foreach ($services as &$s) {
            if ($s['type'] === $type && (int)$s['id'] === (int)$id) {
                $s['qty'] = max(1, (int)$qty);
                break;
            }
        }
        $this->selectedServices = $services;
    }

    public function save()
    {
        $this->validate();

        AntenatalPackage::updateOrCreate(
            ['id' => $this->pkgId],
            [
                'name'             => $this->pkgName,
                'description'      => $this->pkgDescription ?: null,
                'price'            => $this->pkgPrice,
                'expiry_date'      => $this->pkgExpiry ?: null,
                'services_covered' => !empty($this->selectedServices) ? array_values($this->selectedServices) : null,
            ]
        );

        $this->pkgId          = null;
        $this->pkgName        = '';
        $this->pkgDescription = '';
        $this->pkgPrice       = '';
        $this->pkgExpiry      = '';
        $this->selectedServices = [];
        $this->dispatchBrowserEvent('close-pkg-modal');
    }

    public function delete($id)
    {
        AntenatalPackage::findOrFail($id)->delete();
    }

    public function render()
    {
        $packages = AntenatalPackage::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $serviceGroups = [
            'consultation' => ['label' => 'Consultation', 'icon' => 'ti-stethoscope',    'items' => collect([
                (object)['id' => 1, 'name' => 'General Consultation'],
                (object)['id' => 2, 'name' => 'Specialist Consultation'],
            ])],
            'laboratory'   => ['label' => 'Laboratory',   'icon' => 'ti-microscope',     'items' => Laboratory::orderBy('name')->get(['id', 'name'])],
            'imaging'      => ['label' => 'Imaging',      'icon' => 'ti-photo-scan',     'items' => Radiology::orderBy('name')->get(['id', 'name'])],
            'procedure'    => ['label' => 'Procedure',    'icon' => 'ti-surgical-cross',  'items' => Procedure::orderBy('name')->get(['id', 'name'])],
            'pharmacy'     => ['label' => 'Pharmacy',     'icon' => 'ti-pill',           'items' => Drug::orderBy('name')->get(['id', 'name'])],
        ];

        return view('livewire.antenatal-packages', compact('packages', 'serviceGroups'));
    }
}
