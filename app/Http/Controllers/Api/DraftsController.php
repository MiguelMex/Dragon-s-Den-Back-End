<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drafts\StoreDraftRequest;
use App\Http\Requests\Drafts\UpdateDraftRequest;
use App\Http\Resources\DraftsResource;
use App\Http\Resources\WorksInProgressResource;
use App\Models\Drafts;
use App\Models\WorksInProgress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DraftsController extends Controller
{
    /**
     * Return all drafts
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try
        {
            $drafts = Drafts::all();
            return DraftsResource::collection($drafts);
        } 
        catch (Exception $ex)
        {
            return response()->json(['error'=>$ex],500);
        }
    }

    /**
     * Return all drafts from a Work in progress
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function wipIndex(Request $request)
    {
        try
        {
            $drafts = Drafts::where('work_in_progress', $request->wip)->get();
            return DraftsResource::collection($drafts);
        }
        catch (Exception $ex)
        {
            return response()->json(["Error"=>$ex->getMessage(),500]);
        }
    }

    /**
     * Create a draft
     * @param StoreDraftRequest $request
     * @return DraftsResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreDraftRequest $request)
    {
        try
        {
            $exists = Drafts::where([
                'name'=>$request->name,
                'work_in_progress'=>$request->work_in_progress
                ])->exists();

            if ($exists)
            {
                return response()->json(['Error' => "Ese nombre de draft ya existe en este trabajo"]);
            }

            //Method to store the file in the local disk
            $name = $request->name;
            $time = date('d-m-y h:i:s');
            $fileName = trim("$name-$time");

            Storage::disk('public')->put($fileName,'');
            $request->route = "storage/public/$fileName";

            $draft = Drafts::create($request->validated());
            return new DraftsResource($draft);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error' => $ex->getMessage()]);
        }
    }

    /**
     * Get a draft by the id
     * @param Request $request
     * @return DraftsResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            $draft = Drafts::findOrFail($id);
            return new DraftsResource($draft);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Update an existing draft model
     * @param UpdateDraftRequest $request
     * @param mixed $id
     * @return DraftsResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateDraftRequest $request, $id)
    {
        try
        {
            $draft = Drafts::findOrFail($id);
            $draft->name = $request->name;
            $draft->save();
            return new DraftsResource($draft);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Delete a draft moodel from the database
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try
        {
            Drafts::findOrFail($id)->delete();
            return response()->json(['Mensaje'=>'Draft eliminado correctamente']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get the work in progress of a draft
     * @param mixed $id
     * @return WorksInProgressResource|\Illuminate\Http\JsonResponse
     */
    public function workInProgress($id)
    {
        try
        {
            $draft = Drafts::find($id);
            if($draft == null) 
            {
                return response()->json(['Error'=>'Ese draft no existe']);
            }

            $wip = Drafts::where('draft_id',$id)->with('workInProgress')->get();
            if($wip == null)
            {
                return response()->json(['Error'=>'No existe tal proyecto']);
            }

            return response()->json($wip);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
