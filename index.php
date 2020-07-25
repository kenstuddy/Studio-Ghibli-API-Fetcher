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
        <link href="dist/app.css" rel="stylesheet">
    </head>

    <body>
        <div id="root">
            <img src="logo.png"/>
            <div class="container">
                <movie-modal></movie-modal>
                <? if (isset($resultArray)): ?>
                    <?= "<div class='cards'>" ?>
                        <? $file = fopen('output.csv', 'w'); ?>
                        <? fputcsv($file, array("Studio Ghibli Data")); ?>
                        <? fputcsv($file, array("Title", "Description")); ?>
                        <? foreach($resultArray as $key => $value): ?>
                            <? if (!empty($value) && !empty($key)): ?>
                                <? fputcsv($file, array($value['title'], $value['description'])) ?>
                                <?= "<div class='card'>" ?>
                                <?= "<h1>" . $value['title'] . "</h1>" ?>
                                <?= "<p @click.prevent=\"openModal('$key')\"> " . substr($value['description'],0,300) . "... </p>" ?>
                                <?= "</div>" ?>
                            <? endif; ?>    
                        <? endforeach; ?>
                        <? fclose($file); ?>
                    <?= "</div>" ?>
                <? endif; ?>
                <? if (!empty($ghibli->getError())) : ?>
                    <?= "<p id='error'>" ?>
                    <?= $ghibli->getError() ?>
                    <?= "</p>" ?>
                <? endif; ?>
            </div>
        </div>
        <script src="dist/app.js"></script>
    </body>
</html>
