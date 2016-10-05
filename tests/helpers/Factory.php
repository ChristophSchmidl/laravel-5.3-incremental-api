<?php


trait Factory
{

    protected $times = 1;

    protected function times($count)
    {
        $this->times = $count;

        return $this;
    }

    /**
     * Make a new record in the db
     *
     * @param $type
     * @param array $fields
     * @throws BadMethodCallException
     */
    protected function make($type, array $fields = [])
    {
        while ($this->times--){
            $stub = array_merge($this->getStub(), $fields);
            $type::create($stub);
        }
    }

    /**
     * @throws BadMethodCallException
     */
    protected function getStub()
    {
        throw new BadMethodCallException('Create your own getStub method to declare your fields.');
    }
}