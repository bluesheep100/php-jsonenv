<?php

namespace JsonEnv;

use ErrorException;

class JsonEnv
{
    protected $envFile = 'env.json';

    protected $env;

    /**
     * @param string|null $envFile The relative filename of the environment file, e.g 'env.json'
     */
    public function __construct(?string $envFile = null)
    {
        if ($envFile !== null) {
            $this->envFile = $envFile;
        }
    }

    /**
     * Returns the loaded environment variables.
     * Only use this if you can/will not use $_ENV or the env helper
     *
     * @param string|null $key
     * @return array
     */
    public function getEnv(?string $key = null): array
    {
        if ($key === null) {
            return $this->env;
        }

        return $this->env[$key];
    }

    /**
     * Loads the environment variables listed in
     *
     * @return void
     * @throws ErrorException
     */
    public function load(): void
    {
        // Read the config file
        $file = file_get_contents($this->envFile);

        // Attempt decoding
        if (($vars = json_decode($file, true)) !== null) {
            $this->env = $vars;
            $_ENV = array_merge($_ENV, $vars);

            return;
        }

        throw new ErrorException();
    }
}
