<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorksResource;
use App\Models\Genres;
use App\Http\Requests\Genres\GenresRequest;
use App\Http\Resources\GenresResource;
use App\Models\Works;
use Illuminate\Http\Request;
use Exception;
use function PHPUnit\Framework\returnArgument;

class GenresController extends Controller
{
    /**
     * Method to get all genres
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        try
        {
            $genres = Genres::all();
            return GenresResource::collection($genres);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Method to get a genre by the id
     * @param mixed $id
     * @return GenresResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try
        {
            $genre = Genres::findOrFail($id);
            return new GenresResource($genre);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Method to store a genre
     * @param GenresRequest $request
     * @return GenresResource|\Illuminate\Http\JsonResponse
     */
    public function store(GenresRequest $request)
    {
        try
        {
            $exists = Genres::where([
                'name'=>$request->name,
            ])->exists();

            if($exists)
            {
                return response()->json(['Error'=>'Ese genero ya existe']);
            }

            $genre = Genres::create($request->validated());
            return new GenresResource($genre);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Method to update a genre
     * @param GenresRequest $request
     * @param string $id
     * @return GenresResource|\Illuminate\Http\JsonResponse
     */
    public function update(GenresRequest $request,String $id)
    {
        try
        {
            $genre = Genres::findOrFail($id);
            $genre->name = $request->name;
            $genre->save();
            return new GenresResource($genre);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Method to delete a genre
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(String $id)
    {
        try
        {
            Genres::findOrFail($id)->delete();
            return response()->json(['El genero ah sido borrado exitosamente']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    /**
     * Get all the works of a genre
     * @param mixed $id
     * @return WorksResource|\Illuminate\Http\JsonResponse
     */
    public function work($id)
    {
        try
        {
            $genre = Genres::find($id);
            if($genre == null)
            {
                return response()->json(['Error'=>'Este genero no existe']);
            }

            $work = Genres::where('genre_id',$id)->with('work')->get();
            if($work == null)
            {
                return response()->json(['Error'=>'El trabajo no existe']);
            }

            return response()->json($work);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
