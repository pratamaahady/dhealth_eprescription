<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObatAlkesRequest;
use App\Http\Resources\ObatAlkesResource;
use App\Models\ObatAlkes;
use Illuminate\Http\Request;

class ObatAlkesController extends Controller
{
    public function index(Request $request){
        $obatAlkes = ObatAlkes::condition($request)->getOrDatatable($request);
        return ObatAlkesResource::collection($obatAlkes);
    }

    public function show($id, Request $request){
        $obatAlkes = ObatAlkes::findOrFail($id);
        return new ObatAlkesResource($obatAlkes);
    }

    public function store(ObatAlkesRequest $request){
        $obatAlkes = new ObatAlkes;
        $obatAlkes->obatalkes_kode = $request->obatalkes_kode;
        $obatAlkes->obatalkes_nama = $request->obatalkes_nama;
        $obatAlkes->additional_data = $request->additional_data;
        $obatAlkes->save();

        return response()->success('Berhasil membuat obat alkes.');
    }

    public function update($id, ObatAlkesRequest $request){
        $obatAlkes = ObatAlkes::findOrFail($id);
        $obatAlkes->obatalkes_kode = $request->obatalkes_kode;
        $obatAlkes->obatalkes_nama = $request->obatalkes_nama;
        $obatAlkes->additional_data = $request->additional_data;
        $obatAlkes->save();

        return response()->success('Berhasil mengubah obat alkes.');
    }

    public function destroy($id, Request $request){
        $obatAlkes = ObatAlkes::findOrFail($id);
        $obatAlkes->delete();
        return response()->success('Berhasil menghapus obat alkes.');
    }
}
