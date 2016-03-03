<?php
    class Author
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($id = null, $first_name, $last_name)
        {
            $this->id = $id;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = $new_first_name;
        }

        function getFirstName()
        {
            return $this->first_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = $new_last_name;
        }

        function getLastName()
        {
            return $this->last_name;
        }

        function getId()
        {
            return $this->id;
        }
// IF AUTHOR DOESNT EXIST, RETURN MATCHING AUTHOR
    // ELSE SAVE AUTHOR
        function save($new_first_name, $new_last_name)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM authors WHERE first_name = '{$new_first_name}' AND last_name = '{$new_last_name}';");
            $name_match = $query->fetchAll(PDO::FETCH_ASSOC);
            $found_author = null;

            foreach ($name_match as $author) {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $author_id = $author['id'];
                $found_author = Author::find($author_id);
            }

            if (($found_author != null) && ($found_author->getFirstName() == $new_first_name && $found_author->getLastName() == $new_last_name)) {
                return $found_author;
            }
            else {
                $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
            }
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();

            foreach($returned_authors as $author)
            {
                $first_name = $author['first_name'];
                $last_name = $author['last_name'];
                $id = $author['id'];
                $new_author = new Author($id, $first_name, $last_name);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();

            foreach($authors as $author)
            {
                $author_id = $author->getId();
                if ($author_id == $search_id)
                {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        }

        function update($new_first_name, $new_last_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET first_name = '{$new_first_name}', last_name = '{$new_last_name}' WHERE id = {$this->getId()};");
            $this->setFirstName($new_first_name);
            $this->setLastName($new_last_name);
        }

        function addBook($book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
        }

        function getBooks()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON (authors.id = authors_books.author_id) JOIN books ON (authors_books.book_id = books.id) WHERE authors.id = {$this->getId()};");
            $books = array();

            foreach($returned_books as $book)
            {
                $id = $book['id'];
                $title = $book['title'];
                $new_book = new Book($id, $title);
                array_push($books, $new_book);
            }
            return $books;
        }

    }
?>
