<?php

namespace App\Repositories;

use App\Models\Banner;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class BannerRepository
 * @package App\Repositories
 * @version January 4, 2018, 3:33 am UTC
 *
 * @method Banner findWithoutFail($id, $columns = ['*'])
 * @method Banner find($id, $columns = ['*'])
 * @method Banner first($columns = ['*'])
*/
class BannerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'title',
        'description',
        'link',
        'tag',
        'version',
        'language',
        'status',
        'created_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Banner::class;
    }
}
