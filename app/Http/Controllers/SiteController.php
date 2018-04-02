<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Sites\SitesManager;
use Richardds\ServerAdmin\Http\CrudAssistance;
use Richardds\ServerAdmin\Site;
use Richardds\ServerAdmin\SiteSSL;

class SiteController extends Controller
{
    use CrudAssistance;

    /**
     * @var \Richardds\ServerAdmin\Core\Sites\SitesManager
     */
    private $manager;

    /**
     * SiteController constructor.
     * @param SitesManager $manager
     */
    public function __construct(SitesManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;
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
        return api_response()->success(Site::allWithSSL())->response();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:255', 'unique:sites,name'],
            'php_enabled' => ['boolean'],
            'enabled' => ['boolean'],
        ]);

        $site = Site::create([
            'name' => $request->get('name'),
            'php_enabled' => $request->get('php_enabled', false),
            'enabled' => $request->get('enabled', true),
        ]);

        if ($request->exists('ssl_certificate') || $request->exists('ssl_key')) {
            $this->validate($request, [
                'ssl_certificate' => ['required', 'string', 'max:255'],
                'ssl_key' => ['required', 'string', 'max:255'],
                'ssl_enabled' => ['boolean'],
            ]);

            SiteSSL::create([
                'site_id' => $site->id,
                'certificate' => $request->get('ssl_certificate'),
                'key' => $request->get('ssl_key'),
                'enabled' => $request->get('ssl_enabled', true),
            ]);
        }

        $this->manager->configure();
        $this->manager->reload();

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
            'php_enabled' => ['boolean'],
            'enabled' => ['boolean'],
        ];

        $this->validate($request, $rules);
        $this->updateModel($site, $request, array_keys(['name', 'php_enabled', 'enabled']));
        $site->save();

        if ($request->exists('ssl_enabled')
            || $request->exists('ssl_certificate')
            || $request->exists('ssl_key')) {
            $this->validate($request, [
                'ssl_certificate' => ['required', 'string', 'max:255'],
                'ssl_key' => ['required', 'string', 'max:255'],
                'ssl_enabled' => ['boolean'],
            ]);

            $ssl = SiteSSL::whereSiteId($site->id)->first();

            if (is_null($ssl)) {
                // error
            }

            $this->updateModel($ssl, $request, array_keys(['ssl_enabled', 'ssl_certificate', 'ssl_key']));
            $ssl->save();
        }


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
