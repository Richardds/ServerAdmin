<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\MailAlias;
use Richardds\ServerAdmin\MailUser;

class MailAliasController extends ModelController
{
    protected $rules = [
        'domain_id' => 'required|exists:mail_domains,id',
        'user_id' => 'required|exists:mail_users,id',
        'alias' => 'required|min:1|max:255',
    ];

    /**
     * MailUserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct(MailAlias::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!is_null($userId = $request->query('user'))) {
            return api_response()->success(MailUser::findOrFail($userId)->aliases->toArray())->response();
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

        $mailAlias = MailAlias::create([
            'domain_id' => $request->get('domain_id'),
            'user_id' => $request->get('user_id'),
            'alias' => $request->get('alias'),
        ]);

        return api_response()->success(['id' => $mailAlias->id])->response();
    }
}
