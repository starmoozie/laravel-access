<?php

namespace Starmoozie\LaravelAccess;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\{
    Facades\Request,
    Facades\Artisan,
    Facades\Event,
    ServiceProvider,
    Str
};
use Starmoozie\LaravelAccess\app\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

final class LaravelAccessServiceProvider extends ServiceProvider
{
    protected $seeds_path = '/database/seeders';
    protected $migration_path = '/database/migrations';
    protected $route_path = '/routes/laravel-access.php';
    protected $config_path = '/config/laravel-access.php';

    public function boot()
    {
        $this->loadReources();
        $this->customBinding();
        $this->addSeedsAfterConsoleCommandStarting();
        $this->setupRoutes();
        $this->publishFiles();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . $this->config_path, 'laravel-access');
    }

    /**
     * Register app binding
     */
    private function customBinding(): void
    {
        // Binding custom exception handler
        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );
    }

    /**
     * Load all package resources
     */
    private function loadReources(): void
    {
        app()->config['auth.guards'] = $this->passportGuard();

        $this->loadRoutesFrom(__DIR__ . $this->route_path);
        $this->loadMigrationsFrom(realpath(__DIR__ . $this->migration_path));
        $this->loadTranslationsFrom(realpath(__DIR__ . '/lang'), 'laravel-access-trans');
    }

    /**
     * Merge existing guards with laravel-access guards
     */
    private function passportGuard(): array
    {
        return [
            ...app()->config['auth.guards'],
            ...config('laravel-access.guards')
        ];
    }

    /**
     * Get a value that indicates whether the current command in console
     * contains a string in the specified $fields.
     */
    protected function isConsoleCommandContains(string|array $contain_options, string|array $exclude_options = null): bool
    {
        $args = Request::server('argv', null);
        if (is_array($args)) {
            $command = implode(' ', $args);
            if (
                Str::contains($command, $contain_options) &&
                ($exclude_options == null || !Str::contains($command, $exclude_options))
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Add seeds from the $seed_path after the current command in console finished.
     */
    protected function addSeedsAfterConsoleCommandStarting(): void
    {
        if ($this->app->runningInConsole() && $this->isConsoleCommandContains(['db:seed', '--seed'], ['--class', 'help', '-h'])) {
            Event::listen(CommandFinished::class, function (CommandFinished $event) {
                // Accept command in console only
                if ($event->output instanceof ConsoleOutput) {
                    $this->addSeedsFrom(__DIR__ . $this->seeds_path);
                }
            });
        }
    }

    /**
     * Register seeds.
     */
    protected function addSeedsFrom(string $seeds_path): void
    {
        $file_names = glob($seeds_path . '/DatabaseSeeder.php');

        foreach ($file_names as $filename) {
            $classes = $this->getClassesFromFile($filename);
            foreach ($classes as $class) {
                echo "\033[1;33mSeeding:\033[0m {$class}\n";
                $startTime = microtime(true);
                Artisan::call('db:seed', ['--class' => $class, '--force' => '']);
                $runTime = round(microtime(true) - $startTime, 2);
                echo "\033[0;32mSeeded:\033[0m {$class} ({$runTime} seconds)\n";
            }
        }
    }

    /**
     * Get full class names declared in the specified file.
     */
    private function getClassesFromFile(string $filename): array
    {
        // Get namespace of class
        $namespace = "";
        $lines = file($filename);
        $namespaceLines = preg_grep('/^namespace /', $lines);

        if (is_array($namespaceLines)) {
            $namespaceLine = array_shift($namespaceLines);
            $match = array();
            preg_match('/^namespace (.*)$/', $namespaceLine, $match);
            $namespace = str_replace(["\r", ";"], '', array_pop($match));
        }

        // Get array name of all class has in the file.
        $classes  = array();
        $php_code = file_get_contents($filename);
        $tokens   = token_get_all($php_code);
        $count    = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];
                if ($namespace !== "") {
                    $classes[] = $namespace . "\\$class_name";
                } else {
                    $classes[] = $class_name;
                }
            }
        }

        return $classes;
    }

    /**
     * All files to publish
     */
    public function publishFiles(): void
    {
        $starmoozie_custom_routes_file = [__DIR__ . $this->route_path => base_path($this->route_path)];
        $starmoozie_lang_files = [__DIR__ . '/lang' => app()->langPath() . '/vendor/starmoozie'];
        $migration_files = [__DIR__ . $this->seeds_path => database_path('migrations')];
        $starmoozie_config_files = [__DIR__ . '/config' => config_path()];

        // register all possible publish commands and assign tags to each
        $this->publishes($starmoozie_custom_routes_file, 'laravel-access-routes');
        $this->publishes($starmoozie_config_files, 'laravel-access-config');
        $this->publishes($starmoozie_lang_files, 'laravel-access-lang');
        $this->publishes($migration_files, 'laravel-access-migration');
    }

    /**
     * Load routes file.
     */
    public function setupRoutes(): void
    {
        if (file_exists(base_path() . $this->route_path)) {
            $this->loadRoutesFrom(base_path() . $this->route_path);
        }
    }
}
