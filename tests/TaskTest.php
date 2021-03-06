<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);




    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function testSetDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $test_task->setDescription("Drink coffee.");
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals("Drink coffee.", $result);
        }

        function testGetDescription()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function testSetDueDate()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $test_task->setDueDate("11/12/2012");
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals("11/12/2012", $result);
        }

        function testGetDueDate()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals($due_date, $result);
        }

        function testSetComplete()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $test_task->setComplete(true);
            $result = $test_task->getComplete();

            //Assert
            $this->assertEquals(true, $result);
        }

        function testgetComplete()
        {
            //Arrange
            $description = "Do dishes.";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

            //Act
            $result = $test_task->getComplete();

            //Assert
            $this->assertEquals(false, $result);
        }

        function testGetId()
        {
            //Arrange
            $id = 1;
            $description = "Wash the dog";
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date, $id);

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $description = "Wash the dog";
            //$id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date);

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
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date, $id);

            //Act
            $test_task->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_task->getId()));
        }

        function testGetAll()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date, $id);
            $test_task->save();


            $description2 = "Water the lawn";
            $id2 = 2;
            $due_date2 = "11/11/2011";
            $test_task2 = new Task($description2, $due_date2, $id2);
            $test_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $due_date2 = "11/11/2011";
            $test_task2 = new Task($description2, $id2, $due_date2);
            $test_task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $due_date2 = "11/11/2011";
            $test_task2 = new Task($description2, $id2, $due_date2);
            $test_task2->save();

            //Act
            $result = Task::find($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function testUpdateDescription()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $new_description = "Clean the dog";
            $new_complete = false;
            $new_due_date = "12/19/2018";

            //Act
            $test_task->update($new_description, $new_due_date, $new_complete);

            //Assert
            $this->assertEquals("Clean the dog", $test_task->getDescription());
        }

        function testUpdateComplete()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $new_complete = true;
            $new_description = "Clean the dog";
            $new_due_date = "12/19/2018";

            //Act
            $test_task->update($new_description, $new_due_date, $new_complete);

            //Assert
            $this->assertEquals(true, $test_task->getComplete());
        }

        function testUpdateDueDate()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $new_complete = true;
            $new_description = "Clean the dog";
            $new_due_date = "12/19/2018";

            //Act
            $test_task->update($new_description, $new_due_date, $new_complete);

            //Assert
            $this->assertEquals("12/19/2018", $test_task->getDueDate());
        }



        function testDeleteTask()
        {
           //Arrange
           $description = "Wash the dog";
           $id = 1;
           $due_date = "11/11/2011";
           $test_task = new Task($description, $id, $due_date);
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

        function testAddCategory()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id2 = 2;
            $due_date2 = "11/11/2011";
            $test_task = new Task($description, $id2, $due_date2);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Volunteer stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $description = "File reports";
            $id3 = 3;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date, $id3);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testDelete()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id3 = 3;
            $due_date = "11/11/2011";
            $test_task = new Task($description, $due_date, $id3);
            $test_task->save();

            //Act
            $test_task->addCategory($test_category);
            $test_task->delete();

            //Assert
            $this->assertEquals([], $test_category->getTasks());
        }

    }
?>
