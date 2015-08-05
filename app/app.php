<?php

    // makes libraries available to the application

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";

    // starts the $_SESSION superglobal variable, which is an array of arrays

    session_start();

    // checks to see if the SESSION variable is empty at the specified key.
    // if it is empty, creates an array at that key

    if (empty($_SESSION['list_of_tasks'])) {
        $_SESSION['list_of_tasks'] = array();
    }

    // creates a new Silex\Application object

    $app = new Silex\Application();

    // makes the twig library available to the application and tells twig to look for our template
    // in the views folder

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // calls the get method on the $app object and receives a URL path as its first argument,
    // and a function that gives our route access to the app variable, then returns
    // the app object (using twig) to call the render method (which receives a file path that
    // contains the twig template and an array that contains the task list)

    $app->get("/", function() use ($app) {

        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));

    });

    // calls the post method on the $app object and receives a URL path as its first argument,
    // and a function that gives our route access to the app variable. the method then
    // creates a new task object based on the data it receives from the form, and then
    // saves (or pushes) the new object onto the $_SESSION array. then the method returns
    // the app object (using twig) to call the render method (which receives a file path that
    // contains the twig template and an array that contains the new task object, which is
    // added to the list)

    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('create_task.html.twig', array('newtask' => $task));
    });

    // calls the post method on the $app object and receives a URL path as its first argument,
    // and a function that gives our route access to the app variable. the method then calls
    // the Task class method deleteAll(), which resets the $_SESSION array to a blank array.
    // then the method returns the app object (using twig) and calls the render method (which
    // receives a file path that contains the twig template)

    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');
    });

    return $app;
 ?>
