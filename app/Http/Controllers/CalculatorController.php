<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Setting;
use App\Models\StructuralProfile;
use App\Services\WeightCalculator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalculatorController extends Controller
{
    public function __construct(private readonly WeightCalculator $calculator) {}

    public function index(): View
    {
        return view('calculator.index', $this->pageData() + [
            'result' => null,
            'inputs' => [],
        ]);
    }

    public function calculate(Request $request): View|JsonResponse
    {
        $data = $request->validate($this->rules($request));

        $material = Material::query()->active()->findOrFail($data['material_id']);
        $profile = null;

        if ($data['shape'] === 'profil') {
            $profile = StructuralProfile::query()->findOrFail($data['profile_id']);
        }

        $result = $this->calculator->calculate(
            shape: $data['shape'],
            input: $data,
            material: $material,
            quantity: (int) ($data['jumlah'] ?? 1),
            profile: $profile,
        );

        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'html' => view('calculator._result', [
                    'result' => $result,
                    'inputs' => $data,
                ])->render(),
            ]);
        }

        return view('calculator.index', $this->pageData() + [
            'result' => $result,
            'inputs' => $data,
        ]);
    }

    /** @return array<string, mixed> */
    private function rules(Request $request): array
    {
        $shapes = config('calculator.shapes');
        $shape = (string) $request->input('shape');

        $rules = [
            'shape' => ['required', 'string', 'in:'.implode(',', array_keys($shapes))],
            'material_id' => ['required', 'integer', 'exists:materials,id'],
            'jumlah' => ['nullable', 'integer', 'min:1', 'max:1000000'],
        ];

        foreach ($shapes[$shape]['fields'] ?? [] as $field) {
            $rules[$field['key']] = ['required', 'numeric', 'min:0.01', 'max:100000000'];
        }

        if ($shapes[$shape]['uses_profile'] ?? false) {
            $rules['profile_id'] = ['required', 'integer', 'exists:structural_profiles,id'];
        }

        return $rules;
    }

    /** @return array<string, mixed> */
    private function pageData(): array
    {
        return [
            'shapes' => config('calculator.shapes'),
            'materials' => Material::query()->active()->orderBy('name')->get(),
            'profileGroups' => StructuralProfile::query()
                ->orderBy('type')
                ->orderBy('weight_per_m')
                ->get()
                ->groupBy('type'),
            'types' => StructuralProfile::TYPES,
            'settings' => Setting::allMap(),
        ];
    }
}
