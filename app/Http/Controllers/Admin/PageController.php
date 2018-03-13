<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PageDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreatePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Repositories\PageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class PageController extends AppBaseController
{
    /** @var  PageRepository */
    private $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->middleware('auth');
        $this->pageRepository = $pageRepo;
    }

    /**
     * Display a listing of the Page.
     *
     * @param PageDataTable $pageDataTable
     * @return Response
     */
    public function index(PageDataTable $pageDataTable)
    {
        return $pageDataTable->render('admin.pages.index');
    }

    /**
     * Show the form for creating a new Page.
     *
     * @return Response
     */
    public function create()
    {
        // add by dandisy
        $presentation = \App\Models\Presentation::all();
        
$themes = array_map(function ($file) {
            $fileName = explode('.', $file);
            if(count($fileName) > 0) {
                return $fileName[0];
            }
        }, Storage::disk('theme')->allFiles());

        $themes = array_combine($themes, $themes);

        // edit by dandisy
        //return view('admin.pages.create');
        return view('admin.pages.create')
            ->with('presentation', $presentation)
            ->with('themes', $themes);
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param CreatePageRequest $request
     *
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $page = $this->pageRepository->create($input);

        Flash::success('Page saved successfully.');

        return redirect(route('admin.pages.index'));
    }

    /**
     * Display the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        return view('admin.pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the specified Page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // add by dandisy
        $presentation = \App\Models\Presentation::all();
        
$themes = array_map(function ($file) {
            $fileName = explode('.', $file);
            if(count($fileName) > 0) {
                return $fileName[0];
            }
        }, Storage::disk('theme')->allFiles());

        $themes = array_combine($themes, $themes);

        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        // edit by dandisy
        //return view('admin.pages.edit')->with('page', $page);
        return view('admin.pages.edit')
            ->with('page', $page)
            ->with('presentation', $presentation)
            ->with('themes', $themes);
    }

    /**
     * Update the specified Page in storage.
     *
     * @param  int              $id
     * @param UpdatePageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePageRequest $request)
    {
        $input = $request->all();

        $input['updated_by'] = Auth::user()->id;

        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        $page = $this->pageRepository->update($input, $id);

        Flash::success('Page updated successfully.');

        return redirect(route('admin.pages.index'));
    }

    /**
     * Remove the specified Page from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('Page not found');

            return redirect(route('admin.pages.index'));
        }

        $this->pageRepository->delete($id);

        Flash::success('Page deleted successfully.');

        return redirect(route('admin.pages.index'));
    }
}
