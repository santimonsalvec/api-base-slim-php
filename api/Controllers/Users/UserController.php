<?php

$app->get('/', function($request, $response, $args){
    require_once 'Users.php';
    $users = new Users();
    return $response->withJson($users->getList());
});

$app->post('/login', function($request, $response, $args){
    require_once 'Users.php';
    require_once 'Session.php';
    $data = json_decode($request->getBody());
    $user = new Session($data->email, $data->password);
    
    if($user->exist()){
        return $response->withJson($user->getData());
    }
    $message = array(
        'count' => 0,
        'message' => 'The username or password is incorrect',
        'data' => null
    );
    return $response->withJson($message);
});