<?php

namespace App\Http\Controllers;

use App\Models\AntenatalPackage;
use App\Models\Drug;
use App\Models\Laboratory;
use App\Models\Procedure;
use App\Models\Radiology;
use Illuminate\Http\Request;

class AntenatalPackageController extends Controller
{
    public function index()
    {
        $packages = AntenatalPackage::orderBy('name')->paginate(15);

        $serviceGroups = $this->getServiceGroups();

        return view('settings.antenatal.index', compact('packages', 'serviceGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'expiry_date' => 'nullable|date',
        ]);

        $services = $this->parseServices($request);

        AntenatalPackage::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'expiry_date'      => $request->expiry_date ?: null,
            'services_covered' => !empty($services) ? $services : null,
        ]);

        return redirect()->route('app.settings.antenatal')->with('success', 'Package created successfully.');
    }

    public function edit(AntenatalPackage $antenatalPackage)
    {
        $packages      = AntenatalPackage::orderBy('name')->paginate(15);
        $serviceGroups = $this->getServiceGroups();

        return view('settings.antenatal.index', compact('packages', 'serviceGroups', 'antenatalPackage'));
    }

    public function update(Request $request, AntenatalPackage $antenatalPackage)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'expiry_date' => 'nullable|date',
        ]);

        $services = $this->parseServices($request);

        $antenatalPackage->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'price'            => $request->price,
            'expiry_date'      => $request->expiry_date ?: null,
            'services_covered' => !empty($services) ? $services : null,
        ]);

        return redirect()->route('app.settings.antenatal')->with('success', 'Package updated successfully.');
    }

    public function destroy(AntenatalPackage $antenatalPackage)
    {
        $antenatalPackage->delete();
        return redirect()->route('app.settings.antenatal')->with('success', 'Package deleted.');
    }

    // -------------------------------------------------------

    private function parseServices(Request $request): array
    {
        $services = [];
        $types    = $request->input('service_type', []);
        $ids      = $request->input('service_id', []);
        $names    = $request->input('service_name', []);
        $qtys     = $request->input('service_qty', []);

        foreach ($types as $i => $type) {
            if (empty($type) || empty($ids[$i])) continue;
            $services[] = [
                'type' => $type,
                'id'   => (int) $ids[$i],
                'name' => $names[$i] ?? '',
                'qty'  => max(1, (int) ($qtys[$i] ?? 1)),
            ];
        }

        return $services;
    }

    private function getServiceGroups(): array
    {
        return [
            'consultation' => [
                'label' => 'Consultation',
                'items' => collect([
                    (object)['id' => 1, 'name' => 'General Consultation'],
                    (object)['id' => 2, 'name' => 'Specialist Consultation'],
                ]),
            ],
            'laboratory' => [
                'label' => 'Laboratory',
                'items' => Laboratory::orderBy('name')->get(['id', 'name']),
            ],
            'imaging' => [
                'label' => 'Imaging',
                'items' => Radiology::orderBy('name')->get(['id', 'name']),
            ],
            'procedure' => [
                'label' => 'Procedure',
                'items' => Procedure::orderBy('name')->get(['id', 'name']),
            ],
            'pharmacy' => [
                'label' => 'Pharmacy',
                'items' => Drug::orderBy('name')->get(['id', 'name']),
            ],
        ];
    }
}
