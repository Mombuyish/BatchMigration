<?php

namespace Mombuyish\BatchMigration\Commands;

use File;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Console\Command;

class BatchMigration extends Command
{
    use ConfirmableTrait, mapPathTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:batch {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations (including depth dictionaries)';

    /**
     * Create a new command instance.
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

        $this->call('migrate');

        $callback = function($path) {
            $this->call('migrate', [
                '--path' => $path
            ]);
        };

        array_map($callback, $this->mapDirectoryPaths('seq'));
    }
}
