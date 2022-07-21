<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::all();
        return response()->json($bookmarks, 200);
    }

    public function store()
    {
        $result = Bookmark::create($this->validator());
        return response()->json( $result, 200);
    }

    public function show(Bookmark $bookmark)
    {
        return response()->json($bookmark, 200);
    }

    public function update(Bookmark $bookmark)
      {

       try
       {

          $result = $bookmark->update($this->updateValidator());

          return response()->json( $result, 200);

      } catch (\Throwable $th) {
        if (env('APP_DEBUG') == true) {
          return response($th)->setStatusCode(500);
        }
          return response($th->getMessage())->setStatusCode(500);
     }
    }

     public function destroy(Bookmark $bookmark)
     {
         $bookmark->delete();
         return response()->json(null, 200);
     }

    public function validator(){
        return request()->validate([
            'name'                           => 'required|string|max:255',
            'form_id'                        => 'required|integer',
            'row'                            => 'required',
            'column'                         => 'required',
            'display_type'                   => 'required|string|max:255',
            'aggregator_type'                => 'nullable|string|max:255',
            'params1'                        => 'nullable|string|max:255',
            'params2'                        => 'nullable|string|max:255',
        ]);
    }
    public function updateValidator(){
        return request()->validate([
            'name'                           => 'sometimes|string|max:255',
            'form_id'                        => 'sometimes|integer',
            'row'                            => 'sometimes',
            'column'                         => 'sometimes',
            'display_type'                   => 'sometimes|string|max:255',
            'aggregator_type'                => 'nullable|string|max:255',
            'params1'                        => 'nullable|string|max:255',
            'params2'                        => 'nullable|string|max:255',
        ]);
    }

}
