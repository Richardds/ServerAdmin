<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Richardds\ServerAdmin\Core\Commands\SystemInfo;
use Richardds\ServerAdmin\Core\Server\Uptime;
use Richardds\ServerAdmin\Core\SystemUser;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidCommandOutputException
     */
    public function showDashboard()
    {
        $os = SystemInfo::os();
        $uptime = new Uptime(SystemInfo::uptime());
        $user = SystemUser::getByName(SystemInfo::whoami());
        $memory = SystemInfo::memory();
        $swap = SystemInfo::swap();
        $processor = SystemInfo::processor();

        return view('sections.dashboard.dashboard', compact('os', 'uptime', 'user', 'memory', 'swap', 'processor'));
    }
}
