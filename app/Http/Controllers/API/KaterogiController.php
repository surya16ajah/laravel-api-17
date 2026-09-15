<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriRequest;
use App\Http\Resources\KategoriCollection;
use App\Http\Resources\KategoriResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KaterogiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return response()->json(KategoriResource::collection($kategori),
        Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request)
    {
        $kategori = Kategori::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Kategori Created Succesfully',
            'data' => new KategoriResource($kategori),
        ],
        Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriRequest $request, Kategori $kategori)
    {
        $kategori->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil di update',
            'data' => new KategoriResource ($kategori),
        ],
        Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil dihapus',
        ],
        Response::HTTP_OK);
    }
}
