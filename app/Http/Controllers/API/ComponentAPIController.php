<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComponentAPIRequest;
use App\Http\Requests\API\UpdateComponentAPIRequest;
use App\Models\Component;
use App\Repositories\ComponentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ComponentController
 * @package App\Http\Controllers\API
 */

class ComponentAPIController extends AppBaseController
{
    /** @var  ComponentRepository */
    private $componentRepository;

    public function __construct(ComponentRepository $componentRepo)
    {
        $this->middleware('auth:api');
        $this->componentRepository = $componentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/components",
     *      summary="Get a listing of the Components.",
     *      tags={"Component"},
     *      description="Get all Components",
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
     *                  @SWG\Items(ref="#/definitions/Component")
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
        $this->componentRepository->pushCriteria(new RequestCriteria($request));
        $this->componentRepository->pushCriteria(new LimitOffsetCriteria($request));
        $components = $this->componentRepository->all();

        return $this->sendResponse($components->toArray(), 'Components retrieved successfully');
    }

    /**
     * @param CreateComponentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/components",
     *      summary="Store a newly created Component in storage",
     *      tags={"Component"},
     *      description="Store Component",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Component that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Component")
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
     *                  ref="#/definitions/Component"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateComponentAPIRequest $request)
    {
        $input = $request->all();

        $components = $this->componentRepository->create($input);

        return $this->sendResponse($components->toArray(), 'Component saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/components/{id}",
     *      summary="Display the specified Component",
     *      tags={"Component"},
     *      description="Get Component",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Component",
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
     *                  ref="#/definitions/Component"
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
        /** @var Component $component */
        $component = $this->componentRepository->findWithoutFail($id);

        if (empty($component)) {
            return $this->sendError('Component not found');
        }

        return $this->sendResponse($component->toArray(), 'Component retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateComponentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/components/{id}",
     *      summary="Update the specified Component in storage",
     *      tags={"Component"},
     *      description="Update Component",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Component",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Component that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Component")
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
     *                  ref="#/definitions/Component"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateComponentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Component $component */
        $component = $this->componentRepository->findWithoutFail($id);

        if (empty($component)) {
            return $this->sendError('Component not found');
        }

        $component = $this->componentRepository->update($input, $id);

        return $this->sendResponse($component->toArray(), 'Component updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/components/{id}",
     *      summary="Remove the specified Component from storage",
     *      tags={"Component"},
     *      description="Delete Component",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Component",
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
        /** @var Component $component */
        $component = $this->componentRepository->findWithoutFail($id);

        if (empty($component)) {
            return $this->sendError('Component not found');
        }

        $component->delete();

        return $this->sendResponse($id, 'Component deleted successfully');
    }
}
