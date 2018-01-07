<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePageAPIRequest;
use App\Http\Requests\API\UpdatePageAPIRequest;
use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Webcore\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PageController
 * @package App\Http\Controllers\API
 */

class PageAPIController extends AppBaseController
{
    /** @var  PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->middleware('auth:api');
        $this->pageRepository = $pageRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages",
     *      summary="Get a listing of the Pages.",
     *      tags={"Page"},
     *      description="Get all Pages",
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
     *                  @SWG\Items(ref="#/definitions/Page")
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
        $this->pageRepository->pushCriteria(new RequestCriteria($request));
        $this->pageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pages = $this->pageRepository->all();

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * @param CreatePageAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/pages",
     *      summary="Store a newly created Page in storage",
     *      tags={"Page"},
     *      description="Store Page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Page that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Page")
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
     *                  ref="#/definitions/Page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePageAPIRequest $request)
    {
        $input = $request->all();

        $pages = $this->pageRepository->create($input);

        return $this->sendResponse($pages->toArray(), 'Page saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages/{id}",
     *      summary="Display the specified Page",
     *      tags={"Page"},
     *      description="Get Page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Page",
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
     *                  ref="#/definitions/Page"
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
        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        return $this->sendResponse($page->toArray(), 'Page retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePageAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/pages/{id}",
     *      summary="Update the specified Page in storage",
     *      tags={"Page"},
     *      description="Update Page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Page",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Page that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Page")
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
     *                  ref="#/definitions/Page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page = $this->pageRepository->update($input, $id);

        return $this->sendResponse($page->toArray(), 'Page updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/pages/{id}",
     *      summary="Remove the specified Page from storage",
     *      tags={"Page"},
     *      description="Delete Page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Page",
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
        /** @var Page $page */
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page->delete();

        return $this->sendResponse($id, 'Page deleted successfully');
    }
}
