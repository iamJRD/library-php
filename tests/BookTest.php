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

        function testFind()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function testDelete()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $title2 = "Moby Dick";
            $test_book2 = new Book($id = null, $title2);
            $test_book2->save();

            //Act
            $test_book->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $new_title = "Choke";

            //Act
            $test_book->update($new_title);

            //Assert
            $this->assertEquals($new_title, $test_book->getTitle());
        }
    }

?>
