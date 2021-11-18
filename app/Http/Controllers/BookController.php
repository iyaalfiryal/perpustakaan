<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;


class BookController extends Controller
{
    //findOrFail untuk mencari data buku berdasarkan id
    //jika tidak ditemukan maka akan muncul error not found 404
    public function getBook($id){
        return Books::findOrFail($id);
    }

    public function getAllBook(Request $request){
        
        //create parameter food filter
        $id = $request->input('id');
        $nisbn = $request->input('nisbn');
        $title = $request->input('title');

        // Get Data Food By id
        if ($id) {
            $food = Books::find($id);
            if ($food) {
                return ResponseFormatter::success(
                    $food,
                    'Success Get Data Food By ID'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Food Not Found',
                    404
                );
            }
        }

        $query = array();

        // get data book by nisbn
        if($nisbn){
            array_push($query,['nisbn', 'like', '%' . $nisbn . '%']);
        }

        //get data book by title
        if($title){
            array_push($query,['types', 'like', '%' . $title . '%']);
        }

        // $status = 'success';
        $result = Books::where($query);
        return ResponseFormatter::success(
            $result,
            'Success Get Data List Book'
        );

    }

    public function createBook(Request $request){
        $data = $request->all();

        try {
            $book = new Books();
            $book->nisbn = $data['nisbn'];
            $book->title = $data['title'];
            $book->description = $data['description'];
            $book->image_url = $data['image_url'];
            $book->stock = $data['stock'];
            $book->rating = $data['rating'];
            $book->publisher_id = $data['publisher_id'];
            $book->author_id = $data['author_id'];

            //buat save ke database
            $book->save();
            $status = 'success';
            return response()->json(compact('status', 'book'), 200);

        } catch (\Throwable $th) {
            $status = 'error';
            return response()->json(compact('status', 'th'), 401);

        }
    }

    public function updateBook($id, Request $request){
        $data = $request->all();

        try {
            $book = Books::findOrFail($id);
            $book->nisbn = $data['nisbn'];
            $book->title = $data['title'];
            $book->description = $data['description'];
            $book->image_url = $data['image_url'];
            $book->stock = $data['stock'];
            $book->rating = $data['rating'];
            $book->publisher_id = $data['publisher_id'];
            $book->author_id = $data['author_id'];

            //buat save ke database
            $book->save();
            $status = 'success';
            return response()->json(compact('status', 'book'), 200);

        } catch (\Throwable $th) {
            $status = 'error';
            return response()->json(compact('status', 'th'), 200);

        }
    }

    public function deleteBook($id){

        $book = Books::findOrFail($id);
        $book->delete();

        $status = "delete success";
        return response()->json(compact('status'), 200);

    }
    
}






        // $description = $request->input('description');
        // $image_url = $request->input('image_url');
        // $stock = $request->input('stock');
        // $rating = $request->input('rating');
        // $publisher_id = $request->input('publisher_id');
        // $author_id = $request->input('author_id');