<?php
    require_once __DIR__ .'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Student.php';
    require_once __DIR__.'/../src/Course.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=university';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
// INDEX PAGE
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/delete_all", function() use ($app) {
        Course::deleteAll();
        Student::deleteAll();
        return $app['twig']->render('index.html.twig');
    });
// STUDENTS PAGE
    $app->post("/add_student", function() use ($app) {
        $name = $_POST['name'];
        $enrollment = $_POST['enrollment'];
        $id = null;
        $new_student = new Student($name, $enrollment, $id);
        $new_student->save();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/delete_all_students", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/student/{id}", function($id) use($app) {
        $student = Student::find($id);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->post("/student_add_course", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $student->addCourse($course);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->patch("/student/{id}/update", function($id) use ($app) {
        $student = Student::find($id);
        $new_name = $_POST['new_name'];
        $new_enrollment = $_POST['new_enrollment'];
        $student->update($new_name, $new_enrollment);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    $app->delete("/student/{id}/delete", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render("students.html.twig", array('students' => Student::getAll()));
    });
// COURSES PAGE
    $app->post("/add_course", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $id = null;
        $new_course = new Course($name, $course_number, $id);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/delete_all_courses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/course/{id}", function($id) use($app) {
        $course = Course::find($id);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->post("/course_add_student", function() use ($app) {
        $student = Student::find($_POST['student_id']);
        $course = Course::find($_POST['course_id']);
        $course->addStudent($student);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->patch("/course/{id}/update", function($id) use ($app) {
        $course = Course::find($id);
        $new_name = $_POST['new_name'];
        $new_course_number = $_POST['new_course_number'];
        $course->update($new_name, $new_course_number);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->delete("/course/{id}/delete", function($id) use ($app) {
        $course = Course::find($id);
        $course->delete();
        return $app['twig']->render("courses.html.twig", array('courses' => Course::getAll()));
    });

    return $app;
?>
