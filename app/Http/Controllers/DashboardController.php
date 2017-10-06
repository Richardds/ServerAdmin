<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Richardds\ServerAdmin\Core\Commands\SystemInfo;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDashboard()
    {
        $os = SystemInfo::os();
        $uptime = SystemInfo::uptime();

        return view('sections.dashboard.dashboard', compact('os', 'uptime'));
    }
}
