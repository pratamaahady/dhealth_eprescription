<?php

namespace App\Models;

use App\Traits\Datatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatAlkes extends Model
{
    use HasFactory, SoftDeletes, Datatable;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_modified_date';
    const DELETED_AT = 'deleted_date';

    protected $table = 'obatalkes_m';
    protected $primaryKey = 'obatalkes_id';
    protected $fillable = [
        'obatalkes_kode',
        'obatalkes_nama',
        'stok',
        'additional_data',
        'is_active',
        'created_by',
        'last_modified_by',
        'modified_count',
        'deleted_by',
    ];

    public function scopePickStock($query, Float $qty){
        return $query->update(['stok' => DB::raw("(stok - $qty)")]);
    }

    public static function scopeCondition($query, Request $request){
        if($request->have_stock){
            $query->where('stok','>',0);
        }
        return $query;
    }
}
