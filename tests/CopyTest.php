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
        // protected function tearDown()
        // {
        //   Copy::deleteAll();
        // }

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
    }
?>
