<?php

namespace App\Models;

use App\Traits\Datatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObatalkesRacikan extends Model
{
    use HasFactory, SoftDeletes, Datatable;

    protected $table = 'obatalkes_racikan';
    protected $fillable = [
        'obatalkes_racikan_nama'
    ];

    public function obatalkes(){
        return $this->belongsToMany(ObatAlkes::class, 'obatalkes_racikan_obatalkes','obatalkes_racikan_id','obatalkes_id')->withPivot(['quantity']);
    }

    function syncObatalkes(array $obatalkes){
        if($this->id){
            $data = collect($obatalkes)
                ->mapWithKeys(function($d){
                    return [
                        $d['id'] => [
                            'quantity' => $d['quantity'],
                        ]
                    ];
                })
                ->toArray();
            $this->obatalkes()->sync($data);
        }
    }

    public function pickStock(Float $qty){
        if($this->id){
            foreach($this->obatalkes as $val){
                $totalQuantity = ($val['pivot']['quantity'] * $qty);
                if($totalQuantity > $val['stok']){
                    throw new \Exception("Stok obat '".$this->obatalkes_racikan_nama."' tidak mencukupi.");
                }

                // Pengurangan Stok
                ObatAlkes::where('obatalkes_id',$val['obatalkes_id'])->pickStock(($val['pivot']['quantity'] * $qty));
            }
        }
    }
}
