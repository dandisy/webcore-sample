<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\DataQueryDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateDataQueryRequest;
use App\Http\Requests\Admin\UpdateDataQueryRequest;
use App\Repositories\DataQueryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class DataQueryController extends AppBaseController
{
    /** @var  DataQueryRepository */
    private $dataQueryRepository;

    public function __construct(DataQueryRepository $dataQueryRepo)
    {
        $this->middleware('auth');
        $this->dataQueryRepository = $dataQueryRepo;
    }

    /**
     * Display a listing of the DataQuery.
     *
     * @param DataQueryDataTable $dataQueryDataTable
     * @return Response
     */
    public function index(DataQueryDataTable $dataQueryDataTable)
    {
        return $dataQueryDataTable->render('admin.data_queries.index');
    }

    /**
     * Show the form for creating a new DataQuery.
     *
     * @return Response
     */
    public function create()
    {
        // add by dandisy
        $datasource = \App\Models\DataSource::all();
        $dataquery = \App\Models\DataQuery::all();
        

        // edit by dandisy
        //return view('admin.data_queries.create');
        return view('admin.data_queries.create')
            ->with('datasource', $datasource)
            ->with('dataquery', $dataquery);
    }

    /**
     * Store a newly created DataQuery in storage.
     *
     * @param CreateDataQueryRequest $request
     *
     * @return Response
     */
    public function store(CreateDataQueryRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $dataQuery = $this->dataQueryRepository->create($input);

        Flash::success('Data Query saved successfully.');

        return redirect(route('admin.dataQueries.index'));
    }

    /**
     * Display the specified DataQuery.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            Flash::error('Data Query not found');

            return redirect(route('admin.dataQueries.index'));
        }

        return view('admin.data_queries.show')->with('dataQuery', $dataQuery);
    }

    /**
     * Show the form for editing the specified DataQuery.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // add by dandisy
        $datasource = \App\Models\DataSource::all();
        $dataquery = \App\Models\DataQuery::all();
        

        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            Flash::error('Data Query not found');

            return redirect(route('admin.dataQueries.index'));
        }

        // edit by dandisy
        //return view('admin.data_queries.edit')->with('dataQuery', $dataQuery);
        return view('admin.data_queries.edit')
            ->with('dataQuery', $dataQuery)
            ->with('datasource', $datasource)
            ->with('dataquery', $dataquery);
    }

    /**
     * Update the specified DataQuery in storage.
     *
     * @param  int              $id
     * @param UpdateDataQueryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataQueryRequest $request)
    {
        $input = $request->all();

        $input['updated_by'] = Auth::user()->id;

        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            Flash::error('Data Query not found');

            return redirect(route('admin.dataQueries.index'));
        }

        $dataQuery = $this->dataQueryRepository->update($input, $id);

        Flash::success('Data Query updated successfully.');

        return redirect(route('admin.dataQueries.index'));
    }

    /**
     * Remove the specified DataQuery from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dataQuery = $this->dataQueryRepository->findWithoutFail($id);

        if (empty($dataQuery)) {
            Flash::error('Data Query not found');

            return redirect(route('admin.dataQueries.index'));
        }

        $this->dataQueryRepository->delete($id);

        Flash::success('Data Query deleted successfully.');

        return redirect(route('admin.dataQueries.index'));
    }
}
