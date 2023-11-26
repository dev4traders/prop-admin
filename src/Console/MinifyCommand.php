<?php

namespace Dcat\Admin\Console;

use Dcat\Admin\Support\Helper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class MinifyCommand extends Command
{
    const ALL = 'all';
    const DEFAULT = 'default';

    protected $signature = 'admin:minify {name}
        {--publish : Publish assets files}';

    protected $description = 'Minify the CSS and JS';

    protected array $themes = [
        'default',
        'raspberry',
        'theme-semi-dark'
    ];

    protected string $packagePath;

    protected Filesystem $files;

    public function handle() : void
    {
        $this->packagePath = realpath(__DIR__.'/../..');
        $this->files = $this->laravel['files'];

        $name = $this->argument('name');

        if ($name === static::ALL) {
            $this->compileAllThemes();
            return;
        }

        $publish = $this->option('publish');

        $this->backupFiles();
        $this->replaceFiles($name);

        try {
            $this->npmInstall();

            $this->info("[$name] npm run production...");

            // 编译
            $this->runProcess("cd {$this->packagePath} && npm run prod", 1800);

            if ($publish) {
                $this->publishAssets();
            }
        } finally {
            $this->resetFiles();
        }
    }

    protected function compileAllThemes() : void
    {
        foreach ($this->themes as $name) {
            $this->call('admin:minify', ['name' => $name]);
        }
    }

    protected function publishAssets() : void
    {
        $options = ['--provider' => 'Dcat\Admin\AdminServiceProvider', '--force' => true, '--tag' => 'dcat-admin-assets'];

        $this->call('vendor:publish', $options);
    }

    protected function replaceFiles(string $name) : void
    {
        if ($name === static::DEFAULT) {
            return;
        }

        $mixFile = $this->getMixFile();
        $contents = str_replace('let theme = null', "let theme = '{$name}'", $this->files->get($mixFile));

        $this->files->put($mixFile, $contents);
    }

    protected function backupFiles() : void
    {
        if (! is_file($this->getMixBakFile())) {
            $this->files->copy($this->getMixFile(), $this->getMixBakFile());
        } else {
            $this->files->delete($this->getMixFile());
            $this->files->copy($this->getMixBakFile(), $this->getMixFile());
        }
    }

    protected function resetFiles() : void
    {
        $mixFile = $this->getMixFile();
        $mixBakFile = $this->getMixBakFile();

        if (is_file($mixBakFile)) {
            $this->files->delete($mixFile);
            $this->files->copy($mixBakFile, $mixFile);
            $this->files->delete($mixBakFile);
        }
    }

    protected function getMixFile() : string
    {
        return $this->packagePath.'/webpack.mix.js';
    }

    protected function getMixBakFile() : string
    {
        return str_replace('.js', '.bak.js', $this->getMixFile());
    }

    protected function npmInstall() : void
    {
        if (is_dir($this->packagePath.'/node_modules')) {
            return;
        }

        $this->info('npm install...');

        //$this->runProcess("cd {$this->packagePath} && npm install"); //todo::fix, somewhy npm install does not work. using yarn
        $this->runProcess("cd {$this->packagePath} && yarn");
    }

    protected function runProcess($command, $timeout = 1800) : void
    {
        $process = Helper::process($command, $timeout);

        $process->run(function ($type, $data) {
            if ($type === Process::ERR) {
                $this->warn($data);
            } else {
                $this->info($data);
            }
        });
    }
}
