<?php

namespace Almaghz\Laramaghz\Laramaghz\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Support\Facades\Artisan;
use Almaghz\Laramaghz\Laramaghz\Traits\FileTrait;
use Almaghz\Laramaghz\Laramaghz\Traits\SeedsTrait;


class InstallCommand extends Command
{

    use SeedsTrait, FileTrait;

    protected $DS = DIRECTORY_SEPARATOR;

    protected $filesystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laramaghz:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laramaghz';

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

        Artisan::call('migrate');

        Artisan::call('storage:link');

        //  Artisan::call('make:auth');

        Artisan::call('ui bootstrap --auth');

        Artisan::call('ui:controllers');

        Artisan::call('adminlte:install');

        $path = base_path('database' . $this->DS . 'seeds' . $this->DS);

        $name = '';

        $this->filesystem->put(
            fixPath($path . 'DatabaseSeeder.php'),
            $this->buildFile($this->getEditStub(), $name)
        );

        $this->filesystem->put(
            fixPath(app_path('Http/Controllers/Auth/RegisterController.php')),
            $this->buildFile($this->getRegisterControllerStub(), $name)
        );

        $this->filesystem->put(
            fixPath(base_path('resources/views/layouts/app.blade.php')),
            $this->buildFile($this->getAppStub(), $name)
        );


        $this->filesystem->put(
            fixPath(base_path('config/laramaghz.php')),
            $this->buildFile($this->getConfigStub(), $name)
        );

        $this->filesystem->put(
            fixPath(base_path('config/laravellocalization.php')),
            $this->buildFile($this->getLangStub(), $name)
        );

        $this->filesystem->put(
            fixPath(base_path('config/app.php')),
            $this->buildFile($this->getProviderStub(), $name)
        );

        $this->filesystem->put(
            fixPath(base_path('app/Http/Kernel.php')),
            $this->buildFile($this->getKernelStub(), $name)
        );

        /*
         * seed data
         */

        Artisan::call('db:seed');
    }


    /*
     * get file
     */

    protected function getEditStub()
    {
        return __DIR__ . '/../../stubs/install/database-seeder.stub';
    }

    /*
     * get file
     */

    protected function getRegisterControllerStub()
    {
        return __DIR__ . '/../../stubs/install/register-controller.stub';
    }


    /*
    * get config file
    */

    protected function getConfigStub()
    {
        return __DIR__ . '/../../stubs/config/laramaghz.stub';
    }

    /*
    * get kernel file
    */

    protected function getKernelStub()
    {
        return __DIR__ . '/../../stubs/install/kernel.stub';
    }

    /*
    * get Providers file
    */

    protected function getProviderStub()
    {
        return __DIR__ . '/../../stubs/install/config/app.stub';
    }

    /*
    * get Providers file
    */

    protected function getLangStub()
    {
        return __DIR__ . '/../../stubs/install/config/laravellocalization.stub';
    }

    /*
    * get App  file
    */

    protected function getAppStub()
    {
        return __DIR__ . '/../../stubs/install/app.stub';
    }

    /*
     * replace  stub file with data
     */

    protected function buildFile($stub, $name)
    {

        $stub = $this->filesystem->get($stub);

        return $this->replaceName($stub, $name);
    }

    /**
     * Replace table name
     *
     * @param  string $stub
     * @param  string $name
     * @return string
     */

    protected function replaceName($stub, $name)
    {
        return str_replace('DummyName', $name, $stub);
    }
}
