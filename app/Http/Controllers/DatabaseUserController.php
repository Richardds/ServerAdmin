<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Richardds\ServerAdmin\Core\Database\DatabaseManager;
use Richardds\ServerAdmin\Core\Database\DatabaseUser;

class DatabaseUserController extends Controller
{
    /**
     * @var \Richardds\ServerAdmin\Core\Database\DatabaseManager
     */
    private $manager;

    /**
     * DatabaseUserController constructor.
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
    public function users()
    {
        return view('sections.database.users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function grantPrivileges(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'user' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_\.@:]+$/'],
        ]);

        $this->manager->grantPrivileges($request->get('name'), DatabaseUser::fromSingleString($request->get('user')));

        return api_response()->success()->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function revokePrivileges(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'user' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_\.@:]+$/'],
        ]);

        $this->manager->revokePrivileges($request->get('name'), DatabaseUser::fromSingleString($request->get('user')));

        return api_response()->success()->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_\.@:]+$/'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $this->manager->changeUserPassword(DatabaseUser::fromSingleString($request->get('user')), $request->get('password'));

        return api_response()->success()->response();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return api_response()->success($this->manager->getAvailableUsers())->response();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'host' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_]+$/'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $this->manager->createUser(new DatabaseUser(
            $request->get('user'),
            $request->get('host'),
            $request->get('password')
        ));

        return api_response()->success()->response();
    }

    /**
     * @param string $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function destroy(string $user)
    {
        validate($user, [['string', 'max:255', 'regex:/^[a-z0-9_\.@:]+$/']], 'user');

        $this->manager->dropUser(DatabaseUser::fromSingleString($user));

        return api_response()->success()->response();
    }
}
