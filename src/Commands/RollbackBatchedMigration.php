<?php

namespace Mombuyish\BatchMigration\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class RollbackBatchedMigration extends Command
{
    use ConfirmableTrait, mapPathTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:batch-rollback {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last database migration (including depth directories)';

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
     * @return void
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $callback = function($path) {
            $this->call('migrate:rollback', [
                '--path' => $path
            ]);
        };

        array_map($callback, $this->mapDirectoryPaths('rseq'));

        $this->call('migrate:rollback');
    }
}
