<?php

namespace App\Models;

use App\Traits\Datatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signa extends Model
{
    use HasFactory, SoftDeletes, Datatable;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_modified_date';
    const DELETED_AT = 'deleted_date';

    protected $table = 'signa_m';
    protected $primaryKey = 'signa_id';
    protected $fillable = [
        'signa_kode',
        'signa_nama',
        'additional_data',
        'is_active',
        'created_by',
        'last_modified_by',
        'modified_count',
        'deleted_by',
    ];
}
