<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailDomain;

class MailDomainController extends ModelController
{
    protected $rules = [
        'name' => ['required', 'max:255'],
    ];

    /**
     * MailDomainController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct(MailDomain::class);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function domains()
    {
        return view('sections.mail.domains');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $mailDomain = MailDomain::create([
            'name' => $request->get('name'),
        ]);

        return api_response()->success(['id' => $mailDomain->id])->response();
    }
}
