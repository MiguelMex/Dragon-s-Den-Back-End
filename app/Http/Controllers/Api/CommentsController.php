<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommenstRequest;
use App\Http\Requests\Comments\UpdateCommenstRequest;
use App\Http\Resources\CommentsResource;
use App\Models\Comments;
use Exception;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * get all the comments
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(){
        try
        {
            $comments = Comments::all();
            return CommentsResource::collection($comments);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'->$ex->getMessage()]);
        }
    }

    /**
     * get a comment by the id
     * @param string $id
     * @return CommentsResource|\Illuminate\Http\JsonResponse
     */
    public function show(string $id){
        try
        {
            $comment = Comments::find($id);
            if($comment == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);
            }

            return new CommentsResource($comment);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'->$ex->getMessage()]);
        }
    }

    /**
     * create a comment
     * @param StoreCommenstRequest $request
     * @return CommentsResource|\Illuminate\Http\JsonResponse
     */
    public function store(StoreCommenstRequest $request){
        try
        {
            $comment = Comments::create($request->validated());
            return new CommentsResource($comment);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'->$ex->getMessage()]);
        }
    }

    /**
     * update a comment
     * @param UpdateCommenstRequest $request
     * @param string $id
     * @return CommentsResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateCommenstRequest $request, string $id){
        try
        {
            $comment = Comments::find($id);
            if ($comment == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $comment->text = $request->text;
            $comment->save();

            return new CommentsResource($comment);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'->$ex->getMessage()]);
        }
    }

    /**
     * delete an existing comment
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id){
        try
        {
            $comment = Comments::find($id);
            if ($comment == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $comment->delete();
            return response()->json(['Mensaje'=>'Comentario eliminado correctamente']);
        }
        catch (Exception $ex)
        {
            return response()->json(['Error'->$ex->getMessage()]);
        }
    }
    
    public function chapter(string $id)
    {
        try
        {
            $exists = Comments::find($id);
            if ($exists == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $commentChapter = Comments::where(['comment_id',$id])->with('chapter')->get();
            return response()->json($commentChapter);
        }
        catch(Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function user(string $id)
    {
        try
        {
            $exists = Comments::find($id);
            if ($exists == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $commentUser = Comments::where(['comment_id',$id])->with('user')->get();
            return response()->json($commentUser);
        }
        catch(Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function parent(string $id)
    {
        try
        {
            $exists = Comments::find($id);
            if ($exists == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $commentParent = Comments::where(['comment_id',$id])->with('parent')->get();
            return response()->json($commentParent);
        }
        catch(Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }

    public function children(string $id)
    {
        try
        {
            $exists = Comments::find($id);
            if ($exists == null)
            {
                return response()->json(['Error' => 'Comentario no encontrado']);   
            }

            $commentChildren = Comments::where(['comment_id',$id])->with('children')->get();
            return response()->json($commentChildren);
        }
        catch(Exception $ex)
        {
            return response()->json(['Error'=>$ex->getMessage()]);
        }
    }
}
