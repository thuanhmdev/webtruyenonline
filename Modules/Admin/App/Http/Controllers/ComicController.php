<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        try {
            $comic = Comic::all();
            return response()->json([
                'data' => $comic,
                'status' => 200
            ]);
        } catch (\Throwable $e) {
        }
    }

    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'otherName' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'propose' => 'required|boolean',
                'avatar' => "nullable|image|mimes:jpeg,png,jpg|max:3072",
            ]);
            $validator->validate();
            // if ($validator->fails()) {
            //     return response()->json(['status' => false, 'mess' => 'Error!', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            // }
            $data = $request->all();
            if ($request->hasFile('avatar')) {
                $img_path = $request->file('avatar')->store('public/comic');
                $data["avatar"] = str_replace('public/', '', $img_path);
            }

            Comic::create($data);

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            return response()->json([], response::HTTP_BAD_REQUEST);

            if (!$id) {
                return response()->json([], response::HTTP_BAD_REQUEST);
            }

            $dataById = Comic::find($id);

            if (!$dataById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }


            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'otherName' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'propose' => 'required|boolean',
                'avatar' => "nullable|image|mimes:jpeg,png,jpg|max:3072",
            ]);

            // if ($validator->fails()) {
            //     return response()->json(['status' => false, 'mess' => 'Error!', 'errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            // }
            $validator->validator();

            if ($request->hasFile('avatar')) {
                if (!empty($dataById->avatar) && Storage::exists('public/comic/' . $dataById->avatar)) {
                    Storage::delete('public/' . $dataById->avatar);
                }
                $image_path = $request->file('avatar')->store('public/comic');
                $dataById->avatar =  str_replace('public/', "", $image_path);
            }

            $dataById->update($request->all(['name', 'avatar', 'otherName', 'description', 'status', 'author', 'propose',]));

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
            $comicById = Comic::find($id);

            if (!$comicById) {
                return response()->json([
                    'status' => false,
                    'mess' => 'Comic not found',
                ], response::HTTP_BAD_REQUEST);
            }
            $comicById->delete();
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
