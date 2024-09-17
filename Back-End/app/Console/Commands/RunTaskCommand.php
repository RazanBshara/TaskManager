<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Workspace;
use App\Traits\TaskRun;

class RunTaskCommand extends Command
{
    use TaskRun;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command to rin the Tasks with Ready status';

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
     *
     * @return int
     */
    public function handle()
    {        
        $this->jobrunforApprovedAndConfirmedtasks();
        
        return 0;
    }
}
