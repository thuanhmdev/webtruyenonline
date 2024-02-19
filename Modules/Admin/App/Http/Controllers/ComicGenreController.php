<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\ComicGenre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\App\Models\ComicGenre as ModelsComicGenre;

class ComicGenreController extends Controller
{
    public function get()
    {
        try {
            $data = ModelsComicGenre::all();
            return response()->json([
                'data' => $data,
                'status' => 200
            ]);
        } catch (\Throwable $e) {

            $error = [
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ];

            return response()->json($error, 500);
        }
    }


    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comic_id' => "required|exists:comics,id",
                'genre_id' => 'required|exists:genres,id',
            ]);
            $validator->validate();

            ComicGenre::create($request->all(['comic_id', 'genre_id']));

            return response()->json(['status' => true, 'mess' => ' Created!'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            $error = [
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ];

            return response()->json($error, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            $dataById = ComicGenre::where([
                'comic_id ' => $request->input('comic_id'),
                'genre_id' => $request->input('genre_id'),
            ])->first();


            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }

            $dataById->delete();
            return response()->json([
                'status' => true,
                'mess' => 'Deleted',
            ], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            $error = [
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ];

            return response()->json($error, 500);
        }
    }
}
