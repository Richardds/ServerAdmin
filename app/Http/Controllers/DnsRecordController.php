<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Richardds\ServerAdmin\Core\Dns\DnsManager;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAssistance;
use Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException;
use Richardds\ServerAdmin\DnsRecord;
use Richardds\ServerAdmin\DnsZone;
use Richardds\ServerAdmin\Http\CrudAssistance;

class DnsRecordController extends Controller
{
    use CrudAssistance;
    use DnsRecordAssistance;

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
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'zone_id' => ['required', 'exists:dns_zones,id'],
            'type' => ['required', 'string', Rule::in(DnsRecord::availableTypes())],
            'name' => ['string', 'max:253'],
            'attrs' => ['required', 'array'],
            'ttl' => ['required', 'numeric'],
            'enabled' => ['boolean'],
        ]);

        $type = $request->get('type');

        try {
            $record = new DnsRecord([
                'zone_id' => $request->get('zone_id'),
                'type' => $type,
                'name' => $request->get('name', '@'),
                'attrs' => self::createDnsRecordAttributes($type, $request->get('attrs')),
                'ttl' => $request->get('ttl'),
                'enabled' => $request->get('enabled', true),
            ]);
        } catch (InvalidValidatedParameterException $e) {
            throw ValidationException::withMessages($e->getErrors());
        }

        $record->save();

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success(['id' => $record->id])->response();
    }

    /**
     * @param Request $request
     * @param DnsRecord $record
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, DnsRecord $record)
    {
        $rules = [
            'name' => ['string', 'max:253'],
            'ttl' => ['numeric'],
            'enabled' => ['boolean'],
        ];

        $this->validate($request, $rules);

        $this->updateModel($record, $request, array_keys($rules));

        if ($request->has('attrs')) {
            $record->attrs = self::createDnsRecordAttributes($record->type, $request->get('attrs'));
            $record->attrs; // Call fromArray method to validate record attributes
        }

        $record->save();

        $this->manager->configure();
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

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
