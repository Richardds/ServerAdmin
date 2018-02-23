<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Richardds\ServerAdmin\Core\Firewall\FirewallManager;
use Richardds\ServerAdmin\FirewallRule;
use Richardds\ServerAdmin\Rules\IPN;

class FirewallRuleController extends ModelController
{
    /**
     * @var \Richardds\ServerAdmin\Core\Firewall\FirewallManager
     */
    private $manager;

    /**
     * @var array
     */
    protected $editable = [
        'destination',
        'source',
        'port',
        'portTo',
        'enabled',
    ];

    /**
     * FirewallRuleController constructor.
     * @param FirewallManager $manager
     */
    public function __construct(FirewallManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;

        parent::__construct(FirewallRule::class);

        $this->rules = [
            'type' => ['required', Rule::in(FirewallRule::availableTypes())],
            'protocol' => ['required', Rule::in(FirewallRule::availableProtocols())],
            'destination' => ['nullable', new IPN()],
            'source' => ['nullable', new IPN()],
            'port' => ['required', 'numeric', 'between:1,65535'],
            'portTo' => ['nullable', 'numeric', 'between:1,65535'],
            'enabled' => ['boolean'],
        ];
    }

    /**
     * @return \Illuminate\View\View
     */
    public function rules()
    {
        return view('sections.firewall.rules');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $firewallRule = FirewallRule::create([
            'type' => $request->get('type'),
            'protocol' => $request->get('protocol'),
            'destination' => $request->get('destination'),
            'source' => $request->get('source'),
            'port' => $request->get('port'),
            'portTo' => $request->get('portTo'),
        ]);

        $this->manager->generateRules();

        return api_response()->success(['id' => $firewallRule->id])->response();
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $ret = parent::update($request, $id);

        $this->manager->generateRules();

        return $ret;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, int $id)
    {
        $ret = parent::destroy($request, $id);

        $this->manager->generateRules();

        return $ret;
    }
}
