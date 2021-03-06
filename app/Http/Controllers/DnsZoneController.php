<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Dns\DnsManager;
use Richardds\ServerAdmin\DnsZone;
use Richardds\ServerAdmin\Facades\Execute;
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
     * @return \Illuminate\View\View
     */
    public function zones()
    {
        return view('sections.dns.zones');
    }

    /**
     * @param DnsZone $zone
     * @return \Illuminate\View\View
     */
    public function zone(DnsZone $zone)
    {
        return view('sections.dns.zone', compact('zone'));
    }

    /**
     * @param DnsZone $zone
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function export(DnsZone $zone)
    {
        $exportedZone = Execute::output('cat ' . DnsManager::ZONES_CONFIG_FOLDER . '/' . $zone->name . '.db');

        return response($exportedZone, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$zone->name}.txt\""
        ]);
    }

    /**
     * @param DnsZone $zone
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function import(DnsZone $zone, Request $request)
    {
        return api_response()->fail(new \Exception('Method not implemented.'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return api_response()->success(DnsZone::all()->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:253', 'unique:dns_zones,name'],
            'admin' => ['string', 'min:3', 'max:253'],
            'serial' => ['required', 'numeric'],
            'refresh' => ['required', 'numeric'],
            'retry' => ['required', 'numeric'],
            'expire' => ['required', 'numeric'],
            'ttl' => ['required', 'numeric'],
            'enabled' => ['boolean'],
        ]);

        $zone = DnsZone::create([
            'name' => $request->get('name'),
            'admin' => $request->get('admin', 'admin.' . $request->get('name')),
            'serial' => $request->get('serial'),
            'refresh' => $request->get('refresh'),
            'retry' => $request->get('retry'),
            'expire' => $request->get('expire'),
            'ttl' => $request->get('ttl'),
            'enabled' => $request->get('enabled', true),
        ]);

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success(['id' => $zone->id])->response();
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
     * @param Request $request
     * @param DnsZone $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DnsZone $zone)
    {
        $rules = [
            'admin' => ['string', 'min:3', 'max:253'],
            'serial' => ['numeric'],
            'refresh' => ['numeric'],
            'retry' => ['numeric'],
            'expire' => ['numeric'],
            'ttl' => ['numeric'],
            'enabled' => ['boolean'],
        ];

        $this->validate($request, $rules);
        $this->updateModel($zone, $request, array_keys($rules));
        $zone->save();

        $this->manager->configure();
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

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
