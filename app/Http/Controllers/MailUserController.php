<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailUser;

class MailUserController extends ModelController
{
    protected $rules = [
        'domain_id' => 'required|exists:mail_domains,id',
        'username' => 'required|min:1|max:255',
        'password' => 'required|min:1|max:255',
    ];

    /**
     * MailUserController constructor.
     */
    public function __construct()
    {
        parent::__construct(MailUser::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $mailUser = MailUser::create([
            //
        ]);

        return api_response()->success(['id' => $mailUser->id])->response();
    }
}
