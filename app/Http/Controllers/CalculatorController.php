<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRequest;
use App\Http\Resources\CalculationResource;
use App\Models\Calculation;
use App\Services\MathService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Inertia\Response;

class CalculatorController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Calculator');
    }

    /**
     * @param CalculateRequest $request
     * @param MathService $mathService
     * @return CalculationResource|JsonResponse
     */
    public function calculate(CalculateRequest $request, MathService $mathService): CalculationResource|JsonResponse
    {
        $expression = $request->input('expression');

        try {
            $result = $mathService->calculate($expression);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid expression'], 400);
        }

        $calculation = Calculation::create([
            'expression' => $expression,
            'result' => $result,
        ]);

        return new CalculationResource($calculation);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function history(): AnonymousResourceCollection
    {
        $calculations = Calculation::latest()->get();

        return CalculationResource::collection($calculations);
    }

    /**
     * @param Calculation $calculation
     * @return JsonResponse
     */
    public function delete(Calculation $calculation): JsonResponse
    {
        $calculation->delete();

        return response()->json(['message' => 'Calculation deleted']);
    }

    /**
     * @return JsonResponse
     */
    public function deleteAll(): JsonResponse
    {
        Calculation::truncate();

        return response()->json(['message' => 'All calculations deleted']);
    }
}
