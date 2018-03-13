<?php

namespace App\Repositories;

use App\Models\DataSource;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class DataSourceRepository
 * @package App\Repositories
 * @version March 12, 2018, 8:14 pm UTC
 *
 * @method DataSource findWithoutFail($id, $columns = ['*'])
 * @method DataSource find($id, $columns = ['*'])
 * @method DataSource first($columns = ['*'])
*/
class DataSourceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'model',
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
        return DataSource::class;
    }
}
