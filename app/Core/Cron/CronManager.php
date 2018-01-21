<?php

namespace Richardds\ServerAdmin\Core\Cron;

use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\Core\SystemUser;
use Richardds\ServerAdmin\Cron;

class CronManager
{
    protected $cronConfigFolder = '/var/spool/cron/crontabs';

    public function generate()
    {
        $tasksUsers = Cron::whereEnabled(true)->select('uid')->distinct()->get();

        foreach ($tasksUsers as $tasksUser) {
            $user = SystemUser::getById($tasksUser->uid);

            $userTasks = Cron::whereEnabled(true)->where('uid', '=', $user->getUid())->get();

            $cronConfig = new ConfigIo($this->cronConfigFolder . '/' . $user->getName());
            $cronConfig->truncate();

            foreach ($userTasks as $userTask) {
                $interval = $userTask->getInterval();
                $cronConfig->writeln("{$interval->getMinute()} {$interval->getHour()} {$interval->getDay()} {$interval->getMonth()} {$interval->getWeekday()} {$userTask->command}");
            }
        }
    }
}
