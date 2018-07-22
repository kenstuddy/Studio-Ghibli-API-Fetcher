<?php
    require "Api.php";
    if (isset($_GET['film']) && ($_GET['film'] == 0 || !empty($_GET['film']))) {
        $ghibli = new Api("GET", "https://ghibliapi.herokuapp.com/films", true);
        $ghibli->callApi();
        $resultArray = $ghibli->getResultArray();
        if (!empty($ghibli->getError())) {
            echo $ghibli->getError();
        } else {
            echo $resultArray[$_GET['film']]['description'] . "<br/>" . $resultArray[$_GET['film']]['title'];     
        }
    } 
?>