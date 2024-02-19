<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChapterContent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChapterContentController extends Controller
{
    public function get()
    {
        try {
            $chapterContent = ChapterContent::all();
            return response()->json([
                'data' => $chapterContent,
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
            $data = $request->all();
            $validator = Validator::make($data, [
                'order' => 'nullable|string|max:255',
                'image' => "nullable|image|mimes:jpeg,png,jpg|max:3072",
                'chapter_id' => 'required|exists:chapters,id'
            ]);
            $validator->validate();
            if ($request->hasFile('image')) {
                $img_path = $request->file('image')->store('public/chapterContent');
                $data['image'] = str_replace('public/', '', $img_path);
            }
            ChapterContent::create($data);
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

            $dataById = ChapterContent::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'data not found',
                ], response::HTTP_BAD_REQUEST);
            }

            $validator = Validator::make($request->all(), [
                'order' => 'nullable|string|max:255',
                'image' => "nullable|image|mimes:jpeg,png,jpg|max:3072",
                'chapter_id' => 'required|exists:chapters,id'
            ]);
            $validator->validate();

            if ($request->hasFile('image')) {
                if (!empty($dataById->avatar) && Storage::exists('public/chapterContent/' . $dataById->avatar)) {
                    Storage::delete('public/' . $dataById->avatar);
                }
                $image_path = $request->file('image')->store('public/chapterContent');
                $dataById->avatar =  str_replace('public/', "", $image_path);
            }

            $dataById->update($request->all(['order', 'image', 'chapter_id']));

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
            $dataById = ChapterContent::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'data not found',
                ], response::HTTP_BAD_REQUEST);
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
