<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="public/CSS/style.css" rel="stylesheet" type="text/css" media="all">
<title>MyBlog</title>
</head>
<body>
<h1>Hello, motherfucker!<h1>


<?php

// if (!isset($_SERVER['PATH_INFO']))
// {
//     echo "Home page!!!";
//     exit();
// }
// print "The request path is : ".$_SERVER['PATH_INFO'];


$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'],'/')) : '/';

if ($url == '/')
{

    // This is the home page
    // Initiate the home controller
    // and render the home view

    require_once __DIR__.'/models/index_model.php';
    require_once __DIR__.'/controllers/index_controller.php';
    require_once __DIR__.'/views/index_view.php';

    $indexModel = New IndexModel();
    $indexController = New IndexController($indexModel);
    $indexView = New IndexView($indexController, $indexModel);

    print $indexView->index();

}else{


    // This is not home page
    // Initiate the appropriate controller
    // and render the required view

    //The first element should be a controller
    $requestedController = $url[0]; 

    // If a second part is added in the URI, 
    // it should be a method
    $requestedAction = isset($url[1])? $url[1] :'';

    // The remain parts are considered as 
    // arguments of the method
    $requestedParams = array_slice($url, 2); 

    // Check if controller exists. NB: 
    // You have to do that for the model and the view too
    $ctrlPath = __DIR__.'/controllers/'.$requestedController.'_controller.php';



    if (file_exists($ctrlPath))
    {

        require_once __DIR__.'/models/'.$requestedController.'_model.php';
        require_once __DIR__.'/controllers/'.$requestedController.'_controller.php';
        require_once __DIR__.'/views/'.$requestedController.'_view.php';

        $modelName      = ucfirst($requestedController).'model';
        $controllerName = ucfirst($requestedController).'controller';
        $viewName       = ucfirst($requestedController).'view';

        $controllerObj  = new $controllerName( new $modelName );
        $viewObj        = new $viewName( $controllerObj, new $modelName );


        // If there is a method - Second parameter
        if ($requestedAction != '')
        {
            // then we call the method via the view
            // dynamic call of the view
            print $viewObj->$requestedAction($requestedParams);

        }

    }else{

        header('HTTP/1.1 404 Not Found');
        die('404 - The file - '.$ctrlPath.' - not found');
        //require the 404 controller and initiate it
        //Display its view
    }
}



?>







</body>
</html>
