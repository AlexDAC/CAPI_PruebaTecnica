<?php

namespace App\Helpers;

use Error;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\QuerySortException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use PDOException;
use Throwable;

class QueryHelper
{
    /**
     * Extract and clean searchBy, sortBy, filters, and sortOrder from a request
     *
     * @param  Request $request
     * 
     * @return array ['searchBy', 'sortBy', 'sortOrder', 'pageSize']
     */
    public static function extractQueryFiltersFromRequest(Request $request)
    {
        $queryFilters = [
            'searchBy' =>  self::extractSearchBy($request->searchBy),
            'sortBy' => self::extractSortBy($request->sortBy),
            'sortOrder' => self::extractSortOrderBy($request->sortOrder),
            'pageSize' => self::extractPageSize($request->pageSize),
        ];

        return $queryFilters;
    }

    /**
     * Adds search functionality for columns of the same model to a query
     * Searches joined by OR operator (searchKeyword would check any given column) and 'LIKE' is used for filtering
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query to add filters to
     * @param string $searchKeyword
     * @param array $searchColumns Local columns to search for
     * @param array $relationSearchColumns Relationship columns to search for. Format is [relation => column] or [relation => [column1, column2]]
     * 
     * @return \Illuminate\Database\Eloquent\Builder Query with applied filters
     */
    public static function querySearch($query, $searchKeyword, $searchColumns = [], $relationSearchColumns = [])
    {
        if ($searchKeyword == '' || (count($searchColumns) == 0 && count($relationSearchColumns) == 0)) {
            return $query;
        }

        $query->where(function ($query) use ($searchKeyword, $searchColumns, $relationSearchColumns) {
            if (count($searchColumns) > 0) {
                $query = self::addSearchColumnsToQuery($query, $searchColumns, $searchKeyword);
            } else {
                $query = self::addRelationSearchColumnsToQuery($query, $relationSearchColumns, $searchKeyword);
            }
            
            $query = self::addTheRestOfWhereRelationForSearchColumns($query, $searchColumns, $searchKeyword);
            $query = self::addTheRestOfWhereRelationForRelationSearchColumns($query, $relationSearchColumns, $searchKeyword);
        });

        return $query;
    }

    /**
     * Add sorting filters to a query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query to add sort filters to
     * @param string $sortColumn Column to sort by. Could be a key when searching for another table's column
     * @param string $sortOrder Order of the sort
     * @param string $localTableName Name of the table. Used in case we need sort by other table's columns
     * @param array $sortableRelations (optional) Used when sorting by other table's columns. Format is [sortColumnKey => [external table, sort column, local column for join, external column for join]]
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function querySort($query, $sortColumn, $sortOrder, $localTableName, $sortableRelations = [])
    {
        if ($sortOrder == '' || $sortColumn == '' || $localTableName == '') {
            return $query;
        }

        if (!Schema::hasColumn($localTableName, $sortColumn) && !array_key_exists($sortColumn, $sortableRelations)) {
            throw new QuerySortException(Lang::get('general_response_messages.sort_error'));
        }

        if (isset($sortableRelations[$sortColumn])) {
            $relationship = $sortableRelations[$sortColumn];

            $parameterCount = count($relationship);

            $foreignTableName = $relationship[0];
            $foreignSortColumn = $relationship[1];
            $localJoinColumn = $parameterCount > 2 ? $relationship[2] : substr($foreignTableName, 0, -1) . '_id';
            $foreignJoinColumn = $parameterCount > 3 ? $relationship[3] : 'id';

            $query->leftJoin($foreignTableName, $localTableName . '.' . $localJoinColumn, '=', $foreignTableName . '.' . $foreignJoinColumn);
            $query->orderBy($foreignTableName . '.' . $foreignSortColumn, $sortOrder);
            $query->select($localTableName . '.*');
        } else {
            $query->orderBy($sortColumn, $sortOrder);
        }

        return $query;
    }

    /**
     * extract and clean searchBy filter
     *
     * @param string $searchBy 
     * 
     * @return string $searchBy
    */
    private static function extractSearchBy(mixed $searchBy)
    {
        return isset($searchBy) ? trim($searchBy) : '';
    }

    /**
     * extract and clean sortBy filter
     * 
     * @param string $sortBy 
     * 
     * @return string $sortBy
     */
    private static function extractSortBy(mixed $sortBy)
    {
        return isset($sortBy) ? $sortBy : '';
    }
    
    /**
     * extract and clean sortOrderBy filter
     *
     * @param string $sortOrder
     * 
     * @return string $sortOrderBy
     */
    private static function extractSortOrderBy(mixed $sortOrder)
    {
        if (!isset($sortOrder)) {
            return '';
        }

        return $sortOrder == 'descending' ? 'desc' : 'asc';
    }

    /**
     * extract and clean page size
     *
     * @param string  $pageSize
     * @return int|null $pageSize
     *
     * @author @AlexDAC
     */
    private static function extractPageSize(mixed $pageSize)
    {
        if(!isset($pageSize)){
            return null;
        }

        return intval($pageSize) > 0 ? intval($pageSize) : null;
    }
    
    /**
     * add search columns to the query
     *
     * @param   mixed   $query                  
     * @param   array   $searchColumns  
     * @param   string  $searchKeyword          
     *
     * @return  mixed $query
     */
    private static function addSearchColumnsToQuery(mixed $query, array &$searchColumns, string $searchKeyword)
    {
        $query->where($searchColumns[0], 'LIKE', '%' . $searchKeyword . '%');
        array_shift($searchColumns);

        return $query;
    }

    /**
     * add relation search columns to the query
     *
     * @param   mixed   $query                  
     * @param   array   $relationSearchColumns  
     * @param   string  $searchKeyword          
     *
     * @return  mixed $query
     */
    private static function addRelationSearchColumnsToQuery(mixed $query, array &$relationSearchColumns, string $searchKeyword)
    {
        $relationKey = array_keys($relationSearchColumns)[0];

        if (is_array($relationSearchColumns[$relationKey])) {
            $query->whereRelation($relationKey, $relationSearchColumns[$relationKey][0], 'LIKE', '%' . $searchKeyword . '%');
            for ($i = 1; $i < count($relationSearchColumns[$relationKey]); $i++) {
                $query->orWhereRelation($relationSearchColumns[$relationKey][$i], 'LIKE', '%' . $searchKeyword . '%');
            }
        } else {
            $query->whereRelation($relationKey, $relationSearchColumns[$relationKey], 'LIKE', '%' . $searchKeyword . '%');
        }
        array_shift($relationSearchColumns);

        return $query;
    }

    /**
     * add the rest of the relations of the search columns to the query
     *
     * @param   mixed   $query                  
     * @param   array   $searchColumns  
     * @param   string  $searchKeyword          
     *
     * @return  mixed $query
     */
    private static function addTheRestOfWhereRelationForSearchColumns(mixed $query, array $searchColumns, string $searchKeyword)
    {
        
        for ($i = 0; $i < count($searchColumns); $i++) {
            $query->orWhere($searchColumns[$i], 'LIKE', '%' . $searchKeyword . '%');
        }
        return $query;
    }

    /**
     * add the rest of the relations of the relation search columns to the query
     *
     * @param   mixed   $query                  
     * @param   array   $relationSearchColumns  
     * @param   string  $searchKeyword          
     *
     * @return  mixed $query
     */
    private static function addTheRestOfWhereRelationForRelationSearchColumns(mixed $query, array $relationSearchColumns, string $searchKeyword)
    {
        
        foreach ($relationSearchColumns as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $col) {
                    $query->orWhereRelation($key, $col, 'LIKE', '%' . $searchKeyword . '%');
                }
            } else {
                $query->orWhereRelation($key, $value, 'LIKE', '%' . $searchKeyword . '%');
            }
        }

        return $query;
    }

}
