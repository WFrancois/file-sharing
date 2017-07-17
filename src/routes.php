<?php
// Routes


$app->get('/', \FileSharing\Controller\LoginController::class . ':loginAction');