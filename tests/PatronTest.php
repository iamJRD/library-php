<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Patron::deleteAll();
        }

        function testGetFirstName()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Doe";
            $phone_number = 9719990101;
            $test_patron = new Patron($id = null, $first_name, $last_name, $phone_number);

            //Act
            $result = $test_patron->getFirstName();

            //Assert
            $this->assertEquals($first_name, $result);
        }

        function testGetLastName()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $test_patron = new Patron($id = null, $first_name, $last_name, $phone_number);

            //Act
            $result = $test_patron->getLastName();

            //Assert
            $this->assertEquals($last_name, $result);
        }

        function testGetId()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = 3;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);

            //Act
            $result = $test_patron->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testGetPhoneNumber()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = 3;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);

            //Act
            $result = $test_patron->getPhoneNumber();

            //Assert
            $this->assertEquals($phone_number, $result);
        }

        function testSave()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = 1;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals($test_patron, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = null;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $phone_number2 = 9719990101;
            $test_patron2 = new Patron($id, $first_name2, $last_name2, $phone_number2);
            $test_patron2->save();

            // Act
            $result = Patron::getAll();

            // Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function testFind()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = 1;
            $phone_number = 9719990101;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            //Act
            $result = Patron::find($test_patron->getId());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $id = null;
            $phone_number = 9719990101;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $phone_number2 = 9719990101;
            $test_patron2 = new Patron($id, $first_name2, $last_name2, $phone_number2);
            $test_patron2->save();

            // Act
            Patron::deleteAll();

            // Assert
            $this->assertEquals([], Patron::getAll());
        }

        function testDelete()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = null;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $first_name2 = "Jane";
            $last_name2 = "Smith";
            $phone_number2 = 9719990101;
            $test_patron2 = new Patron($id, $first_name2, $last_name2, $phone_number2);
            $test_patron2->save();

            // Act
            $test_patron->delete();

            // Arrange
            $result = Patron::getAll();
            $this->assertEquals([$test_patron2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $first_name = "John";
            $last_name = "Poe";
            $phone_number = 9719990101;
            $id = null;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $new_first_name = "Jonathan";
            $new_last_name = "Doe";
            $new_phone_number = 5034450333;

            // Act
            $test_patron->update($new_first_name, $new_last_name, $new_phone_number);

            // Assert
            $this->assertEquals(["Jonathan", "Doe", 5034450333], [$test_patron->getFirstName(), $test_patron->getLastName(), $test_patron->getPhoneNumber()]);
        }

        function testAddCopy()
        {
            // Arrange
            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $phone_number = 9713334953;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $due_date = "2016-03-01";
            $status = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();


            // Act
            $test_patron->addCopy($test_copy);

            // Arrange
            $this->assertEquals([$test_copy], $test_patron->getCopies());
        }

        function testGetCopies()
        {
            // Arrange
            $first_name = "Chuck";
            $last_name = "Palahniuk";
            $id = null;
            $phone_number = 9713334953;
            $test_patron = new Patron($id, $first_name, $last_name, $phone_number);
            $test_patron->save();

            $title = "Fight Club";
            $test_book = new Book($id = null, $title);
            $test_book->save();

            $due_date = "2016-03-01";
            $status = 1;
            $book_id = $test_book->getId();
            $test_copy = new Copy($id = null, $book_id, $due_date, $status);
            $test_copy->save();

            $due_date2 = "2016-05-01";
            $status2 = 0;
            $book_id2 = $test_book->getId();
            $test_copy2 = new Copy($id = null, $book_id2, $due_date2, $status2);
            $test_copy2->save();

            // Act
            $test_patron->addCopy($test_copy);
            $test_patron->addCopy($test_copy2);
            $result = $test_patron->getCopies();

            // Assert
            $this->assertEquals([$test_copy, $test_copy2], $result);
        }

    }
?>
