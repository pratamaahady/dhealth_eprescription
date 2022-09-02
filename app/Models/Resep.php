<?php

namespace App\Models;

use App\Traits\Datatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use HasFactory, SoftDeletes, Datatable;

    protected $table = 'resep';
    protected $fillable = [
        'nama_pasien',
    ];

    public function obatalkes(){
        return $this->belongsToMany(ObatAlkes::class, 'resep_obatalkes','resep_id','obatalkes_id')->withPivot(['quantity']);
    }

    public function obatalkes_racikan(){
        return $this->belongsToMany(ObatAlkesRacikan::class, 'resep_obatalkes_racikan','resep_id','obatalkes_racikan_id')->withPivot(['quantity']);
    }

    function syncObatalkes(array $obatalkes){
        if($this->id){
            $data = [];
            foreach($obatalkes as $val){
                $data[$val['id']] = [
                    'quantity' => $val['quantity'],
                    'signa_id' => $val['signa_id'],
                ];

                // Pengurangan Stok
                ObatAlkes::where('obatalkes_id',$val['id'])->pickStock($val['quantity']);
            }

            $this->obatalkes()->sync($data);
        }
    }

    function createSyncObatalkesRacikan(array $obatalkesRacikan){
        if($this->id){
            foreach($obatalkesRacikan as &$obatalkesRacikanItem){
                $model = null;
                if(isset($obatalkesRacikanItem['id'])){
                    $model = ObatAlkesRacikan::find($obatalkesRacikanItem['id']);
                }
                if(!$model){
                    $model = ObatAlkesRacikan::create([
                        'obatalkes_racikan_nama' => $obatalkesRacikanItem['nama'],
                    ]);
                }
                $obatalkesRacikanItem['id'] = $model->id;
                $model->syncObatalkes($obatalkesRacikanItem['obatalkes']);
            }
            $this->syncObatalkesRacikan($obatalkesRacikan);
        }
    }

    function syncObatalkesRacikan(array $obatalkesRacikan){
        if($this->id){
            $data = [];
            foreach($obatalkesRacikan as $val){
                $data[$val['id']] = [
                    'quantity' => $val['quantity'],
                    'signa_id' => $val['signa_id'],
                ];

                $model = ObatAlkesRacikan::findOrFail($val['id']);
                $model->pickStock($val['quantity']);
            }

            $this->obatalkes_racikan()->sync($data);
        }
    }
}
