<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chapters\StoreChaptersRequest;
use App\Http\Requests\Chapters\UpdateChaptersRequest;
use App\Http\Resources\ChaptersResource;
use App\Http\Resources\WorksResource;
use App\Models\Chapters;
use App\Models\ReadHistory;
use App\Models\Works;
use Exception;
use Illuminate\Http\Request;

class ChaptersController extends Controller
{
    /**
     * Get all chapters
     * @return ChaptersResource|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try 
        {
            $chapters = Chapters::all();
            return new ChaptersResource($chapters);
        } catch (Exception $ex) {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    /**
     * Show a Chapter by the id
     * @param mixed $id
     * @return ChaptersResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            $chapter = Chapters::findOrFail($id);
            return new ChaptersResource($chapter);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Create a new chapter
     * @param StoreChaptersRequest $request
     * @return ChaptersResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreChaptersRequest $request)
    {
        try
        {
            $exist = Chapters::where([
                'name'=>$request->name,
                'work'=>$request->work,
            ])->exists();

            if ($exist)
            {
                return response()->json(['Error'=>'Ese nombre ya existe en este trabajo']);
            }

            $chapter = Chapters::create($request->validated());
            return new ChaptersResource($chapter);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Update an existing chapter
     * @param UpdateChaptersRequest $request
     * @param mixed $id
     * @return ChaptersResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateChaptersRequest $request, $id)
    {
        try
        {
            $chapter = Chapters::findOrFail($id);
            $chapter->name = $request->name;
            $chapter->cover = $request->cover;
            $chapter->save();
            return new ChaptersResource($chapter);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Delete a chapter
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try
        {
            $chapter = Chapters::findOrFail($id);
            $chapter->delete();
            return response()->json(['Mensaje'=>'Capitulo eliminado']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * get the work of the chapter
     * @param mixed $id
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function work($id)
    {
        try
        {
            $chapter = Works::findOrFail($id);
            return new WorksResource($chapter);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function readHistory($id)
    {
        try
        {
            $history = ReadHistory::findOrFail($id)->readHistory;
            return new ReadHistoryResource($history);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
