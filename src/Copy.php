<?php
    class Copy
    {
        private $id;
        private $book_id;
        private $due_date;
        private $status;

        function __construct($id = null, $book_id, $due_date, $status)
        {
            $this->id = $id;
            $this->book_id = $book_id;
            $this->due_date = $due_date;
            $this->status = $status;
        }

        function setDueDate($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        function setStatus($new_status)
        {
            $this->status = $new_status;
        }

        function getDueDate()
        {
            return $this->due_date;
        }

        function getStatus()
        {
            return $this->status;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function getId()
        {
            return $this->id;
        }

    }
?>
