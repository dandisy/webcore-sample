<?php

namespace App\Repositories;

use App\Models\DataColumn;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class DataColumnRepository
 * @package App\Repositories
 * @version March 12, 2018, 8:15 pm UTC
 *
 * @method DataColumn findWithoutFail($id, $columns = ['*'])
 * @method DataColumn find($id, $columns = ['*'])
 * @method DataColumn first($columns = ['*'])
*/
class DataColumnRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'data_source_id',
        'name',
        'alias',
        'edit',
        'filter',
        'un_search',
        'html',
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
        return DataColumn::class;
    }
}
