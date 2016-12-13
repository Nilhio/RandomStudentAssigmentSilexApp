<?php

$app->get("/", "part.controller:indexAction");
$app->get("/parts/new", "part.controller:newAction");
$app->post("/parts/new", "part.controller:newAction");
