<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Richardds\ServerAdmin\Core\Database\DatabaseManager;
use Richardds\ServerAdmin\Core\SystemUser;

class DataController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function systemUsers()
    {
        $data = [];
        $list = SystemUser::list();

        foreach ($list as $name) {
            $user = SystemUser::getByName($name);
            $data[] = [
                'id' => $user->getUid(),
                'name' => $user->getName()
            ];
        }
        
        return api_response()->success($data)->response();
    }

    /**
     * @param DatabaseManager $manager
     * @return \Illuminate\Http\JsonResponse
     */
    public function databaseAvailableCollations(DatabaseManager $manager)
    {
        return api_response()->success($manager->getAvailableCollations())->response();
    }
}
