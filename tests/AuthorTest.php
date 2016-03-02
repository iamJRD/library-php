<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Author::deleteAll();
        }

        function testGetFirstName()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Doe";
            $test_author = new Author($id = null, $first_name, $last_name);

            //Act
            $result = $test_author->getFirstName();

            //Assert
            $this->assertEquals($first_name, $result);
        }

        function testGetLastName()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $test_author = new Author($id = null, $first_name, $last_name);

            //Act
            $result = $test_author->getLastName();

            //Assert
            $this->assertEquals($last_name, $result);
        }

        function testGetId()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = 3;
            $test_author = new Author($id, $first_name, $last_name);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = 1;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save();

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save();

            // Act
            $result = Author::getAll();

            // Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save();

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save();

            // Act
            Author::deleteAll();

            // Assert
            $this->assertEquals([], Author::getAll());
        }

    }
?>
