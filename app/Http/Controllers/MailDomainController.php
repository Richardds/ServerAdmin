<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailDomain;

class MailDomainController extends ModelController
{
    protected $rules = [
        'domain' => 'required|min:1|max:255',
    ];

    /**
     * MailDomainController constructor.
     */
    public function __construct()
    {
        parent::__construct(MailDomain::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $mailDomain = MailDomain::create([
            //
        ]);

        return api_response()->success(['id' => $mailDomain->id])->response();
    }
}
