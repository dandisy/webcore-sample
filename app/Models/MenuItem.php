<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nestable\NestableTrait;

/**
 * @SWG\Definition(
 *      definition="MenuItem",
 *      required={"label", "link"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="label",
 *          description="label",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="link",
 *          description="link",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="parent",
 *          description="parent",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sort",
 *          description="sort",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="class",
 *          description="class",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="menu",
 *          description="menu",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="depth",
 *          description="depth",
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
class MenuItem extends Model
{
    //use SoftDeletes;
    use NestableTrait;

    protected $parent = 'parent';

    public $table = 'admin_menu_items';
    

    //protected $dates = ['deleted_at'];


    public $fillable = [
        'label',
        'link',
        'parent',
        'sort',
        'class',
        'menu',
        'depth'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'label' => 'string',
        'link' => 'string',
        'parent' => 'integer',
        'sort' => 'integer',
        'class' => 'string',
        'menu' => 'integer',
        'depth' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'label' => 'required',
        'link' => 'required'
    ];

    
}
