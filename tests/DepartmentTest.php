<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Department.php";

    $server = 'mysql:host=localhost:8889;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class DepartmentTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Department::deleteAll();
        }


        function testGetName()
        {
            //Arrange
            $name = "Work stuff";
            $test_department = new Department($name);

            //Act
            $result = $test_department->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_department = new Department($name, $id);

            //Act
            $result = $test_department->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $name = "Work stuff";
            $test_department = new Department($name);
            $test_department->save();

            //Act
            $result = Department::getAll();

            //Assert
            $this->assertEquals($test_department, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Work stuff";
            $test_department = new Department($name);
            $test_department->save();

            $name2 = "Home stuff";
            $test_department2 = new Department($name2);
            $test_department2->save();

            //Act
            $result = Department::getAll();

            //Assert
            $this->assertEquals([$test_department, $test_department2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $test_department = new Department($name);
            $test_department->save();

            $name2 = "Home stuff";
            $test_department2 = new Department($name2);
            $test_department2->save();

            //Act
            Department::deleteAll();
            $result = Department::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Wash the dog";
            $test_department = new Department($name);
            $test_department->save();

            $name2 = "Home stuff";
            $test_department2 = new Department($name2);
            $test_department2->save();

            //Act
            $result = Department::find($test_department->getId());

            //Assert
            $this->assertEquals($test_department, $result);
        }

        function testAddCourse()
        {
            // Arrange
            $name = "Work stuff";
            $id = 1;
            $test_department = new Department($name, $id);
            $test_department->save();

            $course_name = "File reports";
            $course_number = "2016-03-01";
            $test_course = new Course($course_name, $id, $course_number);
            $test_course->save();

            // Act
            $test_department->addCourse($test_course);

            // Assert
            $this->assertEquals($test_department->getCourses(), [$test_course]);
        }

        function testGetCourses()
        {
            //Arrange;
            $name = "Home stuff";
            $id = 1;
            $test_department = new Department($name, $id);
            $test_department->save();

            $course_name = "Wash the dog";
            $course_number = "2016-03-01";
            $test_course = new Course($course_name, $id, $course_number);
            $test_course->save();

            $course_name2 = "Take out the trash";
            $test_course2 = new Course($course_name2, $id, $course_number);
            $test_course2->save();

            //Act;
            $test_department->addCourse($test_course);
            $test_department->addCourse($test_course2);

            //Assert
            $this->assertEquals($test_department->getCourses(), [$test_course, $test_course2]);
        }

        function testDelete()
        {
            // Arrange
            $name = "Work stuff";
            $id = null;
            $test_department = new Department($name, $id);
            $test_department->save();

            $name2 = "Home stuff";
            $test_department2 = new Department($name2, $id);
            $test_department2->save();

            // Act
            $test_department->delete();

            // Assert
            $this->assertEquals([$test_department2], Department::getAll());
        }

        function testUpdate()
        {
            //Arrange;
            $name = "Work stuff";
            $id = null;
            $test_department = new Department($name, $id);
            $test_department->save();
            $new_name = "Home Stuff";

            //Act;
            $test_department->update($new_name);
            $result = $test_department->getName();

            //Assert;
            $this->assertEquals($new_name, $result);
        }
    }
?>
