<?php

$app->get("/", "part.controller:indexAction");

$app->get("/parts/new", "part.controller:newAction");
$app->post("/parts/new", "part.controller:newAction");

$app->get("/parts/{id}/edit", "part.controller:editAction");
$app->post("/parts/{id}/edit", "part.controller:editAction");


$app->get("/parts/{id}/delete", "part.controller:deleteAction");

$app->get("/parts/export", "part.controller:exportAction");
