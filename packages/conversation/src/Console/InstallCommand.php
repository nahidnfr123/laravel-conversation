<?php

namespace Nahidferdous\Conversation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversation:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Conversation package';

    /**
     * Check Laravel version.
     *
     * @var bool
     */
    private bool $isV8;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->isV8 = explode('.', app()->version())[0] >= 8;

        $this->info('Installing Conversation...');

        $this->line('----------');
        $this->line('Configurations...');
        $this->modifyModelsPath('/../Http/Controllers/ConversationController.php', 'User');
        $this->modifyModelsPath('/../Http/Controllers/ConversationController.php', 'CFavourite');
        $this->modifyModelsPath('/../Http/Controllers/ConversationController.php', 'CMessage');
        $this->modifyModelsPath('/../Http/Controllers/Api/ConversationController.php', 'User');
        $this->modifyModelsPath('/../Http/Controllers/Api/ConversationController.php', 'CFavorite');
        $this->modifyModelsPath('/../Http/Controllers/Api/ConversationController.php', 'CMessage');
        $this->modifyModelsPath('/../Conversation.php', 'CFavorite');
        $this->modifyModelsPath('/../Conversation.php', 'CMessage');
        $this->modifyModelsPath('/../Models/CFavourite.php');
        $this->modifyModelsPath('/../Models/CMessage.php');
        $this->info('[✓] done');

        $assetsToBePublished = [
            'config' => config_path('conversation.php'),
            'views' => resource_path('views/vendor/Conversation'),
            'assets' => public_path('css/conversation'),
            'models' => app_path(($this->isV8 ? 'Models/' : '') . 'CMessage.php'),
            'migrations' => database_path('migrations/2023_08_11_155144_create_c_messages_table.php'),
        ];

        foreach ($assetsToBePublished as $target => $path) {
            $this->line('----------');
            $this->process($target, $path);
        }

        $this->line('----------');
        $this->line('Creating storage symlink...');
        Artisan::call('storage:link');
        $this->info('[✓] Storage linked.');

        $this->line('----------');
        $this->info('[✓] Conversation installed successfully');
    }

    /**
     * Modify models imports/namespace path according to Laravel version.
     *
     * @param string $targetFilePath
     * @param string|null $model
     * @return void
     */
    private function modifyModelsPath(string $targetFilePath, string $model = null): void
    {
        $path = realpath(__DIR__ . $targetFilePath);
        $contents = File::get($path);
        $model = !empty($model) ? '\\' . $model : ';';
        $contents = str_replace(
            (!$this->isV8 ? 'App\Models' : 'App') . $model,
            ($this->isV8 ? 'App\Models' : 'App') . $model,
            $contents
        );
        File::put($path, $contents);
    }

    /**
     * Check, publish, or overwrite the assets.
     *
     * @param string $target
     * @param string $path
     * @return void
     */
    private function process(string $target, string $path): void
    {
        $this->line('Publishing ' . $target . '...');
        if (!File::exists($path)) {
            $this->publish($target);
            $this->info('[✓] ' . $target . ' published.');
            return;
        }
        if ($this->shouldOverwrite($target)) {
            $this->line('Overwriting ' . $target . '...');
            $this->publish($target, true);
            $this->info('[✓] ' . $target . ' published.');
            return;
        }
        $this->line('[-] Ignored, The existing ' . $target . ' was not overwritten');
    }

    /**
     * Ask to overwrite.
     *
     * @param string $target
     * @return bool
     */
    private function shouldOverwrite(string $target): bool
    {
        return $this->confirm(
            $target . ' already exists. Do you want to overwrite it?',
            false
        );
    }

    /**
     * Call the publish command.
     *
     * @param string $tag
     * @param bool $forcePublish
     * @return void
     */
    private function publish(string $tag, bool $forcePublish = false): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'conversation-' . $tag,
            '--force' => $forcePublish,
        ]);
    }
}
