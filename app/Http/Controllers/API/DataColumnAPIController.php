<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDataColumnAPIRequest;
use App\Http\Requests\API\UpdateDataColumnAPIRequest;
use App\Models\DataColumn;
use App\Repositories\DataColumnRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class DataColumnController
 * @package App\Http\Controllers\API
 */

class DataColumnAPIController extends AppBaseController
{
    /** @var  DataColumnRepository */
    private $dataColumnRepository;

    public function __construct(DataColumnRepository $dataColumnRepo)
    {
        $this->middleware('auth:api');
        $this->dataColumnRepository = $dataColumnRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataColumns",
     *      summary="Get a listing of the DataColumns.",
     *      tags={"DataColumn"},
     *      description="Get all DataColumns",
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
     *                  @SWG\Items(ref="#/definitions/DataColumn")
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
        $this->dataColumnRepository->pushCriteria(new RequestCriteria($request));
        $this->dataColumnRepository->pushCriteria(new LimitOffsetCriteria($request));
        $dataColumns = $this->dataColumnRepository->all();

        return $this->sendResponse($dataColumns->toArray(), 'Data Columns retrieved successfully');
    }

    /**
     * @param CreateDataColumnAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/dataColumns",
     *      summary="Store a newly created DataColumn in storage",
     *      tags={"DataColumn"},
     *      description="Store DataColumn",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataColumn that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataColumn")
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
     *                  ref="#/definitions/DataColumn"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDataColumnAPIRequest $request)
    {
        $input = $request->all();

        $dataColumns = $this->dataColumnRepository->create($input);

        return $this->sendResponse($dataColumns->toArray(), 'Data Column saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/dataColumns/{id}",
     *      summary="Display the specified DataColumn",
     *      tags={"DataColumn"},
     *      description="Get DataColumn",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataColumn",
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
     *                  ref="#/definitions/DataColumn"
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
        /** @var DataColumn $dataColumn */
        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            return $this->sendError('Data Column not found');
        }

        return $this->sendResponse($dataColumn->toArray(), 'Data Column retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateDataColumnAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/dataColumns/{id}",
     *      summary="Update the specified DataColumn in storage",
     *      tags={"DataColumn"},
     *      description="Update DataColumn",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataColumn",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="DataColumn that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/DataColumn")
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
     *                  ref="#/definitions/DataColumn"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDataColumnAPIRequest $request)
    {
        $input = $request->all();

        /** @var DataColumn $dataColumn */
        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            return $this->sendError('Data Column not found');
        }

        $dataColumn = $this->dataColumnRepository->update($input, $id);

        return $this->sendResponse($dataColumn->toArray(), 'DataColumn updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/dataColumns/{id}",
     *      summary="Remove the specified DataColumn from storage",
     *      tags={"DataColumn"},
     *      description="Delete DataColumn",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of DataColumn",
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
        /** @var DataColumn $dataColumn */
        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            return $this->sendError('Data Column not found');
        }

        $dataColumn->delete();

        return $this->sendResponse($id, 'Data Column deleted successfully');
    }
}
