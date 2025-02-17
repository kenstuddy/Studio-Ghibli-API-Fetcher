<?php
    require "Api.php";
    $ghibli = new Api("GET", "https://ghibliapi.vercel.app/films", true);
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
                <?php if (isset($resultArray)): ?>
                    <?php echo "<div class='cards'>" ?>
                        <?php $file = fopen('output.csv', 'w'); ?>
                        <?php fputcsv($file, array("Studio Ghibli Data")); ?>
                        <?php fputcsv($file, array("Title", "Description")); ?>
                        <?php foreach($resultArray as $key => $value): ?>
                            <?php if (!empty($value) && !empty($key)): ?>
                                <?php fputcsv($file, array($value['title'], $value['description'])) ?>
                                <?php echo "<div class='card'>" ?>
                                <?php echo "<h1>" . $value['title'] . "</h1>" ?>
                                <?php echo "<p @click.prevent=\"openModal('$key')\"> " . substr($value['description'],0,300) . "... </p>" ?>
                                <?php echo "</div>" ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php fclose($file); ?>
                    <?php echo "</div>" ?>
                <?php endif; ?>
                <?php if (!empty($ghibli->getError())) : ?>
                    <?php echo "<p id='error'>" ?>
                    <?php echo $ghibli->getError() ?>
                    <?php echo "</p>" ?>
                <?php endif; ?>
            </div>
        </div>
        <script src="dist/app.js"></script>
    </body>
</html>
