<?php

namespace Richardds\ServerAdmin\Core\Tasks;

use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\Core\ConfigurableService;
use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\Core\SystemUser;
use Richardds\ServerAdmin\Cron;
use Richardds\ServerAdmin\Facades\Execute;

class TaskManager extends Service implements ConfigurableService
{
    const CRON_CONFIG_FOLDER = '/var/spool/cron/crontabs';

    public function __construct()
    {
        parent::__construct('cron');
    }

    public function configure()
    {
        Execute::withoutOutput('rm -f ' . self::CRON_CONFIG_FOLDER . '/*', true);

        $tasksUsers = Cron::enabled()->distinct()->get(['uid']);

        foreach ($tasksUsers as $tasksUser) {
            $user = SystemUser::getById($tasksUser->uid);

            $userTasks = Cron::enabled()->whereUid($user->getUid())->get();

            $cronConfig = new ConfigIo(self::CRON_CONFIG_FOLDER . '/' . $user->getName(), 600);
            $cronConfig->truncate();

            foreach ($userTasks as $userTask) {
                $interval = $userTask->getInterval();
                $cronConfig->writeln("{$interval->getMinute()} {$interval->getHour()} {$interval->getDay()} {$interval->getMonth()} {$interval->getWeekday()} {$userTask->command}");
            }
        }
    }
}
