<?php


namespace App\Console\Commands;
use App\Helpers\LanguageResourceHelper;
use Illuminate\Console\Command;

class CompileLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:generate {source} {--rv|replace-view=false} {--cv|compile-reverse=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate language resource file from excel';

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
     * @return mixed
     */
    public function handle()
    {
        $sourcePath = $this->arguments('source')['source'];
        $replaceView = $this->option('replace-view');
        $reverse = $this->option('compile-reverse');

        $helper = new LanguageResourceHelper();
        $helper->generateFromExcel($sourcePath, $replaceView, $reverse);
    }
}
