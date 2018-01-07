<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Presentation",
 *      required={"component", "position", "page_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="component",
 *          description="component",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="datasource",
 *          description="datasource",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="order",
 *          description="order",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="page_id",
 *          description="page_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_by",
 *          description="created_by",
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
class Presentation extends Model
{
    use SoftDeletes;

    public $table = 'presentations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'component',
        'position',
        'datasource',
        'order',
        'page_id',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'component' => 'string',
        'position' => 'string',
        'datasource' => 'string',
        'order' => 'integer',
        'page_id' => 'integer',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'component' => 'required',
        'position' => 'required',
        'page_id' => 'required'
    ];

    
}
