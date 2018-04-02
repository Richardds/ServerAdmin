<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Http\CrudAssistance;
use Richardds\ServerAdmin\Site;

class SiteController extends Controller
{
    use CrudAssistance;

    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->manager = $manager;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function sites()
    {
        return view('sections.sites.sites');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return api_response()->success(Site::all()->toArray())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:255', 'unique:sites,name'],
            'enable_php' => ['boolean'],
            'ssl_certificate' => ['string', 'max:255'],
            'ssl_key' => ['string', 'max:255'],
            'enabled' => ['boolean'],
        ]);

        $site = Site::create([
            'name' => $request->get('name'),
            'enable_php' => $request->get('enable_php', false),
            'enabled' => $request->get('enabled', true),
        ]);

        //$this->manager->configure();
        //$this->manager->reload();

        return api_response()->success(['id' => $site->id])->response();
    }

    /**
     * @param \Richardds\ServerAdmin\Site $site
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Site $site)
    {
        return api_response()->success($site->toArray())->response();
    }

    /**
     * @param Request $request
     * @param Site $site
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Site $site)
    {
        $rules = [
            'name' => ['max:255', 'unique:sites,name'],
            'enable_php' => ['boolean'],
            'ssl_certificate' => ['string', 'max:255'],
            'ssl_key' => ['string', 'max:255'],
            'enabled' => ['boolean'],
        ];

        $this->validate($request, $rules);
        $this->updateModel($site, $request, array_keys($rules));
        $site->save();

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success($site->toArray())->response();
    }

    /**
     * @param Site $site
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Site $site)
    {
        $site->delete();

        $this->manager->configure();
        $this->manager->reload();

        return api_response()->success()->response();
    }
}
