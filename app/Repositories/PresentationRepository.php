<?php

namespace App\Repositories;

use App\Models\Presentation;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class PresentationRepository
 * @package App\Repositories
 * @version January 4, 2018, 3:34 am UTC
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
        'component',
        'position',
        'datasource',
        'order',
        'page_id',
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Presentation::class;
    }
}
