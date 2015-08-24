<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function testGetDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $test_task = new Task($description);

            //Act
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function testSetDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $test_task = new Task($description);

            //Act
            $test_task->setDescription("Drink coffee.");
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals("Drink coffee.", $result);
        }

        function testGetId()
        {

            //arrange
            $name = "Home Stuff";
            $description = "Wash the dog";
            $test_task = new Task($description, $id);

            //act
            $result = $test_task->getId();

            //
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
          //Arrange
          $description = "Wash the dog";
          $id = 1;
          $test_task = new Task($description, $id);

          //Act
          $test_task->save();

          //Assert
          $result = Task::getAll();
          $this->assertEquals($test_task, $result[0]);
        }

        function testSaveSetsId()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);

            //Act
            $test_task->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_task->getId()));
        }

        function test_getAll()
        {
            //arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //act
            $result = Task::getAll();

            //assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function testDeleteAll()
        {
            //arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //act
            Task::deleteAll();

            //assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //act
            $result = Task::find($test_task->getId());

            //assert
            $this->assertEquals($test_task, $result);
        }

        function testUpdate()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $new_description = "Clean the dog";

            //Act
            $test_task->update($new_description);

            //Assert
            $this->assertEquals("Clean the dog", $test_task->getDescription());
        }

        function testDeleteTask()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id2);
            $test_task2->save();


            //Act
            $test_task->delete();

            //Assert
            $this->assertEquals([$test_task2], Task::getAll());
        }
    }

 ?>
