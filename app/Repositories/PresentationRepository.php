<?php

namespace App\Repositories;

use App\Models\Presentation;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class PresentationRepository
 * @package App\Repositories
 * @version March 12, 2018, 8:13 pm UTC
 *
 * @method Presentation findWithoutFail($id, $columns = ['*'])
 * @method Presentation find($id, $columns = ['*'])
 * @method Presentation first($columns = ['*'])
*/
class PresentationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'page_id',
        'media',
        'component_id',
        'position',
        'order',
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
        return Presentation::class;
    }
}
