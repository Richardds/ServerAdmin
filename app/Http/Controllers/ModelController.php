<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Richardds\ServerAdmin\Http\CrudAssistance;

abstract class ModelController extends Controller
{
    use CrudAssistance;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var array
     */
    protected $rules = [
        //
    ];

    /**
     * ModelController constructor.
     *
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return api_response()->success($this->model::all()->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public abstract function store(Request $request);

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->model::findOrFail($id);

        return api_response()->success($model->toArray())->response();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $model = $this->model::findOrFail($id);

        $this->validate($request, $this->stripRequired($this->rules));
        $this->updateModel($model, $request, array_keys($this->rules));
        $model->save();

        return api_response()->success($model->toArray())->response();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);

        $model->delete();

        return api_response()->success()->response();
    }
}
