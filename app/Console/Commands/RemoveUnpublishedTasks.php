<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use function now;

class RemoveUnpublishedTasks extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remove {publish=3YearsAgo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove unpublished tasks';

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
        $publishedAt = $this->argument('publish') == '3YearsAgo' ? now()->subYears(3) : now()->subYears(5);
        Task::where('published_at', '<', $publishedAt)->delete();
    }
}
