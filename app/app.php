<?php

    // makes libraries available to the application

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    // creates a new Silex\Application object

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('index.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/categories/{id}", function($id) use ($app){
        $category = Category::find($id);
        return $app['twig']->render('categories.html.twig', array('category' => $category, 'tasks' => $category->getTasks()));
    });

    $app->post("/tasks", function() use ($app){
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $task = new Task($description ,$id= null, $category_id);
        $task->save();
        $category = Category::find($category_id);
        return $app['twig']->render('categories.html.twig', array('category' => $category, 'tasks' => $category->getTasks()));
    });

    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/task_results", function() use ($app) {
        $results_array = (Task::findTaskname($_GET['task_form']));
        return $app['twig']->render('results.html.twig', array('found_tasks' => $results_array));
    });

    return $app;
?>
