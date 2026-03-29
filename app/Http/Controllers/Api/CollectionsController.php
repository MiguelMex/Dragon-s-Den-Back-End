<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Http\Resources\CollectionsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorksResource;
use App\Models\Collections;
use Error;
use Exception;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    /**
     * Get all Collections
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try
        {
            $collections = Collections::all();
            return CollectionsResource::collection($collections);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get all collections
     * @param mixed $id
     * @return CollectionsResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            $collection = Collections::findOrFail($id);
            return new CollectionsResource($collection);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Store a Collection
     * @param StoreCollectionRequest $request
     * @return CollectionsResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreCollectionRequest $request)
    {
        try
        {
            //Se if it already exists for this user
            $exists = Collections::where(['name'=>$request->name,'user'=>$request->user])->exists();
            if($exists)
            {
                return response()->json(['Error'=>'Ya existe este nombre en las colecciones del usuario']);
            }

            //se guarda
            $collection = Collections::create($request->validated());
            return new CollectionsResource($collection);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Update a Collection
     * @param UpdateCollectionRequest $request
     * @param mixed $id
     * @return CollectionsResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateCollectionRequest  $request, $id)
    {
        try
        {
            //Se if it already exists for this user
            $exists = Collections::where(['name'=>$request->name,'user'=>$request->user])->exists();
            if($exists)
            {
                return response()->json(['Error'=>'Ya existe este nombre en las colecciones del usuario']);
            }

            //store the changes
            $collection = Collections::findOrFail($id);
            $collection->name = $request->name;
            $collection->description = $request->description;
            $collection->save();
            return new CollectionsResource($collection);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Delete a collection
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try
        {
            Collections::findOrFail($id)->delete();
            return response()->json(['Message'=>'Colección eliminada correctamente']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get all the works of a collection
     * @param mixed $id
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function works($id)
    {
        try
        {
            $collection = Collections::find($id);
            if($collection == null)
            {
                return response()->json(['Error'=>'Esa colección no existe']);
            }

            $works = Collections::where('collection_id',$id)->with('works')->get();
            if($works == null)
            {
                return response()->json(['Error'=>'Este trabajo no existe']);
            }

            return response()->json($works);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get the user a collection belongs to
     * @param mixed $id
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function user($id)
    {
        try
        {
            $collection = Collections::find($id);
            if($collection == null)
            {
                return response()->json(['Error'=>'Esa colección no existe']);
            }

            $user = Collections::where('collection_id',$id)->with('user')->get();
            if($user == null)
            {
                return response()->json(['Error'=>'Este usuario no existe']);
            }

            return response()->json($user);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
