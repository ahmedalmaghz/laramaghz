<?php

namespace Almaghz\Laramaghz\Laramaghz\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use Almaghz\Laramaghz\Laramaghz\Models\Module;

class ApiRouteCommand extends Command
{

    protected $DS = DIRECTORY_SEPARATOR;

    protected $filesystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laramaghz:route_api {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We now generate api route file based on module name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $moduleName = $this->argument('module');

        $module = Module::where('name' , $moduleName)->first();

        $nameSpace = 'App\\Modules\\'.$module->name.'\\Http\\Controllers\\Api';

        $this->filesystem->put(
            fixPath(base_path('app/Modules/'.$module->name.'/Routes/api.php'))
            , $this->buildFile($module->name , $nameSpace)
        );

    }

    /*
     * get file
     */

    protected function getStub(){
        return __DIR__.'/../../stubs/routes/api.stub';
    }

    /*
     * replace  stub file with data
     */

    protected function buildFile($name , $className){

        $stub = $this->filesystem->get($this->getStub());

        return $this->replaceContent($stub , $name)->replaceName($stub, $className);

    }

    /**
     * Replace content of migration
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */

    protected function replaceContent(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyUrl' , 'DummyControllerName'],
            [ mb_strtolower($name) , $name ],
            $stub
        );
        return $this;
    }

    /**
     * Replace table name
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceName($stub, $name)
    {
        return str_replace('DummyNameSpace', $name, $stub);
    }





}
