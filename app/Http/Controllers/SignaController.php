<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignaRequest;
use App\Http\Resources\SignaResource;
use App\Models\Signa;
use Illuminate\Http\Request;

class SignaController extends Controller
{
    public function index(Request $request){
        $signa = Signa::getOrDatatable($request);
        return SignaResource::collection($signa);
    }

    public function show($id, Request $request){
        $signa = Signa::findOrFail($id);
        return new SignaResource($signa);
    }

    public function store(SignaRequest $request){
        $signa = new Signa;
        $signa->signa_kode = $request->signa_kode;
        $signa->signa_nama = $request->signa_nama;
        $signa->additional_data = $request->additional_data;
        $signa->save();

        return response()->success('Berhasil membuat signa.');
    }

    public function update($id, SignaRequest $request){
        $signa = Signa::findOrFail($id);
        $signa->signa_kode = $request->signa_kode;
        $signa->signa_nama = $request->signa_nama;
        $signa->additional_data = $request->additional_data;
        $signa->save();

        return response()->success('Berhasil mengubah signa.');
    }

    public function destroy($id, Request $request){
        $signa = Signa::findOrFail($id);
        $signa->delete();
        return response()->success('Berhasil menghapus signa.');
    }
}
