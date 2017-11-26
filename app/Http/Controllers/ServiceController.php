<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Commands\ServiceCommand;
use Richardds\ServerAdmin\Core\Service;

class ServiceController extends Controller
{
    private $services = [
        'dns' => 'bind9',
    ];

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Start service and return service status.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $service = ServiceCommand::start($this->getValidServiceName($request));

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Stop service and return service status.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stop(Request $request)
    {
        $service = ServiceCommand::stop($this->getValidServiceName($request));

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Restart service and return service status.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restart(Request $request)
    {
        $service = ServiceCommand::restart($this->getValidServiceName($request));

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Reload service and return service status.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reload(Request $request)
    {
        $service = ServiceCommand::reload($this->getValidServiceName($request));

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Get status of service.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        $service = new Service($this->getValidServiceName($request));

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function getValidServiceName(Request $request)
    {
        $this->validate($request, [
            'service' => 'required|string|max:255',
        ]);

        $service = $request->get('service');

        if (! $this->services[$service]) {
            throw new \Exception('Invalid service name');
        }

        return $this->services[$service];
    }

    public function createServiceReport(Service $service)
    {
        return [
            'running' => $service->isRunning(),
            // ...
        ];
    }
}
