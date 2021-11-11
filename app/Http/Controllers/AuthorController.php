<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function getAuthor($id){
        return Authors::findOrFail($id);
    }

    public function createAuthor(Request $request){
        $data = $request->all();

        try{
            $author = new Authors;
            $author->name = $data['name'];
            $author->url = $data['url'];
            $author->description = $data['description'];
            
            $author->save();
            $status = "success";
            return response()->json(compact('status', 'author'), 200);
        } catch(\Throwable $th){
            $status = "error";
            return response()->json(compact('status'), 401);
        }
    }

    public function updateAuthor($id, Request $request){
        $data = $request->all();

        try{
            $author = Authors::findOrFail($id);
            $author->name = $data['name'];
            $author->url = $data['url'];
            $author->description = $data['description'];
            
            $author->save();
            $status = "success";
            return response()->json(compact('status', 'author'), 200);
        } catch(\Throwable $th){
            $status = "error";
            return response()->json(compact('status'), 401);
        }
    }

    public function deleteAuthor($id){
        $author = Authors::findOrfail($id);
        $author->delete();
        $status = "success deleted";
        return response()->json(compact('status'), 200);
    }
}
