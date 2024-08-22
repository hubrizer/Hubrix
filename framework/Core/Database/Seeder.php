<?php
namespace Hubrix\Core\Database;

abstract class Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    abstract public function run(): void;
}
