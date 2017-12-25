<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Dns\DnsManager;
use Richardds\ServerAdmin\DnsRecord;
use Richardds\ServerAdmin\DnsZone;
use Richardds\ServerAdmin\Http\CrudAssistance;

class DnsRecordController extends Controller
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
     * @param DnsZone $dnsZone
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(DnsZone $dnsZone, Request $request)
    {
        if ($request->wantsJson()) {
            return api_response()->success($dnsZone->dnsRecords->toArray())->response();
        }

        return view('sections.dns.zone');
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DnsRecord $dnsRecord)
    {
        return api_response()->success($dnsRecord->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // ...
        ]);

        $dnsRecord = DnsRecord::create([
            // ...
        ]);

        $this->manager->updateZonesConfig(); // TODO: Single zone
        $this->manager->reload();

        return api_response()->success(['id' => $dnsRecord->id])->response();
    }

    /**
     * @param Request $request
     * @param DnsRecord $dnsRecord
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DnsRecord $dnsRecord)
    {
        $rules = [
            // ...
        ];

        $this->validate($request, $rules);

        $this->updateModel($dnsRecord, $request, array_keys($rules));
        $dnsRecord->save();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success($dnsRecord->toArray())->response();
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DnsRecord $dnsRecord)
    {
        $dnsRecord->delete();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
