<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatatableFactory{
    protected $_builder;
    protected $_request;
    protected $_table;
    protected $_limit = 10;
    protected $_columns = [];
    protected $_seachKey;
    protected $_searchCast = 'CHAR(255)';
    protected $_sortData = 0;
    protected $_sortDirection = 'ASC';
    protected $_hasAlias = false;
    protected $_connection;
    protected $_withSelectAll = true;

    function __construct(){

        $this->_connection = env("DB_CONNECTION");
        $this->_searchCast = ($this->_connection == 'pgsql') ? 'VARCHAR' : 'CHAR(255)';
    }

    public static function eloquent(EloquentBuilder $builder, Request $request, bool $withSelectAll=true){
        $self = new Self;
        $self->_builder = $builder;
        $self->_request = $request;
        $self->_table = $builder->getModel()->getTable();
        $self->_withSelectAll = $withSelectAll;

        $self->setPayload(); // Set Local Variable
        $self->search(); // Search some value
        $self->sort(); // Sort data

        return $self->paginate();
    }

    protected function setPayload(){
        $this->hasAlias();
        $this->setColumns();
        $this->setLimit();
        $this->setSearchKey();
        $this->setSort();
    }

    protected function setColumns(){
        $columns = $this->_request->column ?? [];
        foreach($columns as $key => $column){
            $colData = $column['data'];
            $colRelation = null;
            $colSearch = isset($column['search']) ? strtolower($column['search']) : null;
            $colSearchable = $column['searchable'];

            if(strpos($colData,'.')){
                $colDataArray = explode('.',$colData);
                $colDataString = end($colDataArray);

                $colRelation = str_replace(".$colDataString","",$colData);
                $colData = $colDataString;
            }

            $this->_columns[$key] = [
                'data'      => $colData,
                'relation'  => $colRelation,
                'search'     => $colSearch,
                'searchable' => filter_var($colSearchable, FILTER_VALIDATE_BOOLEAN),
            ];
        }
    }

    protected function setLimit(){
        $this->_limit = $this->_request->limit ?? $this->_limit;
    }

    protected function setSearchKey(){
        $this->_searchKey = strtolower($this->_request->search);
    }

    protected function setSort(){
        $this->_sortData = $this->_request->sort['data'] ?? $this->_sortData;
        $this->_sortDirection = $this->_request->sort['direction'] ?? $this->_sortDirection;
    }

    protected function search(){
        $this->_builder->where(function($query){
            foreach($this->_columns as $column){
                $this->_searchAll($query,$column);
                $this->_searchColumn($column);
            }
        });
    }

    protected function _searchAll($query,$column){
        if($this->_searchKey && $column['searchable']){
            $colData = DB::raw("lower(CAST(".$column['data']." as ".$this->_searchCast."))");
            $colRelation = $column['relation'];

            if($colRelation){
                $query->orWhereHas(
                    $colRelation,
                    function($query) use($colData){
                        $query->where($colData, 'like', '%'.$this->_searchKey.'%');
                    }
                );
            }else{
                if($this->_hasAlias){
                    $colData = DB::raw("lower(CAST(".$this->getAlias($column['data'])." as ".$this->_searchCast."))");
                    $this->_builder->orHaving($colData, 'like', '%'.$this->_searchKey.'%');
                }else{
                    $query->orWhere($colData, 'like', '%'.$this->_searchKey.'%');
                }
            }
        }
    }

    protected function _searchColumn($column){
        if($column['search']){
            $colData = DB::raw("lower(CAST(".$column['data']." as ".$this->_searchCast."))");
            $colRelation = $column['relation'];
            $colSearch = $column['search'];

            if($colRelation){
                $this->_builder->whereHas(
                    $colRelation,
                    function($query) use($colData, $colSearch){
                        $query->where($colData, 'like', '%'.$colSearch.'%');
                    }
                );
            }else{
                if($this->_hasAlias){
                    $colData = DB::raw("lower(CAST(".$this->getAlias($column['data'])." as ".$this->_searchCast."))");
                    $this->_builder->having($colData, 'like', '%'.$colSearch.'%');
                }else{
                    $this->_builder->where($colData, 'like', '%'.$colSearch.'%');
                }
            }
        }
    }

    protected function sort(){
        if($this->_sortData !== null){
            $column = $this->_columns[$this->_sortData];

            if($column['relation']){
                $columnRelations = explode('.',$column['relation']);
                if(count($columnRelations) > 1){
                    $this->multipleRelationSort($column);
                }else{
                    $relation = $this->_builder->getRelation($column['relation']);
                    if($relation instanceof BelongsTo) $this->belongsToSort($column, $relation);
                }
            }else{
                $sortBy = $column['data'];
                $sortDirection = $this->_sortDirection;

                $this->_builder->orderBy($sortBy,$sortDirection);
            }
        }
    }

    protected function belongsToSort($column, $relation){
        $relationTable = $relation->getModel()->getTable();
        $relationTableKey = $relation->getOwnerKeyName();

        $table = $this->_table;
        $tableKey = $relation->getForeignKeyName();

        $sortBy = $column['data'];
        $sortDirection = $this->_sortDirection;

        if($this->_withSelectAll){
            $this->_builder->selectRaw("$table.*");
        }

        $this
            ->_builder
            ->leftJoin(
                $relationTable,
                "$relationTable.$relationTableKey",
                "$table.$tableKey"
            )
            ->orderBy($sortBy,$sortDirection);
    }

    protected function multipleRelationSort($column){
        $relation = $this->_builder;

        $columnRelations = explode(".", $column['relation']);
        foreach($columnRelations as $columnRelation){

            $parent = $relation;
            $relation = $relation->getRelation($columnRelation);

            $relationTable = $relation->getModel()->getTable();
            $relationTableKey = $relation->getOwnerKeyName();

            $table = $parent->getModel()->getTable();
            $tableKey = $relation->getForeignKeyName();

            if($this->_withSelectAll){
                $this->_builder->selectRaw("$relation.*");
            }

            $this
                ->_builder
                ->leftJoin(
                    $relationTable,
                    "$relationTable.$relationTableKey",
                    "$table.$tableKey"
                );
        }

        $sortBy = $column['data'];
        $sortDirection = $this->_sortDirection;
        $this->_builder->orderBy($sortBy,$sortDirection);
    }

    protected function belongsToManySort($column, $relation){}
    protected function hasOneSort($column, $relation){}
    protected function hasManySort($column,$relation){}

    protected function multipleRelationJoin($column){
        $relation = $this->_builder;

        $columnRelations = explode(".", $column['relation']);
        foreach($columnRelations as $columnRelation){

            $parent = $relation;
            $relation = $relation->getRelation($columnRelation);

            $relationTable = $relation->getModel()->getTable();
            $relationTableKey = $relation->getOwnerKeyName();

            $table = $parent->getModel()->getTable();
            $tableKey = $relation->getForeignKeyName();

            if($this->_withSelectAll){
                $this->_builder->selectRaw("$relationTable.*");
            }else{
                $this->_builder->addSelect([
                    DB::raw("$relationTable.$relationTableKey"),
                ]);
            }

            $this
                ->_builder
                ->leftJoin(
                    $relationTable,
                    "$relationTable.$relationTableKey",
                    "$table.$tableKey"
                );
        }
    }

    protected function hasAlias(){
        $sql = $this->_builder->toSql();
        $selectSql = $this->substr_between($sql, 'select','from');
        $this->_hasAlias = strpos($selectSql, 'as');
    }

    protected function getAlias($columnName){
        $alias = $columnName;
        return $alias; //

        $sql = $this->_builder->toSql();
        if(strpos($sql, 'as '.$columnName)){
            $selectString = $this->substr_between($sql, 'select','from');
            $selectArray = explode(', ',$selectString);
            $column = collect($selectArray)
                ->filter(function($value) use($columnName){
                    return strpos($value, $columnName);
                })
                ->first();

            $alias = str_replace('as '.$columnName, '', $column);
        }

        return $alias;
    }

    protected function substr_between($string, $start, $end, $last=true){
        $pos_string = stripos($string, $start);
        $substr_data = substr($string, $pos_string);
        $string_two = substr($substr_data, strlen($start));
        $second_pos = $last ? strripos($string_two, $end) : stripos($string_two, $end);
        $string_three = substr($string_two, 0, $second_pos);
        // remove whitespaces from result
        $result_unit = trim($string_three);
        // return result_unit
        return $result_unit;
    }

    protected function paginate(){
        return $this->_builder->paginate($this->_limit);
    }

}

trait Datatable{
    public static function scopeDatatable($query, Request $request, bool $withSelectAll=true){
        return DatatableFactory::eloquent($query, $request, $withSelectAll);
    }

    public static function scopeGetOrDatatable($query, Request $request, bool $withSelectAll=true){
        if($request->limit){
            return DatatableFactory::eloquent($query, $request, $withSelectAll);
        }else{
            return $query->get();
        }
    }
}
