<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";

    $server = 'mysql:host=localhost:8889;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
        }

        function testGetName()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);

            // Act
            $result = $test_course->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function testGetCourseNumber()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);

            // Act
            $result = $test_course->getCourseNumber();

            // Assert
            $this->assertEquals($course_number, $result);
        }

        function testGetId()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);

            // Act
            $result = $test_course->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::getAll();
            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            Course::deleteAll();
            $result = Course::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange;
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act;
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        function testGetStudents()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name2 = "Joe";
            $enrollment2 = "2016-03-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2);
            $test_student2->save();

            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id3 = 3;
            $test_course = new Course($name, $course_number, $id3);
            $test_course->save();

            // Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            // Assert
            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }

        function testAddStudent()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $test_student = new Student($name, $enrollment, $id);
            $test_student->save();

            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id2 = 2;
            $test_course = new Course($name, $course_number, $id2);
            $test_course->save();

            // Act
            $test_course->addStudent($test_student);

            // Assert
            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function testDelete()
        {
            //Arrange;
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act;
            $test_course2->delete();

            //Assert;
            $this->assertEquals([$test_course], Course::getAll());
        }

        function testUpdate()
        {
            // Arrange
            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $new_name = "Intro to Coding";
            $new_course_number = "COD101";

            // Act
            $test_course->update($new_name, $new_course_number);
            $result = [$test_course->getName(), $test_course->getCourseNumber()];

            // Assert
            $this->assertEquals(["Intro to Coding", "COD101"], $result);
        }
    }
?>
