<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($id = null, $title)
        {
            $this->id = $id;
            $this->title = $title;

        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();

            // $test_copy = new Copy($id = null, $book_id = $this->getId(), $due_date = null, $status = 1);
            // $test_copy->save();
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books");
            $books = array();

            foreach($returned_books as $book)
            {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($id, $title);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book)
            {
                $book_id = $book->getId();
                if ($book_id == $search_id)
                {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$author->getId()}, {$this->getId()});");
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books JOIN authors_books ON (books.id = authors_books.book_id) JOIN authors ON (authors_books.author_id = authors.id) WHERE books.id = {$this->getId()};");
            $authors = array();

            foreach($returned_authors as $author)
            {
                $id = $author['id'];
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $new_author = new Author($id, $first_name, $last_name);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books");
        }

        function addCopy($copy)
        {
            var_dump($copy);
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id, due_date, status) VALUES ({$this->getId()}, '{$copy->getDueDate()}', {$copy->getStatus()});");
            // $copy->getId() = $GLOBALS['DB']->lastInsertId();
            $copy->setId($GLOBALS['DB']->lastInsertId());
        }

        function getCopies()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
            $copies = array();

            foreach($returned_copies as $copy)
            {
                $id = $copy['id'];
                $book_id = $copy['book_id'];
                $due_date = $copy['due_date'];
                $status = $copy['status'];
                $new_copy = new Copy($id, $book_id, $due_date, $status);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        function countCopies($new_copies)
        {
            $number_of_copies = count($new_copies);
            return $number_of_copies;
        }
    }
?>
