<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataQueryAPIRequest;
use App\Http\Requests\API\UpdateDataQueryAPIRequest;
use App\Models\DataQuery;
use App\Repositories\DataQueryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DataQueryController
 * @package App\Http\Controllers\API
 */

class DataQueryAPIController extends AppBaseController
{
    /** @var  DataQueryRepository */
    private $dataQueryRepository;

    public function __construct(DataQueryRepository $dataQueryRepo)
    {
        $this->middleware('auth:api');
        $this->dataQueryRepository = $dataQueryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataQueries",
     *      summary="Get a listing of the DataQueries.",
     *      tags={"DataQuery"},
     *      description="Get all DataQueries",
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
     *                  @SWG\Items(ref="#/definitions/DataQuery")
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
        $this->dataQueryRepository->pushCriteria(new RequestCriteria($request));
        $this->dataQueryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $dataQueries = $this->dataQueryRepository->all();

        return $this->sendResponse($dataQueries->toArray(), 'Data Queries retrieved successfully');
    }

    /**
     * @param CreateDataQueryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/dataQueries",
     *      summary="Store a newly created DataQuery in storage",
     *      tags={"DataQuery"},
     *      description="Store DataQuery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataQuery that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataQuery")
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
     *                  ref="#/definitions/DataQuery"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDataQueryAPIRequest $request)
    {
        $input = $request->all();

        $dataQueries = $this->dataQueryRepository->create($input);

        return $this->sendResponse($dataQueries->toArray(), 'Data Query saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataQueries/{id}",
     *      summary="Display the specified DataQuery",
     *      tags={"DataQuery"},
     *      description="Get DataQuery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataQuery",
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
     *                  ref="#/definitions/DataQuery"
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
        /** @var DataQuery $dataQuery */
        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            return $this->sendError('Data Query not found');
        }

        return $this->sendResponse($dataQuery->toArray(), 'Data Query retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDataQueryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/dataQueries/{id}",
     *      summary="Update the specified DataQuery in storage",
     *      tags={"DataQuery"},
     *      description="Update DataQuery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataQuery",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataQuery that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataQuery")
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
     *                  ref="#/definitions/DataQuery"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDataQueryAPIRequest $request)
    {
        $input = $request->all();

        /** @var DataQuery $dataQuery */
        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            return $this->sendError('Data Query not found');
        }

        $dataQuery = $this->dataQueryRepository->update($input, $id);

        return $this->sendResponse($dataQuery->toArray(), 'DataQuery updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/dataQueries/{id}",
     *      summary="Remove the specified DataQuery from storage",
     *      tags={"DataQuery"},
     *      description="Delete DataQuery",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataQuery",
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
        /** @var DataQuery $dataQuery */
        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            return $this->sendError('Data Query not found');
        }

        $dataQuery->delete();

        return $this->sendResponse($id, 'Data Query deleted successfully');
    }
}
