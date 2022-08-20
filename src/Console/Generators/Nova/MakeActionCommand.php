<?php

namespace Idel\Modular\Console\Generators\Nova;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\{InputArgument , InputOption};
use Illuminate\Filesystem\Filesystem;

class MakeActionCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:nova-action     
        {slug : The slug of the module.}
        {name : The name of the nova action class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module nova action class.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('slug');

        $action = $this->argument('name');

        $studlyModule = Str::studly($name);

        $studlyName = Str::studly($action);

        $namespace = "App\\{$studlyModule}";

        $directionModule = module_path($module , 'src');

        $template = str_replace([
            '{{studlyName}}',
            '{{namespace}}',
        ],[
            $studlyName,
            $namespace,
        ], file_get_contents($this->getStub()));

        if (!$this->files->isDirectory("{$directionModule}/Actions")) {

            $this->files->makeDirectory("{$directionModule}/Actions",0755, true);
        }

        file_put_contents("{$directionModule}/Actions/{$studlyName}.php" ,$template);

        $this->info("Nova action $studlyName has been created!");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../../../stubs/nova/novaAction.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Nova action name'],
            ['slug', InputArgument::REQUIRED, 'Module name']
        ];
    }
}