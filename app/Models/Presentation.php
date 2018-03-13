<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Presentation",
 *      required={"page_id", "media", "component_id", "position"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
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
 *          property="media",
 *          description="media",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="component_id",
 *          description="component_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="position",
 *          description="position",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="order",
 *          description="order",
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
class Presentation extends Model
{
    use SoftDeletes;

    public $table = 'presentations';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'page_id',
        'media',
        'component_id',
        'position',
        'order',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'page_id' => 'integer',
        'media' => 'string',
        'component_id' => 'string',
        'position' => 'string',
        'order' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'page_id' => 'required',
        'media' => 'required',
        'component_id' => 'required',
        'position' => 'required'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function page()
    {
        return $this->belongsTo(\App\Models\Page::class, 'page_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function component()
    {
        return $this->belongsTo(\App\Models\Component::class, 'component_id', 'id');
    }
}
