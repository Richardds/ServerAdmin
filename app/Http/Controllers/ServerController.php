<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Commands\Server;

class ServerController extends Controller
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Stop server.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function stop(Request $request)
    {
        Server::stop();

        return api_response()->success()->response();
    }

    /**
     * Restart server.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function restart(Request $request)
    {
        Server::restart();

        return api_response()->success()->response();
    }
}
