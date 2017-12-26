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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function zones()
    {
        return view('sections.dns.zones');
    }

    /**
     * @param DnsZone $zone
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function zone(DnsZone $zone)
    {
        return view('sections.dns.zone', compact('zone'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return api_response()->success(DnsZone::all()->toArray())->response();
    }

    /**
     * @param DnsZone $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function records(DnsZone $zone)
    {
        return api_response()->success($zone->dnsRecords->toArray())->response();
    }

    /**
     * @param \Richardds\ServerAdmin\DnsZone $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DnsZone $zone)
    {
        return api_response()->success($zone->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:253|unique:dns_zones,name',
            'admin' => 'required|min:1|max:253',
            'serial' => 'required|numeric',
            'refresh' => 'required|numeric',
            'retry' => 'required|numeric',
            'expire' => 'required|numeric',
            'ttl' => 'required|numeric',
            'enabled' => 'boolean',
        ]);

        $zone = DnsZone::create([
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

        return api_response()->success(['id' => $zone->id])->response();
    }

    /**
     * @param Request $request
     * @param DnsZone $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DnsZone $zone)
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
        $this->updateModel($zone, $request, array_keys($rules));
        $zone->save();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success($zone->toArray())->response();
    }

    /**
     * @param DnsZone $zone
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DnsZone $zone)
    {
        $zone->delete();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
