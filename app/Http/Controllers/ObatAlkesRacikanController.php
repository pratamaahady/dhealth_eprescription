<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObatAlkesRacikanRequest;
use App\Http\Resources\ObatAlkesRacikanResource;
use App\Models\ObatAlkesRacikan;
use Illuminate\Http\Request;

class ObatAlkesRacikanController extends Controller
{
    public function index(Request $request){
        $obatAlkesRacikan = ObatAlkesRacikan::getOrDatatable($request);
        return ObatAlkesRacikanResource::collection($obatAlkesRacikan);
    }

    public function show($id, Request $request){
        $obatAlkesRacikan = ObatAlkesRacikan::findOrFail($id);
        return new ObatAlkesRacikanResource($obatAlkesRacikan);
    }

    public function store(ObatAlkesRacikanRequest $request){
        $obatAlkesRacikan = new ObatAlkesRacikan;
        $obatAlkesRacikan->obatalkes_racikan_nama = $request->obatalkes_racikan_nama;
        $obatAlkesRacikan->save();

        $obatAlkesRacikan->syncObatalkes($request->obatalkes);

        return response()->success('Berhasil membuat obat alkes racikan.');
    }

    public function update($id, ObatAlkesRacikanRequest $request){
        $obatAlkesRacikan = ObatAlkesRacikan::findOrFail($id);
        $obatAlkesRacikan->obatalkes_racikan_nama = $request->obatalkes_racikan_nama;
        $obatAlkesRacikan->save();

        $obatAlkesRacikan->syncObatalkes($request->obatalkes);

        return response()->success('Berhasil mengubah obat alkes racikan.');
    }

    public function destroy($id, Request $request){
        $obatAlkesRacikan = ObatAlkesRacikan::findOrFail($id);
        $obatAlkesRacikan->delete();
        return response()->success('Berhasil menghapus obat alkes racikan.');
    }
}
