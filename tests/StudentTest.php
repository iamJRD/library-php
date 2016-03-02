<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost:8889;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Student::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $department_id = null;
            $test_student = new Student($name, $enrollment, $department_id);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testGetEnrollment()
        {
            // Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $department_id = null;
            $test_student = new Student($name, $enrollment, $department_id);

            // Act
            $result = $test_student->getEnrollment();

            // Assert
            $this->assertEquals($enrollment, $result);
        }

        function testGetId()
        {
            // Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $id = null;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);

            // Act
            $result = $test_student->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $department_id = null;
            $test_student = new Student($name, $enrollment, $department_id);
            $test_student->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Joe";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $name2 = "Jim";
            $enrollment2 = "2016-03-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2, $department_id);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $name2 = "Joe";
            $enrollment2 = "2016-03-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2, $department_id);
            $test_student2->save();

            //Act
            Student::deleteAll();
            $result = Student::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange;
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment,  $id, $department_id);
            $test_student->save();

            $name2 = "Joe";
            $enrollment2 = "2016-03-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2, $department_id);
            $test_student2->save();

            //Act;
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);
        }

        function testGetCourses()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id3 = 3;
            $test_course = new Course($name, $course_number, $id3);
            $test_course->save();

            $name2 = "History";
            $course_number2 = "HIST101";
            $id2 = 2;
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            // Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            // Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
        }

        function testAddCourse()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $name = "Intro to Programming";
            $course_number = "PROG101";
            $id2 = 2;
            $test_course = new Course($name, $course_number, $id2);
            $test_course->save();

            // Act
            $test_student->addCourse($test_course);

            // Assert
            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

        function testAddDepartment()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = 2;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $department_name = "Computer Science";
            $id2 = 2;
            $test_department = new Department($department_name, $id2);
            $test_department->save();

            // Act
            $test_student->addDepartment($test_department);

            // Assert
            $this->assertEquals($test_student->getDepartmentId(), $department_id);
        }

        function testDelete()
        {
            //Arrange;
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $name2 = "Joe";
            $enrollment2 = "2016-03-02";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment2, $id2, $department_id);
            $test_student2->save();

            //Act;
            $test_student2->delete();

            //Assert;
            $this->assertEquals([$test_student], Student::getAll());
        }

        function testUpdate()
        {
            // Arrange
            $name = "Jim";
            $enrollment = "2016-03-01";
            $id = 1;
            $department_id = null;
            $test_student = new Student($name, $enrollment, $id, $department_id);
            $test_student->save();

            $new_name = "Jack";
            $new_enrollment= "2016-03-02";

            // Act
            $test_student->update($new_name, $new_enrollment);
            $result = [$test_student->getName(), $test_student->getEnrollment()];

            // Assert
            $this->assertEquals(["Jack", "2016-03-02"], $result);
        }
    }
?>
