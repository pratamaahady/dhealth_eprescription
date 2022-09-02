<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResepRequest;
use App\Http\Resources\ResepResource;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ResepController extends Controller
{
    public function index(Request $request){
        $resep = Resep::getOrDatatable($request);
        return ResepResource::collection($resep);
    }

    public function show(Resep $resep, Request $request){
        return new ResepResource($resep);
    }

    public function store(ResepRequest $request){

        try
        {
            DB::beginTransaction();

            $resep = new Resep;
            $resep->nama_pasien = $request->nama_pasien;
            $resep->save();

            $resep->syncObatAlkes($request->obatalkes);
            $resep->createSyncObatAlkesRacikan($request->obatalkes_racikan);

            DB::commit();
            return response()->success('Berhasil membuat resep.');
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->error($e->getMessage());
        }

    }

    public function update(Resep $resep, ResepRequest $request){
        DB::beginTransaction();

        $resep->nama_pasien = $request->nama_pasien;
        $resep->save();

        $resep->syncObatAlkes($request->obatalkes);
        $resep->createSyncObatAlkesRacikan($request->obatalkes_racikan);

        DB::commit();

        return response()->success('Berhasil mengubah resep.');
    }

    public function destroy(Resep $resep, Request $request){
        $resep->delete();
        return response()->success('Berhasil menghapus resep.');
    }

    public function pdf(Resep $resep, Request $request){

        $pdf = Pdf::loadView('pdf.resep',[
                'title' => 'Resep',
                'data' => $resep,
            ])
            ->setPaper('a4')
            ->setWarnings(false);

        return response()->success(['pdf' => base64_encode($pdf->stream())]);
    }
}
