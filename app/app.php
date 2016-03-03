<?php
    require_once __DIR__ .'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Author.php';
    require_once __DIR__.'/../src/Book.php';
    require_once __DIR__.'/../src/Copy.php';
    require_once __DIR__.'/../src/Patron.php';

    $app = new Silex\Application();

    $app['debug'] = true;

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
        $authors = Author::getAll();
        foreach($authors as $author)
        {
            $id = $author->getId();
            $found_author = Author::find($id);
            $book_by_author = $found_author->getBooks();
        }
        return $app['twig']->render('library.html.twig', array('authors' => $authors, 'book' => $book_by_author));
    });

    $app->post('/add_author_book', function() use ($app) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $title = $_POST['title'];
        $new_author = new Author($id = null, $first_name, $last_name);
        $found_author = $new_author->save($first_name, $last_name);
        if ($found_author != null) {
            $new_book = new Book($id = null, $title);
            $new_book->save();
            $found_author->addBook($new_book);
        }
        else {
        $new_book = new Book($id = null, $title);
        $new_book->save();
        $new_author->addBook($new_book);
        }
        return $app['twig']->render('library.html.twig', array('authors' => Author::getAll()));
    });

    $app->get('/author/{id}', function($id) use ($app) {
        $author = Author::find($id);
        return $app['twig']->render('author.html.twig', array('author' => $author));
    });

    $app->get('/book/{id}', function($id) use ($app) {
        $book = Book::find($id);
        $author = $book->getAuthors();
        $book_copies = $book->getCopies();
        var_dump($book_copies);
        $copies = $book->countCopies($book_copies);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'author' => $author[0], 'copies' => $copies));
    });

    $app->post('/delete_all', function() use ($app){
        Author::deleteAll();
        Book::deleteAll();
        return $app['twig']->render('library.html.twig', array('authors' => Author::getAll()));
    });

    $app->patch('/book/{id}/edit', function($id) use ($app) {
        $book = Book::find($id);
        $new_title = $_POST['new_title'];
        $book->update($new_title);
        $author = $book->getAuthors();
        $book_copies = $book->getCopies();
        $copies = $book->countCopies($book_copies);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'author' => $author[0], 'copies' => $copies));
    });

    $app->patch('/book/{id}/edit_copies', function($id) use ($app) {
        $book = Book::find($id);
        $copy = $book->getCopies();
        $new_number_of_copies = $_POST['new_number_of_copies'];
        for ($i=0; $i<=$new_number_of_copies; $i++) {
                $copy[0]->save();
        }
        $book_copies = $book->getCopies();
        $author = $book->getAuthors();
        $copies = $book->countCopies($book_copies);
        return $app['twig']->render('book.html.twig', array('book' => $book, 'author' => $author[0], 'copies' => $copies));
    });

    return $app;
?>
