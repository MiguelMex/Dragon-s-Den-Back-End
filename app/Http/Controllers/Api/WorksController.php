<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Works\StoreWorksRequest;
use App\Http\Requests\Works\UpdateWorksRequest;
use App\Http\Resources\AgeRestrictionsResource;
use App\Http\Resources\ChaptersResource;
use App\Http\Resources\GenresResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Works;
use App\Http\Resources\WorksResource;
use App\Http\Resources\CollectionsResource;
use Exception;

class WorksController extends Controller
{
    /**
     * Get all works
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try
        {
            $works = Works::all();
            return WorksResource::collection($works);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get a work by the id
     * @param string $id
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function show(String $id)
    {
        try
        {
            $work = Works::findOrFail($id);
            return new WorksResource($work);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Create a new work
     * @param StoreWorksRequest $request
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreWorksRequest $request)
    {
        try
        {
            $exists = Works::where(['title'=>$request->title,'author'=>$request->author])->exists();
            if ($exists)
            {
                return response()->json(['Error'=>'este autor ya posee ese titulo']);
            }

            //If it doesn't exist, create it
            $work = Works::create($request->validated());
            return new WorksResource($work);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Update a work
     * @param UpdateWorksRequest $request
     * @param string $id
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateWorksRequest $request, String $id)
    {
        try
        {
            $exists = Works::where(['title'=>$request->title,'author'=>$request->author])->exists();
            if ($exists)
            {
                return response()->json(['Error'=>'este autor ya posee ese titulo']);
            }

            //If title is not already on use for this user
            $work = Works::findOrFail($id);
            $work->title = $request->title;
            $work->description = $request->description;
            $work->status = $request->status;
            $work->cover = $request->cover;
            $work->age_restriction = $request->age_restriction;
            $work->save();
            return new WorksResource($work);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Delete an existing work
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(String $id)
    {
        try
        {
            Works::findOrFail($id)->delete();
            return response()->json(['Message'=>'Trabajo borrado exitosamente']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function author(String $id)
    {
        try
        {
            $work = Works::findOrFail($id);
            $author = $work->author()->email;
            return response()->json(['message'=>'LLega hasta aquí','datos'=>$author]);
            return new UserResource($author);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function ageRestriction(String $id)
    {
        try
        {
            $restriction = Works::findOrFail($id)->ageRestriction;
            return new AgeRestrictionsResource($restriction);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function chapter(String $id)
    {
        try
        {
            $chapters = Works::findOrFail($id)->chapter;
            return ChaptersResource::collection($chapters);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function comment()
    {
        try
        {
            //TODO
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function genres(String $id)
    {
        try
        {
            $genres = Works::findOrFail($id)->genres;
            return GenresResource::collection($genres);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function readHistory()
    {
        try
        {
            //TODO
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function readList()
    {
        try
        {
            //TODO
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function collection(String $id)
    {
        try
        {
            $collections = Works::findOrFail($id)->collection;
            return CollectionsResource::collection($collections);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }


}
