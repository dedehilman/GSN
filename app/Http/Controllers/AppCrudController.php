<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Traits\RuleQueryBuilderTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppCrudController extends Controller
{
    use RuleQueryBuilderTrait;
    protected $select;
    protected $index;
    protected $view;
    protected $create;
    protected $edit;
    protected $model;
    protected $parentModel;
    protected $column = array();
    protected $columnSelect = array();
    protected $filePath = '';
    protected $extraParameter = array();
    protected $extraParameterSelect = array();

    public function setDefaultMiddleware($permission) {
        $this->middleware('auth');
        $this->middleware('permission:'.$permission.'-list|'.$permission.'-create|'.$permission.'-edit|'.$permission.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$permission.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$permission.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$permission.'-delete', ['only' => ['destroy']]);
    }

    public function setDefaultView($view) {
        $this->setIndex($view.'.index');
        $this->setCreate($view.'.create');
        $this->setEdit($view.'.edit');
        $this->setView($view.'.view');
    }

    public function setIndex($index) {
        $this->index = $index;
    }

    public function setSelect($select) {
        $this->select = $select;
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function setCreate($create) {
        $this->create = $create;
    }

    public function setEdit($edit) {
        $this->edit = $edit;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function setParentModel($parentModel) {
        $this->parentModel = $parentModel;
    }

    public function setColumn($column) {
        $this->column = $column;
        array_splice($this->column, 0, 0, ''); 
        array_splice($this->column, 1, 0, ''); 
        array_splice($this->column, 2, 0, ''); 
    }

    public function setColumnSelect($columnSelect) {
        $this->columnSelect = $columnSelect;
        array_splice($this->columnSelect, 0, 0, ''); 
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getTableName() {
        return with(new $this->model)->getTable();
    }

    public function getClassName($replaceBackSlash = true) {
        $className = get_class(with(new $this->model));
        if($replaceBackSlash) {
            return str_replace("\\", "\\\\", $className);
        }
        return $className;
    }

    public function getParentTableName() {
        return with(new $this->parentModel)->getTable();
    }

    public function getFilePath() {
        return $this->filePath;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function select(Request $request)
    {
        $parameters = array();
        foreach ($request->all() as $key => $value) {
            if($key == "_") continue;

            $parameters[$key] = $value;
        }
        $select = $request->select ?? 'single';
        return view($this->select, compact('select', 'parameters'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->parentId) {
            $data = $this->parentModel::find($request->parentId);
            if(!$data) {
                return redirect()->back()->with(['info' => Lang::get("Data not found")]);
            }

            return view($this->index, compact('data'));    
        }

        return view($this->index);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->parentId) {
            $data = $this->parentModel::find($request->parentId);
            if(!$data) {
                return redirect()->back()->with(['info' => Lang::get("Data not found")]);
            }

            return view($this->create, compact('data'));    
        }

        return view($this->create);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validateOnStore = $this->validateOnStore($request);
            if($validateOnStore) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnStore
                ]);
            }

            $this->model::create($request->all());
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        return view($this->view, compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        $data = $this->model::find($id);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        return view($this->edit, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validateOnUpdate
                ]);
            }

            $data->fill($request->all())->save();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been updated")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $parameterName = $request->route()->parameterNames[count($request->route()->parameterNames)-1];
        $id = $request->route()->parameters[$parameterName];
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> Lang::get("Data not found")
                ]);
            }

            $data->delete();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been deleted")
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }
    }

    public function datatable(Request $request)
    {
        try
        {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $order = "id";
            if($request->input('order.0.column') < count($this->columnSelect)) {
                $order = $this->columnSelect[$request->input('order.0.column')];
            } else if($request->input('columns.'.$request->input('order.0.column').'.name')) {
                $order = $request->input('columns.'.$request->input('order.0.column').'.name');
            }
            $dir = 'asc';
            if($request->input('order.0.dir')) {
                $dir = $request->input('order.0.dir');
            }
            
            if(method_exists($this->model, 'scopeWithAll')) {
                $query = $this->model::withAll();
            } else {
                $query = DB::table($this->getTableName());
            }
            if($request->parentId) {
                $query = $query->where(rtrim($this->getParentTableName(), "s")."_id", $request->parentId);
            }
            if(!$request->queryBuilder || $request->queryBuilder == '1') {
                $query = $this->queryBuilder([$this->getTableName()], $query);
            }
            $this->setExtraParameter($request);
            $query = $this->filterExtraParameter($query);
            $totalData = $query->count();
            $query = $this->filterDatatable($request, $query);
            $totalFiltered = $query->count();

            if ($length == -1) {
                $data = $query
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $data = $query
                    ->offset($start)
                    ->limit($length)
                    ->orderBy($order, $dir)
                    ->get();
            }
            
            return response()->json([
                "draw" => intval($request->input('draw')),  
                "recordsTotal" => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data" => $data
            ]);
        } 
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function datatableSelect(Request $request)
    {
        try
        {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $order = "id";
            if($request->input('order.0.column') < count($this->columnSelect)) {
                $order = $this->columnSelect[$request->input('order.0.column')];
            } else if($request->input('columns.'.$request->input('order.0.column').'.name')) {
                $order = $request->input('columns.'.$request->input('order.0.column').'.name');
            }
            $dir = 'asc';
            if($request->input('order.0.dir')) {
                $dir = $request->input('order.0.dir');
            }
            
            if(method_exists($this->model, 'scopeWithAll')) {
                $query = $this->model::withAll();
            } else {
                $query = DB::table($this->getTableName());
            }
            if($request->parentId) {
                $query = $query->where(rtrim($this->getParentTableName(), "s")."_id", $request->parentId);
            }
            if(!$request->queryBuilder || $request->queryBuilder == '1') {
                $query = $this->queryBuilder([$this->getTableName()], $query);
            }
            $this->setExtraParameterSelect($request);
            $query = $this->filterExtraParameterSelect($query);
            $totalData = $query->count();
            $query = $this->filterDatatableSelect($request, $query);
            $totalFiltered = $query->count();

            if ($length == -1) {
                $data = $query
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $data = $query
                    ->offset($start)
                    ->limit($length)
                    ->orderBy($order, $dir)
                    ->get();
            }
            
            return response()->json([
                "draw" => intval($request->input('draw')),  
                "recordsTotal" => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data" => $data
            ]);
        } 
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * validate on store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateOnStore(Request $request)
    {
        return null;
    }

    /**
     * validate on store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validateOnUpdate(Request $request, int $id)
    {
        return null;
    }

    /**
     * validate on store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $query
     * @return 
     */
    public function filterDatatable(Request $request, $query)
    {
        $search = $request->input('search.value') ?? "";
        $columns = $request->input("columns") ?? [];
        if($search && $columns) {
            $query->where(function($query) use ($search, $columns) 
            {
                foreach($columns as $column) {
                    if($column['name'] && !Str::endsWith($column['name'], '_id')) {
                        $query->orWhere($column['name'],'LIKE', $search);
                    }
                }
            });    
        }

        $search = $request->parameters['search'] ?? "";
        if($search && $columns) {
            $query->where(function($query) use ($search, $columns) 
            {
                foreach($columns as $column) {
                    if($column['name'] && !Str::endsWith($column['name'], '_id')) {
                        $query->orWhere($column['name'],'LIKE', $search);
                    }
                }
            });    
        }

        foreach($request->parameters ?? [] as $key => $value) {
            if($key == "search") continue;

            if($value != null) {
                if(Str::endsWith($key, '.like')) {
                    $query->where(Str::replace('.like', '', $key),'LIKE',"%{$value}%");
                }
                else if(Str::endsWith($key, '.gt')) {
                    $query->where(Str::replace('.gt', '', $key),'>',$value);
                }
                else if(Str::endsWith($key, '.gte')) {
                    $query->where(Str::replace('.gte', '', $key),'>=',$value);
                }
                else if(Str::endsWith($key, '.lt')) {
                    $query->where(Str::replace('.lt', '', $key),'<',$value);
                }
                else if(Str::endsWith($key, '.lte')) {
                    $query->where(Str::replace('.lte', '', $key),'<=',$value);
                }
                else if(Str::endsWith($key, '.eq')) {
                    if($value == "null") {
                        $query->whereNull(Str::replace('.eq', '', $key));
                    } else {
                        $query->where(Str::replace('.eq', '', $key),'=',$value);
                    }
                }
                else if(Str::endsWith($key, '.neq')) {
                    if($value == "null") {
                        $query->whereNotNull(Str::replace('.neq', '', $key));
                    } else {
                        $query->where(Str::replace('.neq', '', $key),'<>',$value);
                    }
                }
                else if(Str::startsWith($value, '%') || Str::endsWith($value, '%')) {
                    $query->where($key,'LIKE',"$value");
                } else {
                    if($value == "null") {
                        $query->whereNull($key);
                    } else {
                        $query->where($key,$value);
                    }
                }
            }
        }
        return $query;
    }

    /**
     * validate on store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $query
     * @return 
     */
    public function filterDatatableSelect(Request $request, $query)
    {
        return $this->filterDatatable($request, $query);
    }

    /**
     * store media.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return 
     */
    public function storeMedia(Request $request)
    {
        $maxUploadSize = getParameter('MAX_UPLOAD_SIZE');
        if($maxUploadSize && $maxUploadSize != "") {
            $validator = Validator::make($request->all(), [
                'file' => 'required|file|max:'.$maxUploadSize,
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validator->errors()->all(),
                ]);
            }       
        }

        $path = storage_path("media/".$this->getFilePath());

        if (!file_exists($path)) {
            $old = umask(0);
            mkdir($path, 0777, true);
            umask($old);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'status'        => '200',
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function addExtraParameter($column, $value) {
        $this->extraParameter[$column] = $value;
    }

    public function addExtraParameterSelect($column, $value) {
        $this->extraParameterSelect[$column] = $value;
    }

    public function setExtraParameter($request) {
        foreach($request->extraParameters ?? [] as $key => $value) {
            $this->addExtraParameter($key, $value);
        }
    }

    public function setExtraParameterSelect($request) {
        foreach($request->extraParameters ?? [] as $key => $value) {
            $this->addExtraParameterSelect($key, $value);
        }
    }

    public function filterExtraParameter($query) {
        foreach($this->extraParameter ?? [] as $key => $value) {
            if($value != null) {
                if(Str::endsWith($key, '.like')) {
                    $query->where(Str::replace('.like', '', $key),'LIKE',"%{$value}%");
                }
                else if(Str::endsWith($key, '.gt')) {
                    $query->where(Str::replace('.gt', '', $key),'>',$value);
                }
                else if(Str::endsWith($key, '.gte')) {
                    $query->where(Str::replace('.gte', '', $key),'>=',$value);
                }
                else if(Str::endsWith($key, '.lt')) {
                    $query->where(Str::replace('.lt', '', $key),'<',$value);
                }
                else if(Str::endsWith($key, '.lte')) {
                    $query->where(Str::replace('.lte', '', $key),'<=',$value);
                }
                else if(Str::endsWith($key, '.eq')) {
                    if($value == "null") {
                        $query->whereNull(Str::replace('.eq', '', $key));
                    } else {
                        $query->where(Str::replace('.eq', '', $key),'=',$value);
                    }
                }
                else if(Str::endsWith($key, '.neq')) {
                    if($value == "null") {
                        $query->whereNotNull(Str::replace('.neq', '', $key));
                    } else {
                        $query->where(Str::replace('.neq', '', $key),'<>',$value);
                    }
                }
                else if(Str::startsWith($value, '%') || Str::endsWith($value, '%')) {
                    $query->where($key,'LIKE',"$value");
                } else {
                    if($value == "null") {
                        $query->whereNull($key);
                    } else {
                        $query->where($key,$value);
                    }
                }
            }
        }
        return $query;
    }

    public function filterExtraParameterSelect($query) {
        foreach($this->extraParameterSelect ?? [] as $key => $value) {
            if($value != null) {
                if(Str::endsWith($key, '.like')) {
                    $query->where(Str::replace('.like', '', $key),'LIKE',"%{$value}%");
                }
                else if(Str::endsWith($key, '.gt')) {
                    $query->where(Str::replace('.gt', '', $key),'>',$value);
                }
                else if(Str::endsWith($key, '.gte')) {
                    $query->where(Str::replace('.gte', '', $key),'>=',$value);
                }
                else if(Str::endsWith($key, '.lt')) {
                    $query->where(Str::replace('.lt', '', $key),'<',$value);
                }
                else if(Str::endsWith($key, '.lte')) {
                    $query->where(Str::replace('.lte', '', $key),'<=',$value);
                }
                else if(Str::endsWith($key, '.eq')) {
                    if($value == "null") {
                        $query->whereNull(Str::replace('.eq', '', $key));
                    } else {
                        $query->where(Str::replace('.eq', '', $key),'=',$value);
                    }
                }
                else if(Str::endsWith($key, '.neq')) {
                    if($value == "null") {
                        $query->whereNotNull(Str::replace('.neq', '', $key));
                    } else {
                        $query->where(Str::replace('.neq', '', $key),'<>',$value);
                    }
                }
                else if(Str::startsWith($value, '%') || Str::endsWith($value, '%')) {
                    $query->where($key,'LIKE',"$value");
                } else {
                    if($value == "null") {
                        $query->whereNull($key);
                    } else {
                        $query->where($key,$value);
                    }
                }
            }
        }
        return $query;
    }
}
