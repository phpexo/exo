<?php


if (isset($_GET['p'])){ 

    if ($_GET['p'] == "dash"){
        include (dirname(__DIR__)."/pages/dasboard.view.php");
    }
    elseif ($_GET['p'] == "inv") 
    {
        include (dirname(__DIR__)."/pages/inventory.view.php");
    }
    elseif ($_GET['p'] == "inv_create") 
    {
        if (!$Rights->hasPermission('view', 'inv_create')) {
            throw new Exception('nope');
        }
        include (dirname(__DIR__)."/pages/inventory.create.php");
    }
    elseif ($_GET['p'] == "user_group") 
    {
        if (!$Rights->hasPermission('view', 'user_group')) {
            throw new Exception('nope');
        }
        include (dirname(__DIR__)."/pages/dasboard.php");
    }
    elseif ($_GET['p'] == "user") 
    {
        include (dirname(__DIR__)."/pages/dasboard.php");
    }
    elseif ($_GET['p'] == "config") 
    {
        if (!$Rights->hasPermission('view', 'config')) {
            throw new Exception('nope');
        }
        include (dirname(__DIR__)."/pages/dasboard.php");
    }
    elseif ($_GET['p'] == "404") 
    {
        include (dirname(__DIR__)."/pages/404.php");
    }

}else{

    include (dirname(__DIR__)."/pages/dasboard.view.php");

}



?>