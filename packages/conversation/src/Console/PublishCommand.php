<?php

namespace Nahidferdous\Conversation\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversation:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the conversation assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('force')) {
            $this->call('vendor:publish', [
                '--tag' => 'conversation-config',
                '--force' => true,
            ]);

            $this->call('vendor:publish', [
                '--tag' => 'conversation-migrations',
                '--force' => true,
            ]);

            $this->call('vendor:publish', [
                '--tag' => 'conversation-models',
                '--force' => true,
            ]);
        }

        $this->call('vendor:publish', [
            '--tag' => 'conversation-views',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'conversation-assets',
            '--force' => true,
        ]);
    }
}
