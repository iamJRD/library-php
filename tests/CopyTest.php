<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Copy::deleteAll();
        }

        function testGetDueDate()
        {
            //Arrange
            $due_date = "2016-03-01";
            $status = null;
            $test_copy = new Copy($id = null, $book_id = null, $due_date, $status);

            //Act
            $result = $test_copy->getDueDate();

            //Assert
            $this->assertEquals($due_date, $result);
        }

        function testGetStatus()
        {
            //Arrange
            $due_date = "2016-03-01";
            $status = null;
            $test_copy = new Copy($id = null, $book_id = null, $due_date, $status);

            //Act
            $result = $test_copy->getStatus();

            //Assert
            $this->assertEquals($status, $result);
        }

        function testGetId()
        {
            //Arrange
            $due_date = "2016-03-01";
            $status = null;
            $id = null;
            $test_copy = new Copy($id, $book_id = null, $due_date, $status);

            //Act
            $result = $test_copy->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetBookId()
        {
            //Arrange
            $due_date = "2016-03-01";
            $status = null;
            $book_id = 1;
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);

            //Act
            $result = $test_copy->getBookId();

            //Assert
            $this->assertEquals($book_id, $result);
        }

        function testSave()
        {
            // Arrange
            $due_date = "2016-03-01";
            $status = 1;
            $book_id = 1;
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);

            // Act
            $test_copy->save();
            $result = Copy::getAll();

            // Assert
            $this->assertEquals($test_copy, $result[0]);
        }

        function testGetAll()
        {
            // Arrange
            $due_date = "2016-03-01";
            $status = 1;
            $book_id = 1;
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            $due_date2 = "2016-05-01";
            $status = 1;
            $book_id2 = 2;
            $test_copy2 = new Copy($id = null, $book_id2, $due_date2, $status);
            $test_copy2->save();

            // Act
            $result = Copy::getAll();

            // Assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

        function testDeleteAll()
        {
            // Arrange
            $due_date = "2016-03-01";
            $status = 1;
            $book_id = 1;
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            $due_date2 = "2016-05-01";
            $status = 1;
            $book_id2 = 2;
            $test_copy2 = new Copy($id = null, $book_id2, $due_date2, $status);
            $test_copy2->save();

            // Act
            Copy::deleteAll();
            $result = Copy::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            // Arrange
            $due_date = "2016-03-01";
            $status = 1;
            $book_id = 1;
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            //Act
            $result = Copy::find($test_copy->getId());

            //Assert
            $this->assertEquals($test_copy, $result);
        }
    }
?>
