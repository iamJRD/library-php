<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Book::deleteAll();
        }

        function testGetTitle()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function testGetId()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);

            //Act
            $test_book->save();
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $title2 = "Moby Dick";
            $test_book2 = new Book($id = null, $title2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $title2 = "Moby Dick";
            $test_book2 = new Book($id = null, $title2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
    }

?>
