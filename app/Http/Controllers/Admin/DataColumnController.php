<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\DataColumnDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateDataColumnRequest;
use App\Http\Requests\Admin\UpdateDataColumnRequest;
use App\Repositories\DataColumnRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class DataColumnController extends AppBaseController
{
    /** @var  DataColumnRepository */
    private $dataColumnRepository;

    public function __construct(DataColumnRepository $dataColumnRepo)
    {
        $this->middleware('auth');
        $this->dataColumnRepository = $dataColumnRepo;
    }

    /**
     * Display a listing of the DataColumn.
     *
     * @param DataColumnDataTable $dataColumnDataTable
     * @return Response
     */
    public function index(DataColumnDataTable $dataColumnDataTable)
    {
        return $dataColumnDataTable->render('admin.data_columns.index');
    }

    /**
     * Show the form for creating a new DataColumn.
     *
     * @return Response
     */
    public function create()
    {
        // add by dandisy
        $datasource = \App\Models\DataSource::all();
        

        // edit by dandisy
        //return view('admin.data_columns.create');
        return view('admin.data_columns.create')
            ->with('datasource', $datasource);
    }

    /**
     * Store a newly created DataColumn in storage.
     *
     * @param CreateDataColumnRequest $request
     *
     * @return Response
     */
    public function store(CreateDataColumnRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->id;

        $dataColumn = $this->dataColumnRepository->create($input);

        Flash::success('Data Column saved successfully.');

        return redirect(route('admin.dataColumns.index'));
    }

    /**
     * Display the specified DataColumn.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            Flash::error('Data Column not found');

            return redirect(route('admin.dataColumns.index'));
        }

        return view('admin.data_columns.show')->with('dataColumn', $dataColumn);
    }

    /**
     * Show the form for editing the specified DataColumn.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        // add by dandisy
        $datasource = \App\Models\DataSource::all();
        

        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            Flash::error('Data Column not found');

            return redirect(route('admin.dataColumns.index'));
        }

        // edit by dandisy
        //return view('admin.data_columns.edit')->with('dataColumn', $dataColumn);
        return view('admin.data_columns.edit')
            ->with('dataColumn', $dataColumn)
            ->with('datasource', $datasource);
    }

    /**
     * Update the specified DataColumn in storage.
     *
     * @param  int              $id
     * @param UpdateDataColumnRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataColumnRequest $request)
    {
        $input = $request->all();

        $input['updated_by'] = Auth::user()->id;

        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            Flash::error('Data Column not found');

            return redirect(route('admin.dataColumns.index'));
        }

        $dataColumn = $this->dataColumnRepository->update($input, $id);

        Flash::success('Data Column updated successfully.');

        return redirect(route('admin.dataColumns.index'));
    }

    /**
     * Remove the specified DataColumn from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dataColumn = $this->dataColumnRepository->findWithoutFail($id);

        if (empty($dataColumn)) {
            Flash::error('Data Column not found');

            return redirect(route('admin.dataColumns.index'));
        }

        $this->dataColumnRepository->delete($id);

        Flash::success('Data Column deleted successfully.');

        return redirect(route('admin.dataColumns.index'));
    }
}
