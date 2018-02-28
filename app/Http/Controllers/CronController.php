<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\SystemUser;
use Richardds\ServerAdmin\Core\Tasks\TaskManager;
use Richardds\ServerAdmin\Cron;
use Richardds\ServerAdmin\Http\CrudAssistance;

class CronController extends Controller
{
    use CrudAssistance;

    /**
     * @var \Richardds\ServerAdmin\Core\Tasks\TaskManager;
     */
    private $manager;

    /**
     * @var array
     */
    protected $rules = [
        'minute' => ['string', 'max:255'],
        'hour' => ['string', 'max:255'],
        'day' => ['string', 'max:255'],
        'month' => ['string', 'max:255'],
        'weekday' => ['string', 'max:255'],
        'command' => ['string', 'max:255'],
        'uid' => ['numeric'],
        'enabled' => ['boolean'],
    ];

    /**
     * CronController constructor.
     * @param TaskManager $manager
     */
    public function __construct(TaskManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function cron_tasks()
    {
        return view('sections.tasks.tasks');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return api_response()->success(Cron::all()->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $task = Cron::create([
            'minute' => $request->get('minute', '*'),
            'hour' => $request->get('hour', '*'),
            'day' => $request->get('day', '*'),
            'month' => $request->get('month', '*'),
            'weekday' => $request->get('weekday', '*'),
            'command' => $request->get('command'),
            'uid' => $request->get('uid', SystemUser::getByName('serveradmin')->getUid()),
            'enabled' => $request->get('enabled', true),
        ]);

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success(['id' => $task->id])->response();
    }

    /**
     * @param  \Richardds\ServerAdmin\Cron $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Cron $task)
    {
        return api_response()->success($task->toArray())->response();
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \Richardds\ServerAdmin\Cron $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Cron $task)
    {
        $this->validate($request, $this->stripRequired($this->rules));
        $this->updateModel($task, $request, array_keys($this->rules));
        $task->save();

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success($task->toArray())->response();
    }

    /**
     * @param  \Richardds\ServerAdmin\Cron $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Cron $task)
    {
        $task->delete();

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
