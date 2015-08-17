<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Task::deleteAll();
        }

        function test_save()
        {
            // arrange
            $description = "Wash the dog";
            $test_task = new Task($description);

            //act
            $test_task->save();

            //assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_task = new Task($description);
            $test_task->save();
            $test_task2 = new Task($description2);
            $test_task2->save();

            //act
            $result = Task::getAll();

            //assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_getId()
        {

            //arrange
            $description = "Wash the dog";
            $id = 1;
            $test_Task = new Task($description, $id);

            //act
            $result = $test_Task->getId();

            //
            $this->assertEquals(1, $result);
        }

        function test_find()
        {
            //arrange
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_task = new Task($description);
            $test_task->save();
            $test_task2 = new Task($description2);
            $test_task2->save();

            //act
            $id = $test_task->getId();
            $result = Task::find($id);

            //assert
            $this->assertEquals($test_task, $result);
        }
    }

 ?>
