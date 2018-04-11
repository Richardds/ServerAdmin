<?php

namespace Richardds\ServerAdmin\Console\Commands;

use Illuminate\Console\Command;
use Richardds\ServerAdmin\User;

class AdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes administrator password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = $this->secret('New password');
        $confirmed_password = $this->secret('Confirm password');

        if ($password != $confirmed_password) {
            $this->error('Passwords do not match!');
            return;
        }

        $admin = User::admin();
        $admin->password = $password;
        $admin->save();

        $this->info('Password successfully changed.');
    }
}
