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

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
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
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'character_set' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'collation' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
        ]);

        $name = $request->get('name');

        $this->manager->createDatabase($name, $request->get('character_set'), $request->get('collation'));

        return api_response()->success($this->manager->getDatabaseInfo($name)->toArray())->response();
    }

    /**
     * @param string $database
     * @return \Illuminate\Http\JsonResponse
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function show(string $database)
    {
        return api_response()->success($this->manager->getFullDatabaseInfo($database)->toArray())->response();
    }

    /**
     * @param string $database
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function destroy(string $database)
    {
        validate($database, [['string', 'max:255', 'regex:/^[a-z0-9_]+$/']], 'database');

        $this->manager->dropDatabase($database);

        return api_response()->success()->response();
    }
}
