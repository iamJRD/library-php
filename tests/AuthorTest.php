<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Author::deleteAll();
          Book::deleteAll();
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
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save($first_name2, $last_name2);

            $first_name3 = "John";
            $last_name3 = "Poe";
            $test_author3 = new Author($id, $first_name3, $last_name3);
            $test_author3->save($first_name3, $last_name3);

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testGetAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save($first_name2, $last_name2);

            // Act
            $result = Author::getAll();

            // Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testFind()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = 1;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save($first_name2, $last_name2);

            // Act
            Author::deleteAll();

            // Assert
            $this->assertEquals([], Author::getAll());
        }

        function testDelete()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $test_author2 = new Author($id, $first_name2, $last_name2);
            $test_author2->save($first_name2, $last_name2);

            // Act
            $test_author->delete();

            // Arrange
            $result = Author::getAll();
            $this->assertEquals([$test_author2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $new_first_name = "Jonathan";
            $new_last_name = "Doe";

            // Act
            $test_author->update($new_first_name, $new_last_name);

            // Assert
            $this->assertEquals(["Jonathan", "Doe"], [$test_author->getFirstName(), $test_author->getLastName()]);
        }

        function testAddBook()
        {
            // Arrange
            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            // Act
            $test_author->addBook($test_book);

            // Arrange
            $this->assertEquals([$test_book], $test_author->getBooks());
        }

        function testGetBooks()
        {
            // Arrange
            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            $title = "Fight Club";
            $test_book = new Book($id, $title);
            $test_book->save();

            $title2 = "Choke";
            $test_book2 = new Book($id, $title2);
            $test_book2->save();

            // Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $result = $test_author->getBooks();

            // Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

    }
?>
