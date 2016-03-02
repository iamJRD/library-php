<?php
    class Patron
    {
        private $first_name;
        private $last_name;
        private $phone_number;
        private $id;

        function __construct($id = null, $first_name, $last_name, $phone_number)
        {
            $this->id = $id;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->phone_number = $phone_number;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = $new_first_name;
        }

        function getFirstName()
        {
            return $this->first_name;
        }

        function setPhoneNumber($new_phone_number)
        {
            $this->phone_number = $new_phone_number;
        }

        function getPhoneNumber()
        {
            return $this->phone_number;
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
            $GLOBALS['DB']->exec("INSERT INTO patrons (first_name, last_name, phone_number) VALUES ('{$this->getFirstName()}', '{$this->getLastName()}', {$this->getPhoneNumber()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();

            foreach($returned_patrons as $patron)
            {
                $first_name = $patron['first_name'];
                $last_name = $patron['last_name'];
                $phone_number = $patron['phone_number'];
                $id = $patron['id'];
                $new_patron = new Patron($id, $first_name, $last_name, $phone_number);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();

            foreach($patrons as $patron)
            {
                $patron_id = $patron->getId();
                if ($patron_id == $search_id)
                {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }

        function update($new_first_name, $new_last_name, $new_phone_number)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET first_name = '{$new_first_name}', last_name = '{$new_last_name}', phone_number = {$new_phone_number} WHERE id = {$this->getId()};");
            $this->setFirstName($new_first_name);
            $this->setLastName($new_last_name);
            $this->setPhoneNumber($new_phone_number);
        }

        function addCopy($copy)
        {
            $GLOBALS['DB']->exec("INSERT INTO copies_patrons (patron_id, copy_id) VALUES ({$this->getId()}, {$copy->getId()});");
        }

        function getCopies()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT copies.* FROM patrons JOIN copies_patrons ON (patrons.id = copies_patrons.patron_id) JOIN copies ON (copies_patrons.copy_id = copies.id) WHERE patrons.id = {$this->getId()};");
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

    }
?>
