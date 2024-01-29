<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        try {
            $comic = Genre::all();
            return response()->json([
                'data' => $comic,
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
        // dd($request);
        // try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'mess' => 'Error!', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Genre::create($request->all());

        return response()->json(['status' => true, 'mess' => ' created!'], Response::HTTP_OK);
        // } catch (\Throwable $e) {
        //     $error = [
        //         'error' => [
        //             'message' => $e->getMessage(),
        //             'code' => $e->getCode(),
        //             'line' => $e->getLine(),
        //             'file' => $e->getFile()
        //         ]
        //     ];

        //     return response()->json($error, 500);
        // }
    }


    public function update(Request $request, $id)
    {
        try {


            if (!$id) {
                return response()->json([], response::HTTP_BAD_REQUEST);
            }

            $comicById = Genre::find($id);

            if (!$comicById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'mess' => 'Error!', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }

            $comicById->update($request->all(['name']));

            return response()->json(['status' => true, 'mess' => ' Updated!'], Response::HTTP_OK);
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
    public function destroy($id)
    {
        try {
            if (!$id) {
                return response()->json(['status' => true, 'mess' => 'Not found!'], Response::HTTP_BAD_REQUEST);
            }
            $dataById = Genre::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Genre not found',
                ], response::HTTP_BAD_REQUEST);
            }
            $dataById->delete();

            return response()->json(['status' => true, 'mess' => 'Deleted'], Response::HTTP_OK);
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
