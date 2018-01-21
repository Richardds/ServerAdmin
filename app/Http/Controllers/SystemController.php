<?php

namespace Richardds\ServerAdmin\Http\Controllers;

use Richardds\ServerAdmin\Core\SystemUser;

class SystemController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
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
}
