<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    public function get()
    {
        try {
            $comic = Chapter::all();
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
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'comic_id' => "required|exists:comics,id",
            ]);
            $validator->validate();
            Chapter::create($request->all());

            return response()->json(['status' => true, 'mess' => ' created!'], Response::HTTP_OK);
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


    public function update(Request $request, $id)
    {
        try {
            if (!$id) {
                return response()->json([], response::HTTP_BAD_REQUEST);
            }
            $dataById = Chapter::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'comic_id' => "required|exists:comics,id"
            ]);
            $validator->validate();

            $dataById->update($request->all(['name', 'description', "comic_id"]));

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
            $dataById = Chapter::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }

            if (!empty($dataById->avatar) && Storage::exists('public/chapter/' . $dataById->avatar)) {
                Storage::delete('public/chapter/' . $dataById->avatar);
            }
            $dataById->delete();
            return response()->json([
                'status' => true,
                'mess' => 'Deleted',
            ], 204);
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
