<?php

namespace App\Http\Controllers\Admin;

use App\Models\DataQuery;
use App\Models\DataColumn;
use App\DataTables\Admin\DataSourceDataTable;
use App\Http\Requests;
use App\Http\Requests\Admin\CreateDataSourceRequest;
use App\Http\Requests\Admin\UpdateDataSourceRequest;
use App\Repositories\DataSourceRepository;
use App\Repositories\DataQueryRepository;
use App\Repositories\DataColumnRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // add by dandisy
use Illuminate\Support\Facades\Storage; // add by dandisy

class DataSourceController extends AppBaseController
{
    /** @var  DataSourceRepository */
    private $dataSourceRepository;

    /** @var  DataQueryRepository */
    private $dataQueryRepository;

    /** @var  DataColumnRepository */
    private $dataColumnRepository;

    private $queryUpdated = [];

    public function __construct(
        DataSourceRepository $dataSourceRepo, 
        DataQueryRepository $dataQueryRepo,
        DataColumnRepository $dataColumnRepo
    )
    {
        $this->middleware('auth');
        $this->dataSourceRepository = $dataSourceRepo;
        $this->dataQueryRepository = $dataQueryRepo;
        $this->dataColumnRepository = $dataColumnRepo;
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
    public function create(/*DataQueryDataTable $dataQueryDataTable*/)
    {
        // add by dandisy
        
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
            ->with('models', $models);

        //return $dataQueryDataTable->render('admin.data_sources.create', ['models' => $models]);
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

        // handling data query
        $query = array_merge_recursive(
            $input['command'],
            array_key_exists('column', $input) ? $input['column'] : [],
            array_key_exists('columnOrder', $input) ? $input['columnOrder'] : [],
            array_key_exists('operator', $input) ? $input['operator'] : [], 
            array_key_exists('value', $input) ? $input['value'] : []
        );


        unset($input['command']);
        if(array_key_exists('column', $input)) {
            unset($input['column']);
        }
        if(array_key_exists('columnOrder', $input)) {
            unset($input['columnOrder']);
        }
        if(array_key_exists('operator', $input)) {
            unset($input['operator']);
        }
        if(array_key_exists('value', $input)) {
            unset($input['value']);
        }
        // end handling data query

        // get data columns
        $alias = NULL;
        if(isset($input['alias'])) {
            $alias = $input['alias'];

            unset($input['alias']);
        }

        $input['created_by'] = Auth::user()->id;

        $dataSource = $this->dataSourceRepository->create($input);

        // handling data query
        foreach($query as $item) {
            // change column value with columnOrder value
            if(array_key_exists('column', $item)) {
                if(array_key_exists('columnOrder', $item)) {
                    $item['column'] = $item['columnOrder'];

                    unset($item['columnOrder']);
                }
            }

            $subQuery = NULL;
            if(isset($item['subquery'])) {
                $subQuery = $item['subquery'];

                unset($item['subquery']);
            }

            $dataQuery = array_map(function ($val) {
                if (is_array($val)) {
                    return implode(',', $val);
                }
        
                return $val;
            }, $item);

            $dataQuery['data_source_id'] = $dataSource->id;

            $dataQuery['created_by'] = Auth::user()->id;

            $query = $this->dataQueryRepository->create($dataQuery);

            $this->saveSubQuery($subQuery, $dataSource->id, $query->id);

            // handling sub query one level
//            if($subQuery) {
//                foreach ($subQuery as $sub) {
//                    $dataSubQuery = array_map(function ($val) {
//                        if (is_array($val)) {
//                            return implode(',', $val);
//                        }
//
//                        return $val;
//                    }, $sub);
//
//                    $dataSubQuery['data_source_id'] = $dataSource->id;
//
//                    $dataSubQuery['parent'] = $query->id;
//
//                    $dataSubQuery['created_by'] = Auth::user()->id;
//
//                    $query = $this->dataQueryRepository->create($dataSubQuery);
//                }
//            }
        }
        // end handling data query

        // handling data column
        if($alias) {
            foreach($alias as $item) {
                if($item['alias'] || array_key_exists('select', $item)) {
                    $item['data_source_id'] = $dataSource->id;
                    $item['created_by'] = Auth::user()->id;

                    $this->columnAliasRepository->create($item);
                }
            }
        }
        // end handling column alias

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

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            Flash::error('Connection to database server ERROR!');

            return view('admin.data_sources.edit')
                ->with('dataSource', [])
                ->with('models', [])
                ->with('dataQuery', [])
                ->with('columns', [])
                ->with('columnAlias', []);
        }

        $models = array_map(function ($file) {
            $fileName = explode('.', $file);
            if(count($fileName) > 0) {
                return $fileName[0];
            }
        }, Storage::disk('model')->allFiles());

        $models = array_combine($models, $models);

        $dataSource = $this->dataSourceRepository->findWithoutFail($id);

        $dataQuery = $this->dataQueryRepository->findWhere(['data_source_id' => $id]);

        // get all column name of table
        $columns = [];
        if(isset($dataSource->model)) {
            if(stristr($dataSource->model, '/')) {
                $modelName = str_replace('/', '\\', $dataSource->model);
            } else {
                $modelName = $dataSource->model;
            }
            $modelFQNS = 'App\Models\\'.$modelName;

            $model = new $modelFQNS();

            $columns = $model->getTableColumns();

            $relations = $dataQuery->whereIn('command', ['join', 'leftJoin']);

            if(count($relations)) {
                $columns = array_map(function($value) use ($model) {
                    return $model->table.'.'.$value;
                }, $columns);

                foreach($relations as $relation) {
                    $relValue = explode(',', $relation['value']);
                    if(stristr($relValue[0], '/')) {
                        $joinModule = explode('/', $relValue[0]);
                        $joinModelNS = $joinModule[0];
                        $joinModelName = $joinModule[1];
                    } else {
                        $joinModelName = $relValue[0];
                    }

                    if(stristr($joinModelName, ' AS ')) {
                        // if using AS (table alias)
                        $joinNM = explode(' ', $joinModelName);

                        $joinModelName = $joinNM[0];
                    }

                    if(isset($joinModelNS)) {
                        $joinModelName = $joinModelNS.'\\'.$joinModelName;
                    }

                    $joinModelFQNS = 'App\Models\\'.$joinModelName;

                    $joinModel = new $joinModelFQNS();

                    $joinColumns = $joinModel->getTableColumns();

                    $joinColumns = array_map(function($value) use ($joinModel, $relValue) {
                        if(isset($joinNM[2])) {
                            return $joinNM[2].'.'.$value;
                        }
                        
                        if(isset($relValue[3])) {
                            return $relValue[3].'.'.$value;
                        }

                        return $joinModel->table.'.'.$value;
                    }, $joinColumns);

                    $columns = array_merge($columns, $joinColumns);
                }
            }

            $columns = array_combine($columns, $columns);
        }
        // get all column name of table

        // get data column
        $columnAlias = $this->columnAliasRepository->findWhere(['data_source_id' => $id]);
        // end get data column

        if (empty($dataSource)) {
            Flash::error('Data Source not found');

            return redirect(route('admin.dataSources.index'));
        }

        // edit by dandisy
        //return view('data_sources.edit')->with('dataSource', $dataSource);
        return view('admin.data_sources.edit')
            ->with('dataSource', $dataSource)
            ->with('models', $models)
            ->with('dataQuery', $dataQuery)
            ->with('columns', $columns)
            ->with('columnAlias', $columnAlias);
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

        // start handling data query
        $query = array_merge_recursive(
            $input['command'], 
            array_key_exists('column', $input) ? $input['column'] : [], 
            array_key_exists('operator', $input) ? $input['operator'] : [], 
            array_key_exists('value', $input) ? $input['value'] : [], 
            array_key_exists('index', $input) ? $input['index'] : []
        );

        unset($input['command']);
        if(array_key_exists('column', $input)) {
            unset($input['column']);
        }
        if(array_key_exists('operator', $input)) {
            unset($input['operator']);
        }
        if(array_key_exists('value', $input)) {
            unset($input['value']);
        }
        if(array_key_exists('index', $input)) {
            unset($input['index']);
        }

        foreach($query as $item) {
            $subQuery = NULL;
            if(isset($item['subquery'])) {
                $subQuery = $item['subquery'];

                unset($item['subquery']);
            }

            $dataQuery = array_map(function ($val) {
                if (is_array($val)) {
                    return implode(',', $val);
                }
        
                return $val;
            }, $item);

            if(array_key_exists('index', $dataQuery)) {
                $dataQuery['updated_by'] = Auth::user()->id;

                if(empty($dataQuery['column'])) {
                    $dataQuery['column'] = NULL;
                }

                $query = $this->dataQueryRepository->update($dataQuery, $dataQuery['index']);

                array_push($this->queryUpdated, $dataQuery['index']);
            } else {
                $dataQuery['data_source_id'] = $id;

                $dataQuery['created_by'] = Auth::user()->id;

                $query = $this->dataQueryRepository->create($dataQuery);

                array_push($this->queryUpdated, $query->id);
            }

            $this->saveSubQuery($subQuery, $id, $query->id);
        }

        if($this->queryUpdated) {
            DataQuery::where('data_source_id', $id)->whereNotIn('id', $this->queryUpdated)->delete();
        }
        // end handling data query        

        // handling data columns
        if(isset($input['alias'])) {
            $alias = $input['alias'];

            unset($input['alias']);

            $aliasUpdated = [];

            foreach($alias as $item) {
                if(array_key_exists('index', $item)) {
                    if(!$item['alias']) {
                        unset($item['alias']);
                    }
                    if(!$item['edit']) {
                        unset($item['edit']);
                    }
                    if(empty($item['un_search'])) {
                        $item['un_search'] = NULL;
                    }
                    if(empty($item['html'])) {
                        $item['html'] = NULL;
                    }

                    $item['updated_by'] = Auth::user()->id;

                    $this->dataColumnRepository->update($item, $item['index']);

                    array_push($aliasUpdated, $item['index']);
                } else if($item['alias'] || $item['edit']){
                    if(!$item['alias']) {
                        unset($item['alias']);
                    }
                    if(!$item['edit']) {
                        unset($item['edit']);
                    }

                    $item['data_source_id'] = $id;
                    $item['created_by'] = Auth::user()->id;

                    $newAlias = $this->dataColumnRepository->create($item);

                    array_push($aliasUpdated, $newAlias->id);
                } else {
                    if(array_key_exists('select', $item)){
                        if(!$item['alias']) {
                            unset($item['alias']);
                        }
                        if(!$item['edit']) {
                            unset($item['edit']);
                        }

                        $item['data_source_id'] = $id;
                        $item['created_by'] = Auth::user()->id;
    
                        $newAlias = $this->dataColumnRepository->create($item);
    
                        array_push($aliasUpdated, $newAlias->id);
                    } else {
                        ColumnAlias::where('data_source_id', $id)->delete();
                    }
                }
            }

            if($aliasUpdated) {
                ColumnAlias::where('data_source_id', $id)->whereNotIn('id', $aliasUpdated)->delete();
            }
        }
        // end handling data columns

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

        // handling related data query
        $dataQuery = $this->dataQueryRepository->findWhere(['data_source_id' => $id]);

        foreach ($dataQuery as $item) {
            $this->dataQueryRepository->delete($item->id);
        }
        // end handling related data query

        Flash::success('Data Source deleted successfully.');

        return redirect(route('admin.dataSources.index'));
    }

    private function arrayToStringe($val) {
        if (is_array($val)) {
            return implode(',',$val);
        }

        return $val;
    }

    private function saveSubQuery($query, $dataSourceId, $parentId) {
        if($query) {
            foreach ($query as $item) {
                $subQuery = NULL;

                if(isset($item['subquery'])) {
                    $subQuery = $item['subquery'];

                    unset($item['subquery']);
                }

                $dataQuery = array_map(function ($val) {
                    if (is_array($val)) {
                        return implode(',', $val);
                    }

                    return $val;
                }, $item);

                if(array_key_exists('index', $dataQuery)) {
                    $dataQuery['data_source_id'] = $dataSourceId;

                    $dataQuery['parent'] = $parentId;

                    $dataQuery['updated_by'] = Auth::user()->id;

                    if(empty($dataQuery['column'])) {
                        $dataQuery['column'] = NULL;
                    }

                    $query = $this->dataQueryRepository->update($dataQuery, $dataQuery['index']);

                    array_push($this->queryUpdated, $dataQuery['index']);
                } else {
                    $dataQuery['data_source_id'] = $dataSourceId;

                    $dataQuery['parent'] = $parentId;

                    $dataQuery['created_by'] = Auth::user()->id;

                    $query = $this->dataQueryRepository->create($dataQuery);

                    array_push($this->queryUpdated, $query->id);
                }

                $this->saveSubQuery($subQuery, $dataSourceId, $query->id);
            }
        }
    }
}
