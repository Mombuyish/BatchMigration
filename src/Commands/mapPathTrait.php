<?php
namespace Mombuyish\BatchMigration\Commands;

use File;

trait mapPathTrait
{
    public function mapDirectoryPaths($sort = 'seq')
    {
        $paths = [];

        foreach (File::directories(base_path(config('batch-migration.path'))) as $dir) {
            $paths[] = config('batch-migration.path') . DIRECTORY_SEPARATOR . File::basename($dir) . DIRECTORY_SEPARATOR;
        }

        if ($sort == 'rseq') {
            //Reverse to rollback.
            krsort($paths);
        }

        return $paths;
    }
}