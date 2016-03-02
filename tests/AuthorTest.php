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

        // protected function tearDown()
        // {
        //   Author::deleteAll();
        // }

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

    }
?>
