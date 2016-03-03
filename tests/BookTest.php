<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Copy.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
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

        function testAddAuthor()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $this->assertEquals([$test_author], $test_book->getAuthors());
        }

        function testGetAuthors()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $test_author = new Author($id, $first_name, $last_name);
            $test_author->save($first_name, $last_name);

            //Act
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals([$test_author], $result);
        }

        function testAddCopy()
        {
            // Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $status = 1;
            $book_id = $test_book->getId();
            $due_date = "2016-03-03";
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);

            // Act
            $test_book->addCopy($test_copy);
            $result = $test_book->getCopies();

            // Assert
            $this->assertEquals([$test_copy], $result);
        }

        function testGetCopies()
        {
            //Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $due_date = "2016-03-01";
            $status = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            $due_date2 = "2016-05-01";
            $status = 1;
            $book_id2 = 5;
            $test_copy2 = new Copy($id = null, $book_id2, $due_date2, $status);
            $test_copy2->save();

            // Act
            $result = $test_book->getCopies();

            // Assert
            $this->assertEquals([$test_copy], $result);
        }

        function testCountCopies()
        {
            // Arrange
            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $due_date = "2016-03-01";
            $status = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            $due_date2 = "2016-05-01";
            $test_copy2 = new Copy($id = null, $book_id, $due_date2, $status);
            $test_copy2->save();

            // Act
            $book_copies = $test_book->getCopies();
            $result = $test_book->countCopies($book_copies);

            // Assert
            $this->assertEquals(2, $result);
        }
    }
?>
