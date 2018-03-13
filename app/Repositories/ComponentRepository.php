<?php

namespace App\Repositories;

use App\Models\Component;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class ComponentRepository
 * @package App\Repositories
 * @version March 12, 2018, 8:14 pm UTC
 *
 * @method Component findWithoutFail($id, $columns = ['*'])
 * @method Component find($id, $columns = ['*'])
 * @method Component first($columns = ['*'])
*/
class ComponentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'view',
        'source',
        'data_source_id',
        'data',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Component::class;
    }
}
