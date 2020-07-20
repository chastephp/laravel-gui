<?php

namespace ChastePhp\LaravelGUI\Console;

use Illuminate\Console\Command;

class GuiCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'gui';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A laravel web UI';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            system('cmd /c start /b http://127.0.0.1:8000/' . config('gui.route.prefix'));
        } else if (PHP_OS_FAMILY === 'Darwin') {
            system('open http://127.0.0.1:8000/' . config('gui.route.prefix'));
        }
        $this->call('serve');
    }
}