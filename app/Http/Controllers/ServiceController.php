<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Database\DatabaseManager;
use Richardds\ServerAdmin\Core\Dns\DnsManager;
use Richardds\ServerAdmin\Core\Firewall\FirewallManager;
use Richardds\ServerAdmin\Core\Mail\MailManager;
use Richardds\ServerAdmin\Core\Service;

class ServiceController extends Controller
{
    private $services = [
        'dns' => DnsManager::class,
        'database' => DatabaseManager::class,
        'mail' => MailManager::class,
        'firewall' => FirewallManager::class,
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function start(Request $request)
    {
        $service = $this->getValidService($request);
        $service->start();

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Stop service and return service status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function stop(Request $request)
    {
        $service = $this->getValidService($request);
        $service->stop();

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Restart service and return service status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function restart(Request $request)
    {
        $service = $this->getValidService($request);
        $service->restart();

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Reload service and return service status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function reload(Request $request)
    {
        $service = $this->getValidService($request);
        $service->reload();

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * Get status of service.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function status(Request $request)
    {
        $service = $this->getValidService($request);

        return api_response()->success($this->createServiceReport($service))->response();
    }

    /**
     * @param Request $request
     * @return Service
     * @throws \Exception
     */
    public function getValidService(Request $request): Service
    {
        $this->validate($request, [
            'service' => 'required|string|max:255',
        ]);

        $service = $request->get('service');

        if (!isset($this->services[$service])) {
            throw new \Exception('Invalid service name.');
        }

        return new $this->services[$service];
    }

    public function createServiceReport(Service $service)
    {
        return [
            'running' => $service->isRunning(),
        ];
    }
}
