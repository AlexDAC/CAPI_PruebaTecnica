<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputArgument;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create the database for migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::connection()
            ->statement('CREATE DATABASE IF NOT EXISTS '.$this->argument('name'));
            $this->putDBNametoEnv('DB_DATABASE', $this->argument('name'));
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the database'],
        ];
    }

    private function putDBNametoEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
