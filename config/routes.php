<?php

/* Car part routes */
$app->get("/", "part.controller:indexAction");
$app->get("/parts/new", "part.controller:newAction");
$app->post("/parts/new", "part.controller:newAction");
$app->get("/parts/{id}/edit", "part.controller:editAction");
$app->post("/parts/{id}/edit", "part.controller:editAction");
$app->get("/parts/{id}/delete", "part.controller:deleteAction");
$app->get("/parts/export", "part.controller:exportAction");

/* Car type routes */
$app->get("/types", "type.controller:indexAction");
$app->get("/types/new", "type.controller:newAction");
$app->post("/types/new", "type.controller:newAction");
$app->get("/types/{id}/edit", "type.controller:editAction");
$app->post("/types/{id}/edit", "type.controller:editAction");
$app->get("/types/{id}/delete", "type.controller:deleteAction");
