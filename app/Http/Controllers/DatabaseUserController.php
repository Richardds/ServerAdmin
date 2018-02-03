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
            'user' => 'required|min:1|max:255',
            'host' => 'required|min:1|max:255',
            'password' => 'required|min:1|max:255',
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
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function destroy(string $user)
    {
        $this->manager->dropUser(DatabaseUser::fromSingleString($user));

        return api_response()->success()->response();
    }
}
