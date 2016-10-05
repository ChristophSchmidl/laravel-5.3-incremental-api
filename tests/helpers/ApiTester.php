<?php

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class ApiTester extends TestCase
{
    use DatabaseMigrations;

    protected $faker;


    /**
     * ApiTester constructor.
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }


    /**
     * Get JSON output from API
     *
     * @param $uri
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    protected function getJson($uri, $method = 'GET', $parameters = [])
    {
        return json_decode($this->call($method, $uri, $parameters)->getContent());
    }

    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);

        foreach($args as $attribute){
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }


}