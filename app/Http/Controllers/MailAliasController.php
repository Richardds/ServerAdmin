<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailAlias;

class MailAliasController extends ModelController
{
    protected $rules = [
        'domain_id' => 'required|exists:mail_domains,id',
        'source' => 'required|min:1|max:255',
        'destination' => 'required|min:1|max:255',
    ];

    /**
     * MailUserController constructor.
     */
    public function __construct()
    {
        parent::__construct(MailAlias::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $mailAlias = MailAlias::create([
            //
        ]);

        return api_response()->success(['id' => $mailAlias->id])->response();
    }
}
