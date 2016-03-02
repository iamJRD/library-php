<?php
    require_once __DIR__ .'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Author.php';
    require_once __DIR__.'/../src/Book.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use ($app){
        return $app['twig']->render('index.html.twig');
    });

    $app->get('/library', function() use ($app) {
        return $app['twig']->render('library.html.twig', array('authors' => Author::getAll()));
    });

    $app->post('/add_author', function() use ($app) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $new_author = new Author($id = null, $first_name, $last_name);
        $new_author->save();
        return $app['twig']->render('library.html.twig', array('authors' => Author::getAll()));
    });

    return $app;
?>
