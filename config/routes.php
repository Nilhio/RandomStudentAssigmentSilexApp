<?php

/* Car part routes */
$app->get("/", "part.controller:previewAction");
$app->get("/admin", "part.controller:indexAction");
$app->get("/admin/parts/new", "part.controller:newAction");
$app->post("/admin/parts/new", "part.controller:newAction");
$app->get("/admin/parts/{id}/edit", "part.controller:editAction");
$app->post("/admin/parts/{id}/edit", "part.controller:editAction");
$app->get("/admin/parts/{id}/delete", "part.controller:deleteAction");
$app->get("/admin/parts/export", "part.controller:exportAction");

/* Car type routes */
$app->get("/admin/types", "type.controller:indexAction");
$app->get("/admin/types/new", "type.controller:newAction");
$app->post("/admin/types/new", "type.controller:newAction");
$app->get("/admin/types/{id}/edit", "type.controller:editAction");
$app->post("/admin/types/{id}/edit", "type.controller:editAction");
$app->get("/admin/types/{id}/delete", "type.controller:deleteAction");
