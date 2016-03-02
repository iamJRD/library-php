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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors (first_name, last_name) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors");
        }


    }
?>
