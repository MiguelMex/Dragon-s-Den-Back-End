<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgeRestriction\StoreAgeRestrictionRequest;
use App\Http\Requests\AgeRestriction\UpdateAgeRestrictionRequest;
use App\Http\Resources\AgeRestrictionsResource;
use App\Http\Resources\WorksResource;
use App\Models\AgeRestrictions;
use App\Models\Works;
use Exception;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class AgeRestrictionsController extends Controller
{
    /**
     * Return all age Restrictions models
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try
        {
            $restrictions = AgeRestrictions::all();
            return AgeRestrictionsResource::collection($restrictions);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Return an Age Restriction by its Id
     * @param mixed $id
     * @return AgeRestrictionsResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            $restriction = AgeRestrictions::findOrFail($id);
            return new AgeRestrictionsResource($restriction);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Method to store in the database
     * @param StoreAgeRestrictionRequest $request
     * @return AgeRestrictionsResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreAgeRestrictionRequest $request)
    {
        try
        {
            //return response()->json(['Error'=>'Llega hasta aquí']);
            //Chek if a nodel already has that name
            $exists = AgeRestrictions::where('name',$request->name)->exists();
            if($exists)
            {
                return response()->json(['Error'=>'Ya existe un modelo con es enombre']);
            }

            $restriction = AgeRestrictions::create($request->validated());
            return new AgeRestrictionsResource($restriction);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Update an existing model
     * @param UpdateAgeRestrictionRequest $request
     * @param string $id
     * @return AgeRestrictionsResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateAgeRestrictionRequest $request,string $id)
    {
        try
        {
            $restriction = AgeRestrictions::findOrFail($id);
            $restriction->name = $request->name;
            $restriction->description = $request->description;
            $restriction->save();
            return new AgeRestrictionsResource($restriction);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Deleta an existing Age Restriction
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try
        {
            AgeRestrictions::findOrFail($id)->delete();
            return response()->json(['Mensaje'=>'Restricción de edad eliminada correctamente']);
        }   
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function work($id)
    {
        try
        {
            $works = AgeRestrictions::findOrFail($id)->works;
            return WorksResource::collection($works);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
