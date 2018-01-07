<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePresentationAPIRequest;
use App\Http\Requests\API\UpdatePresentationAPIRequest;
use App\Models\Presentation;
use App\Repositories\PresentationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PresentationController
 * @package App\Http\Controllers\API
 */

class PresentationAPIController extends AppBaseController
{
    /** @var  PresentationRepository */
    private $presentationRepository;

    public function __construct(PresentationRepository $presentationRepo)
    {
        $this->middleware('auth:api');
        $this->presentationRepository = $presentationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/presentations",
     *      summary="Get a listing of the Presentations.",
     *      tags={"Presentation"},
     *      description="Get all Presentations",
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
     *                  @SWG\Items(ref="#/definitions/Presentation")
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
        $this->presentationRepository->pushCriteria(new RequestCriteria($request));
        $this->presentationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $presentations = $this->presentationRepository->all();

        return $this->sendResponse($presentations->toArray(), 'Presentations retrieved successfully');
    }

    /**
     * @param CreatePresentationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/presentations",
     *      summary="Store a newly created Presentation in storage",
     *      tags={"Presentation"},
     *      description="Store Presentation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Presentation that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Presentation")
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
     *                  ref="#/definitions/Presentation"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePresentationAPIRequest $request)
    {
        $input = $request->all();

        $presentations = $this->presentationRepository->create($input);

        return $this->sendResponse($presentations->toArray(), 'Presentation saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/presentations/{id}",
     *      summary="Display the specified Presentation",
     *      tags={"Presentation"},
     *      description="Get Presentation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Presentation",
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
     *                  ref="#/definitions/Presentation"
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
        /** @var Presentation $presentation */
        $presentation = $this->presentationRepository->findWithoutFail($id);

        if (empty($presentation)) {
            return $this->sendError('Presentation not found');
        }

        return $this->sendResponse($presentation->toArray(), 'Presentation retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePresentationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/presentations/{id}",
     *      summary="Update the specified Presentation in storage",
     *      tags={"Presentation"},
     *      description="Update Presentation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Presentation",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Presentation that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Presentation")
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
     *                  ref="#/definitions/Presentation"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePresentationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Presentation $presentation */
        $presentation = $this->presentationRepository->findWithoutFail($id);

        if (empty($presentation)) {
            return $this->sendError('Presentation not found');
        }

        $presentation = $this->presentationRepository->update($input, $id);

        return $this->sendResponse($presentation->toArray(), 'Presentation updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/presentations/{id}",
     *      summary="Remove the specified Presentation from storage",
     *      tags={"Presentation"},
     *      description="Delete Presentation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Presentation",
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
        /** @var Presentation $presentation */
        $presentation = $this->presentationRepository->findWithoutFail($id);

        if (empty($presentation)) {
            return $this->sendError('Presentation not found');
        }

        $presentation->delete();

        return $this->sendResponse($id, 'Presentation deleted successfully');
    }
}
