<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreWorksInProgressRequest;
use App\Http\Requests\UpdateWorksInProgressRequest;
use App\Models\WorksInProgress;
use App\Http\Resources\WorksInProgressResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class WorksInProgressController extends Controller
{
    /**
     * Muestra todos los modelos
     */
    public function index(): AnonymousResourceCollection
    {
        $wips = WorksInProgress::all();
        return WorksInProgressResource::collection($wips);
    }

    /**
     * almacenar wip
     */
    public function store(StoreWorksInProgressRequest $request)
    {
        try {
            $wip = WorksInProgress::create($request->validated());
            return new WorksInProgressResource($wip);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Mostrar un post especifico
     */
    public function show(string $id)
    {
        try {
            $worksInProgress = WorksInProgress::findOrFail($id);
            return new WorksInProgressResource($worksInProgress);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Actualizar un post existente
     */
    public function update(string $id, UpdateWorksInProgressRequest $wip)
    {
        try {
            $workInProgress = WorksInProgress::findOrFail($id);
            $workInProgress->update($wip->validated());
            return new WorksInProgressResource($workInProgress);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $wip = WorksInProgress::findOrFail($id);
            $wip->delete();
            return response()->json(['message'=>'Eliminado correctamente'],200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
