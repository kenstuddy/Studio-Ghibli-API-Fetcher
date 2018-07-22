<?php 
    require "Api.php";
    $ghibli = new Api("GET", "https://ghibliapi.herokuapp.com/films", true);
    $ghibli->callApi();
    $resultArray = $ghibli->getResultArray();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ghibli App</title>
        <link href="https://fonts.googleapis.com/css?family=Dosis:400,700" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link href="style.css" rel="stylesheet">
        <script src="popup.js"></script>
    </head>

    <body>
        <div id="root">
            <img src="logo.png"/>
            <div class="container">
                <div>
                    <div id="dialog" style="display:none;"></div>
                </div>
                <? if (isset($resultArray)): ?>
                    <? foreach($resultArray as $key => $value): ?>
                        <?= "<div class='card'>" ?>
                        <?= "<h1>" . $value['title'] . "</h1>" ?>
                        <?= "<p onclick='popup(".$key.")'>" . substr($value['description'], 0, 300) . "...</p>" ?>
                        <?= "</div>" ?>
                    <? endforeach; ?>
                <? endif; ?>
                <p>
                    <? if (!empty($ghibli->getError())) : ?>
                        <?= $ghibli->getError() ?>
                    <? endif; ?>
                </p>
            </div>
        </div>
    </body>
</html>