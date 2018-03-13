<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\DataSourceDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateDataSourceRequest;
use App\Http\Requests\Admin\UpdateDataSourceRequest;
use App\Repositories\DataSourceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class DataSourceController extends AppBaseController
{
    /** @var  DataSourceRepository */
    private $dataSourceRepository;

    public function __construct(DataSourceRepository $dataSourceRepo)
    {
        $this->middleware('auth');
        $this->dataSourceRepository = $dataSourceRepo;
    }

    /**
     * Display a listing of the DataSource.
     *
     * @param DataSourceDataTable $dataSourceDataTable
     * @return Response
     */
    public function index(DataSourceDataTable $dataSourceDataTable)
    {
        return $dataSourceDataTable->render('admin.data_sources.index');
    }

    /**
     * Show the form for creating a new DataSource.
     *
     * @return Response
     */
    public function create()
    {
        // add by dandisy
        $dataquery = \App\Models\DataQuery::all();
        $datacolumn = \App\Models\DataColumn::all();
        
$models = array_map(function ($file) {
            $fileName = explode('.', $file);
            if(count($fileName) > 0) {
                return $fileName[0];
            }
        }, Storage::disk('model')->allFiles());

        $models = array_combine($models, $models);

        // edit by dandisy
        //return view('admin.data_sources.create');
        return view('admin.data_sources.create')
            ->with('dataquery', $dataquery)
            ->with('datacolumn', $datacolumn)
            ->with('models', $models);
    }

    /**
     * Store a newly created DataSource in storage.
     *
     * @param CreateDataSourceRequest $request
     *
     * @return Response
     */
    public function store(CreateDataSourceRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $dataSource = $this->dataSourceRepository->create($input);

        Flash::success('Data Source saved successfully.');

        return redirect(route('admin.dataSources.index'));
    }

    /**
     * Display the specified DataSource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            Flash::error('Data Source not found');

            return redirect(route('admin.dataSources.index'));
        }

        return view('admin.data_sources.show')->with('dataSource', $dataSource);
    }

    /**
     * Show the form for editing the specified DataSource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // add by dandisy
        $dataquery = \App\Models\DataQuery::all();
        $datacolumn = \App\Models\DataColumn::all();
        
$models = array_map(function ($file) {
            $fileName = explode('.', $file);
            if(count($fileName) > 0) {
                return $fileName[0];
            }
        }, Storage::disk('model')->allFiles());

        $models = array_combine($models, $models);

        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            Flash::error('Data Source not found');

            return redirect(route('admin.dataSources.index'));
        }

        // edit by dandisy
        //return view('admin.data_sources.edit')->with('dataSource', $dataSource);
        return view('admin.data_sources.edit')
            ->with('dataSource', $dataSource)
            ->with('dataquery', $dataquery)
            ->with('datacolumn', $datacolumn)
            ->with('models', $models);
    }

    /**
     * Update the specified DataSource in storage.
     *
     * @param  int              $id
     * @param UpdateDataSourceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataSourceRequest $request)
    {
        $input = $request->all();

        $input['updated_by'] = Auth::user()->id;

        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            Flash::error('Data Source not found');

            return redirect(route('admin.dataSources.index'));
        }

        $dataSource = $this->dataSourceRepository->update($input, $id);

        Flash::success('Data Source updated successfully.');

        return redirect(route('admin.dataSources.index'));
    }

    /**
     * Remove the specified DataSource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        if (empty($dataSource)) {
            Flash::error('Data Source not found');

            return redirect(route('admin.dataSources.index'));
        }

        $this->dataSourceRepository->delete($id);

        Flash::success('Data Source deleted successfully.');

        return redirect(route('admin.dataSources.index'));
    }
}
