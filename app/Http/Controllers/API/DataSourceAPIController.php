<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataSourceAPIRequest;
use App\Http\Requests\API\UpdateDataSourceAPIRequest;
use App\Models\DataSource;
use App\Repositories\DataSourceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DataSourceController
 * @package App\Http\Controllers\API
 */

class DataSourceAPIController extends AppBaseController
{
    /** @var  DataSourceRepository */
    private $dataSourceRepository;

    public function __construct(DataSourceRepository $dataSourceRepo)
    {
        $this->middleware('auth:api');
        $this->dataSourceRepository = $dataSourceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataSources",
     *      summary="Get a listing of the DataSources.",
     *      tags={"DataSource"},
     *      description="Get all DataSources",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/DataSource")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->dataSourceRepository->pushCriteria(new RequestCriteria($request));
        $this->dataSourceRepository->pushCriteria(new LimitOffsetCriteria($request));
        $dataSources = $this->dataSourceRepository->all();

        return $this->sendResponse($dataSources->toArray(), 'Data Sources retrieved successfully');
    }

    /**
     * @param CreateDataSourceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/dataSources",
     *      summary="Store a newly created DataSource in storage",
     *      tags={"DataSource"},
     *      description="Store DataSource",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataSource that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataSource")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DataSource"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDataSourceAPIRequest $request)
    {
        $input = $request->all();

        $dataSources = $this->dataSourceRepository->create($input);

        return $this->sendResponse($dataSources->toArray(), 'Data Source saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataSources/{id}",
     *      summary="Display the specified DataSource",
     *      tags={"DataSource"},
     *      description="Get DataSource",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataSource",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DataSource"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var DataSource $dataSource */
        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            return $this->sendError('Data Source not found');
        }

        return $this->sendResponse($dataSource->toArray(), 'Data Source retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDataSourceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/dataSources/{id}",
     *      summary="Update the specified DataSource in storage",
     *      tags={"DataSource"},
     *      description="Update DataSource",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataSource",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataSource that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataSource")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/DataSource"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDataSourceAPIRequest $request)
    {
        $input = $request->all();

        /** @var DataSource $dataSource */
        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            return $this->sendError('Data Source not found');
        }

        $dataSource = $this->dataSourceRepository->update($input, $id);

        return $this->sendResponse($dataSource->toArray(), 'DataSource updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/dataSources/{id}",
     *      summary="Remove the specified DataSource from storage",
     *      tags={"DataSource"},
     *      description="Delete DataSource",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataSource",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var DataSource $dataSource */
        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            return $this->sendError('Data Source not found');
        }

        $dataSource->delete();

        return $this->sendResponse($id, 'Data Source deleted successfully');
    }
}
