<?php
    require "Api.php";
    if (isset($_GET['film']) && ($_GET['film'] == 0 || !empty($_GET['film']))) {
        $ghibli = new Api("GET", "https://ghibliapi.vercel.app/films", true);
        $ghibli->callApi();
        $resultArray = $ghibli->getResultArray();
        if (!empty($ghibli->getError())) {
            echo $ghibli->getError();
        } else {
            //Here we set the Content-Type header to JSON so we can output film and description as JSON encoded data.
            header('Content-Type: application/json');
            //Since we have set the Content-Type, we can now output the JSON encoded data.
            //Sample Output: {title: 'My Title', description: 'My Description'}
            echo json_encode([
                'title' => $resultArray[$_GET['film']]['title'],
                'description' => $resultArray[$_GET['film']]['description'],
            ]);
        }
    }
?>
