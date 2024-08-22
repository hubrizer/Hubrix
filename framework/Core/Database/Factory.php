<?php
namespace Hubrix\Core\Database;

abstract class Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    abstract public function definition(): array;

    /**
     * Create a single instance of the model.
     *
     * @return mixed
     */
    public function create()
    {
        $modelClass = $this->model();
        $attributes = $this->definition();

        return $modelClass::create($attributes);
    }

    /**
     * Generate a collection of model instances.
     *
     * @param int $count
     * @return array
     */
    public function createMany(int $count): array
    {
        $instances = [];
        for ($i = 0; $i < $count; $i++) {
            $instances[] = $this->create();
        }
        return $instances;
    }

    /**
     * Return the model class associated with this factory.
     *
     * @return string
     */
    abstract protected function model(): string;
}
