<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreWorksInProgressRequest;
use App\Http\Requests\UpdateWorksInProgressRequest;
use App\Http\Resources\DraftsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WipDraftsResource;
use App\Models\Genres;
use App\Models\WorksInProgress;
use App\Http\Resources\WorksInProgressResource;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorksInProgressController extends Controller
{
    /**
     * Muestra todos los modelos
     */
    public function index()
    {
        try
        {
            $wips = WorksInProgress::all();
            //return response()->json($wips);
            return WorksInProgressResource::collection($wips);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()],500);
        }
    }

    /**
     * almacenar wip
     */
    public function store(StoreWorksInProgressRequest $request)
    {
        try {
            $exists = WorksInProgress::where('title',$request->title)->exists();
            if ($exists)
            {
                return response()->json(['error'=>'Nombre ya existente']);
            }
            $wip = WorksInProgress::create($request->validated());
            return new WorksInProgressResource($wip);
        } catch (Exception $e) {
            return response()->json([
                'Error' => $e->getMessage(),
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
        } catch (Exception $e) {
            return response()->json([
                'Error' => $e->getMessage(),
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
        } catch (Exception $e) {
            return response()->json([
                'Error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $wip = WorksInProgress::findOrFail($id);
            $wip->delete();
            return response()->json(['message'=>'Eliminado correctamente'],200);
        } catch (Exception $e) {
            return response()->json([
                'Error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all drafts of this wip
     * @param string $id
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function drafts(String $id)
    {
        try
        {
            $exists = WorksInProgress::find($id);
            if($exists == null)
            {
                return response()->json(['message'=>'WIP nnot found']);
            }

            $drafts = WorksInProgress::where('work_in_progress_id',$id)->with('drafts')->get();
            return WipDraftsResource::collection($drafts);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    
    /**
     * Get the user a wip belongs to
     * @param string $id
     * @return JsonResponse|UserResource
     */
    public function user(String $id)
    {
        try
        {
            $user = Genres::findOrFail($id)->user;
            return new UserResource($user);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
