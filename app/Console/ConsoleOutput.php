<?php

namespace App\Console;

use InvalidArgumentException;
use Symfony\Component\Console\Output\ConsoleOutput as SymfonyConsoleOutput;
use Throwable;

class ConsoleOutput
{
    protected SymfonyConsoleOutput $output;

    public function __construct()
    {
        $this->output = new SymfonyConsoleOutput;
    }

    /**
     * Dynamically handle calls into the console output instance.
     *
     * @param  array<string>  $parameters
     * @return mixed
     *
     * @throws InvalidArgumentException|Throwable
     */
    public function __call(string $method, array $parameters)
    {
        $component = '\Illuminate\Console\View\Components\\'.ucfirst($method);

        throw_unless(class_exists($component),
        InvalidArgumentException::class,
        sprintf(
            'Console component [%s] not found.', $method
        ));

        return (new $component($this->output))->render(...$parameters);
    }
}
