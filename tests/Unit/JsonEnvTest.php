<?php

namespace Tests\Unit;

use JsonEnv\JsonEnv;
use PHPUnit\Framework\TestCase;

final class JsonEnvTest extends TestCase
{
    protected static $defaultFile = './env.json';

    protected static $nonDefaultFile = '/testing.json';

    protected function setUp(): void
    {
        parent::setUp();

        file_put_contents(static::$defaultFile, json_encode(['FOO' => 'bar']));
        file_put_contents(__DIR__ . static::$nonDefaultFile, json_encode(['FOO' => 'bar']));
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        unlink('./env.json');
        unlink(__DIR__ . '/testing.json');
    }

    /** @test */
    public function can_load_environment_variables_from_default_file_location()
    {
        $env = new JsonEnv();
        $env->load();

        $this->assertArrayHasKey('FOO', $_ENV);
        $this->assertEquals('bar', $_ENV['FOO']);
    }

    /** @test */
    public function can_get_readonly_array_of_environment_variables_from_jsonenv_instance()
    {
        // Create a config for testing
        file_put_contents('./env.json', json_encode(['FOO' => 'bar']));

        $env = new JsonEnv();
        $env->load();

        $vars = $env->getEnv();
        $this->assertArrayHasKey('FOO', $vars);
        $this->assertEquals('bar', $vars['FOO']);
    }

    /** @test */
    public function can_get_environment_variables_from_arbitrary_file_location()
    {
        // Create a config for testing
        $filename = __DIR__ . '/testing.json';
        file_put_contents($filename, json_encode(['FOO' => 'bar']));

        $env = new JsonEnv($filename);
        $env->load();

        $this->assertArrayHasKey('FOO', $_ENV);
        $this->assertNotNull($_ENV['FOO']);
        $this->assertEquals('bar', $_ENV['FOO']);
    }

    /** @test */
    public function can_get_environment_variables_from_env_helper_method()
    {
        file_put_contents('./env.json', json_encode(['FOO' => 'bar']));

        $env = new JsonEnv();
        $env->load();

        $this->assertArrayHasKey('FOO', $_ENV);
        $this->assertNotNull(\env('FOO'));
        $this->assertEquals('bar', \env('FOO'));
    }
}
