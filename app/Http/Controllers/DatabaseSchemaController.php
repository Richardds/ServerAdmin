<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Database\DatabaseManager;
use Richardds\ServerAdmin\Core\Database\SchemaInfo;

class DatabaseSchemaController extends Controller
{
    /**
     * @var \Richardds\ServerAdmin\Core\Database\DatabaseManager
     */
    private $manager;

    /**
     * DatabaseSchemaController constructor.
     *
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->middleware('auth');
        $this->manager = $manager;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function databases()
    {
        return view('sections.database.schemas');
    }

    public function users()
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /**
         * @var SchemaInfo[] $databases
         */
        $databases = [];
        $databaseNames = $this->manager->getDatabases();

        foreach ($databaseNames as $databaseName) {
            $databases[] = $this->manager->getDatabaseInfo($databaseName)->toArray();
        }

        return api_response()->success($databases)->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:255',
            'character_set' => 'min:1|max:255',
            'collation' => 'min:1|max:255',
        ]);

        $name = $request->get('name');

        $this->manager->createDatabase($name, $request->get('character_set'), $request->get('collation'));

        return api_response()->success($this->manager->getDatabaseInfo($name))->response();
    }

    /**
     * @param string $database
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $database)
    {
        return api_response()->success($this->manager->getDatabaseInfo($database))->response();
    }

    /**
     * @param string $database
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $database)
    {
        $this->manager->dropDatabase($database);

        return api_response()->success()->response();
    }
}
