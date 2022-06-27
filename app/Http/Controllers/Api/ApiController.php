<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Lang;
use App\Traits\RuleQueryBuilderTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use RuleQueryBuilderTrait;
    private $model;

    public function setDefaultMiddleware($permission) {
        $this->middleware('auth:api');
        $this->middleware('permission:'.$permission.'-list|'.$permission.'-create|'.$permission.'-edit|'.$permission.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$permission.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$permission.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$permission.'-delete', ['only' => ['destroy']]);
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getModel() {
        return $this->model;
    }

    public function getTableName() {
        return with(new $this->model)->getTable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;

            if(method_exists($this->model, 'scopeWithAll')) {
                $query = $this->model::withAll();
            } else {
                $query = DB::table($this->getTableName());
            }

            $query = $this->queryBuilder([$this->getTableName()], $query);
            $totalData = $query->count();
            $query = $this->filterBuilder($request, $query);
            $query = $this->sortBuilder($request, $query);
            $totalFiltered = $query->count();

            if ($size == -1) {
                $totalPage = 1;
                $data = $query->get();
            } else {
                $totalPage = ceil($totalFiltered / $size);
                $data = $query
                    ->offset($page * $size)
                    ->limit($size)
                    ->get();
            }
            
            return response()->json([
                "status" => '200',
                "message" => '',
                "data" => array(
                    "page" => intval($page),
                    "size" => intval($size),
                    "total_page" => intval($totalPage),
                    "total_data" => intval($totalData),
                    "total_filtered" => intval($totalFiltered),
                    "data" => $data    
                )
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Not Implemented
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
                    'message'=> $validateOnStore,
                    'data' => '',
                ]);
            }

            $data = $this->model::create($request->all());
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been stored"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            return response()->json([
                'status' => '200',
                'message'=> '',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Not Implemented
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
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $validateOnUpdate = $this->validateOnUpdate($request, $id);
            if($validateOnUpdate) {
                return response()->json([
                    'status' => '400',
                    'message'=> $validateOnUpdate,
                    'data' => '',
                ]);
            }

            $data = $data->fill($request->all())->save();
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been updated"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->model::find($id);
            if(!$data) {
                return response()->json([
                    'status' => '400',
                    'message'=> Lang::get("Data not found"),
                    'data' => '',
                ]);
            }

            $validateOnDestroy = $this->validateOnDestroy($id);
            if($validateOnDestroy) {
                return response()->json([
                    'status' => '400',
                    'message'=> $validateOnDestroy,
                    'data' => '',
                ]);
            }

            $data->delete();
            return response()->json([
                'status' => '200',
                'message'=> Lang::get("Data has been deleted"),
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'message'=> $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function validateOnStore(Request $request)
    {
        return null;
    }

    public function validateOnUpdate(Request $request, int $id)
    {
        return null;
    }

    public function validateOnDestroy(int $id)
    {
        return null;
    }

    public function filterBuilder(Request $request, $query)
    {
        foreach ($request->all() as $key => $value) {
            if($key == "sort" || $key == "page" || $key == "size")
                continue;

            if($value) {                
                if(Str::endsWith($key, '_like')) {
                    $query->where(Str::replace('_like', '', $key),'LIKE',"%{$value}%");
                }
                else if(Str::endsWith($key, '_gt')) {
                    $query->where(Str::replace('_gt', '', $key),'>',$value);
                }
                else if(Str::endsWith($key, '_gte')) {
                    $query->where(Str::replace('_gte', '', $key),'>=',$value);
                }
                else if(Str::endsWith($key, '_lt')) {
                    $query->where(Str::replace('_lt', '', $key),'<',$value);
                }
                else if(Str::endsWith($key, '_lte')) {
                    $query->where(Str::replace('_lte', '', $key),'<=',$value);
                }
                else if(Str::endsWith($key, '_eq')) {
                    if($value == "null") {
                        $query->whereNull(Str::replace('_eq', '', $key));
                    } else {
                        $query->where(Str::replace('_eq', '', $key),'=',$value);
                    }
                }
                else if(Str::endsWith($key, '_neq')) {
                    if($value == "null") {
                        $query->whereNotNull(Str::replace('_neq', '', $key));
                    } else {
                        $query->where(Str::replace('_neq', '', $key),'<>',$value);
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

    public function sortBuilder(Request $request, $query)
    {
        $columns = ["id"];
        $directions = ["asc"];

        if(is_array($request->sort)) {
            foreach ($request->sort as $sortArr) {
                $sort = explode(',', $sortArr);
                if(count($sort) > 0) {
                    array_unshift($columns, $sort[0]);
                    array_unshift($directions, $sort[1]);
                } else {
                    array_unshift($columns, $sort[0]);
                    array_unshift($columns, "asc");
                }
            }
        } else if($request->sort) {
            $sort = explode(',', $request->sort);
            if(count($sort) > 0) {
                array_unshift($columns, $sort[0]);
                array_unshift($directions, $sort[1]);
            } else {
                array_unshift($columns, $sort[0]);
                array_unshift($columns, "asc");
            }
        }

        foreach ($columns as $index => $column) {
            $query->orderBy($column, $directions[$index] ?? "asc");
        }

        return $query;
    }
}
