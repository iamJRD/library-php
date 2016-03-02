<?php
    class Author
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($id, $first_name, $last_name)
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

    }
?>
