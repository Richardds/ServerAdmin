<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!is_null($zoneId = $request->query('zone'))) {
            return api_response()->success(DnsZone::findOrFail($zoneId)->dnsRecords->toArray())->response();
        }

        return api_response()->success(DnsRecord::all()->toArray())->response();
    }

    /**
     * @param DnsRecord $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DnsRecord $record)
    {
        return api_response()->success($record->toArray())->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'zone_id' => 'required|exists:dns_records,id',
            'type' => 'required',
            'name' => 'required|min:1|max:253',
            'attrs' => 'required',
            'ttl' => 'required|numeric',
            'enabled' => 'boolean',
        ]);

        $type = $request->get('type');

        // Record type validation
        if (!in_array($type, DnsRecord::availableTypes())) {
            throw ValidationException::withMessages([
                'type' => 'Invalid type.'
            ]);
        }

        $record = new DnsRecord([
            'type' => $type,
            'name' => $request->get('name'),
            'attrs' => $request->get('attrs'),
            'ttl' => $request->get('ttl'),
            'enabled' => $request->get('enabled') ?? true,
        ]);

        $record->attrs; // Call fromArray method to validate record attributes

        $record->save(); // If no exception is thrown save new record

        $this->manager->updateZonesConfig(); // TODO: Single zone
        $this->manager->reload();

        return api_response()->success(['id' => $record->id])->response();
    }

    /**
     * @param Request $request
     * @param DnsRecord $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DnsRecord $record)
    {
        $rules = [
            // ...
        ];

        $this->validate($request, $rules);

        $this->updateModel($record, $request, array_keys($rules));
        $record->save();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success($record->toArray())->response();
    }

    /**
     * @param DnsRecord $record
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DnsRecord $record)
    {
        $record->delete();

        $this->manager->updateZonesConfig();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
