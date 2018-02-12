<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailDomain;
use Richardds\ServerAdmin\MailUser;

class MailUserController extends ModelController
{
    protected $rules = [
        'domain_id' => 'required|exists:mail_domains,id',
        'name' => 'min:1|max:255',
        'username' => 'required|min:1|max:255',
        'password' => 'required|min:8|max:255',
        'enabled' => 'boolean',
    ];

    /**
     * MailUserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct(MailUser::class);
    }

    /**
     * @param MailDomain $domain
     * @return \Illuminate\View\View
     */
    public function users(MailDomain $domain)
    {
        return view('sections.mail.users', compact('domain'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!is_null($domainId = $request->query('domain'))) {
            return api_response()->success(MailDomain::findOrFail($domainId)->users->toArray())->response();
        }

        return parent::index($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $mailUser = MailUser::create([
            'domain_id' => $request->get('domain_id'),
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'enabled' => $request->get('enabled', true),
        ]);

        return api_response()->success(['id' => $mailUser->id])->response();
    }
}
