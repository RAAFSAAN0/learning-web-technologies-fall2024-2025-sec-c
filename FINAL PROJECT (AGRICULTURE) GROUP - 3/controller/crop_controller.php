<?php
require_once('../model/database.php');

function getCrops() {
    return fetchAllCrops();
}

function handleSearchRequest() {
    if (isset($_GET['search'])) {
        header('Content-Type: application/json');
        echo json_encode(searchCrops($_GET['search']));
        exit;
    }
}

handleSearchRequest();
?>
