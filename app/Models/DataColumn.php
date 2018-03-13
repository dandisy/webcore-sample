<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="DataColumn",
 *      required={"data_source_id", "name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="data_source_id",
 *          description="data_source_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="alias",
 *          description="alias",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="edit",
 *          description="edit",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="filter",
 *          description="filter",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="un_search",
 *          description="un_search",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="html",
 *          description="html",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_by",
 *          description="created_by",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="updated_by",
 *          description="updated_by",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class DataColumn extends Model
{
    use SoftDeletes;

    public $table = 'data_columns';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'data_source_id',
        'name',
        'alias',
        'edit',
        'filter',
        'un_search',
        'html',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'data_source_id' => 'integer',
        'name' => 'string',
        'alias' => 'string',
        'edit' => 'string',
        'filter' => 'string',
        'un_search' => 'string',
        'html' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'data_source_id' => 'required',
        'name' => 'required'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function dataSource()
    {
        return $this->belongsTo(\App\Models\DataSource::class, 'data_source_id', 'id');
    }
}
