<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="public/CSS/style.css" rel="stylesheet" type="text/css" media="all">
<title>MyBlog</title>
</head>
<body>
<h1>Blog is comming<h1>

<?php

// Check if path is available or not empty

if(isset($_SERVER['PATH_INFO'])){$path= $_SERVER['PATH_INFO'];

    // Do a path split

    $path_split = explode('/', ltrim($path));
    
    }else{

        // Set Path to '/'

        $path_split = '/';
    }

        if($path_split === '/'){

            /* match with index route*   

            Import IndexController and match requested method with it*/
        
        require_once __DIR__.'/Models/indexModel.php';
        require_once __DIR__.'/Controllers/indexController.php';
        $req_model = new IndexModel();
        $req_controller = new IndexController($req_model);
        
        /***Model and Controller assignment with first letter as UPPERCASE*@return Class;*/
        
        $model = $req_model;$controller = $req_controller;
        
        /***Creating an Instance of the the model and the controller each*@return Object;*/
        
        $ModelObj = new $model;$ControllerObj = new $controller($req_model);
        
        /***Assigning Object of Class Init to a Variable, to make it Usable*@return Method Name;*/
        
        $method = $req_method;
        
        /***Check if Controller Exist is not empty, then performs an*action on the method;*@return true;*/
        
        if ($req_method != ''){
            
            /***Outputs The Required controller and the req *method respectively*@return Required Method;*/
            
            print $ControllerObj->$method($req_param);
        }else{
            
            /***This works in only when the Url doesnt have a parameter*/
            print $ControllerObj->index();
        }}else{

// Controllers other than Index Will be handled here}
echo "Server Path </br>";

$path= $_SERVER['PATH_INFO'];

print_r($path);

echo "<br/><br/>Path Split<br/>";
print_r(explode('/', ltrim($path)));

?>




</body>
</html>
