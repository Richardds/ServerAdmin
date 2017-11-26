<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Dns\DnsManager;
use Richardds\ServerAdmin\DnsZone;
use Richardds\ServerAdmin\Http\CrudAssistance;

class DnsZoneController extends Controller
{
    use CrudAssistance;

    /**
     * @var \Richardds\ServerAdmin\Core\Dns\DnsManager
     */
    private $manager;

    /**
     * DnsZoneController constructor.
     *
     * @param \Richardds\ServerAdmin\Core\Dns\DnsManager $manager
     */
    public function __construct(DnsManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return api_response()->success(DnsZone::all()->toArray())->response();
        }

        return view('sections.dns.zones');
    }

    /**
     * @param \Richardds\ServerAdmin\DnsZone $dnsZone
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DnsZone $dnsZone)
    {
        return api_response()->success($dnsZone->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:253',
            'admin' => 'required|min:1|max:253',
            'serial' => 'required|numeric',
            'refresh' => 'required|numeric',
            'retry' => 'required|numeric',
            'expire' => 'required|numeric',
            'ttl' => 'required|numeric',
            'enabled' => 'boolean',
        ]);

        $dnsZone = DnsZone::create([
            'name' => $request->get('name'),
            'admin' => $request->get('admin'),
            'serial' => $request->get('serial'),
            'refresh' => $request->get('refresh'),
            'retry' => $request->get('retry'),
            'expire' => $request->get('expire'),
            'ttl' => $request->get('ttl'),
            'enabled' => $request->get('enabled') ?? true,
        ]);

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success(['id' => $dnsZone->id])->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Richardds\ServerAdmin\DnsZone $dnsZone
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DnsZone $dnsZone)
    {
        $rules = [
            'name' => 'min:1|max:253',
            'admin' => 'min:1|max:253',
            'serial' => 'numeric',
            'refresh' => 'numeric',
            'retry' => 'numeric',
            'expire' => 'numeric',
            'ttl' => 'numeric',
            'enabled' => 'boolean',
        ];

        $this->validate($request, $rules);

        $this->updateModel($dnsZone, $request, array_keys($rules));
        $dnsZone->save();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success($dnsZone->toArray())->response();
    }

    /**
     * @param \Richardds\ServerAdmin\DnsZone $dnsZone
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DnsZone $dnsZone)
    {
        $dnsZone->delete();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
