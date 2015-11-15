<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

$webApp = new \Slim\Slim();

if (BACKEND_USER != '')
{
    $webApp->add(new \Slim\Middleware\HttpBasicAuthentication([
        'users' => [
            BACKEND_USER => BACKEND_PASSWORD
        ],
        'realm' => 'shareical',
        'path' => ['/admin', '/api'],
        'insecure' => INSECURE
    ]));
}

$webApp->post('/api/create-share-link', function () use ($webApp)
{
    $icaLink = $webApp->request->post('icallink');
    $headline = $webApp->request->post('headline');

    if (empty($headline))
        $headline = '';

    if (empty($icaLink))
    {
        $webApp->response->headers->set('Content-Type', 'text/plain');
        echo 'Error, no iCal source link provided';
        $webApp->response()->status(400);
    }
    else
    {
        $jsonString = json_encode(array('icallink' => $icaLink, 'headline' => $headline));
        $randomString = generate_random_string(URL_LENGTH);
        file_put_contents("data/$randomString.txt", $jsonString);
        echo APP_ROOT_URL . 'index.php/calendar/' . $randomString;
    }
});

$webApp->get('/admin', function () use ($webApp)
{
    include_once 'localization/' . LANGUAGE . '.php';
    include 'backend.php';
});

$webApp->get('/calendar/:urldata', function ($urldata) use ($webApp)
{
    $data = json_decode(file_get_contents("data/$urldata.txt"));
    $data->icalcontent = @file_get_contents($data->icallink);

    include_once 'localization/' . LANGUAGE . '.php';
    include 'frontend.php';
});

$webApp->run();

function generate_random_string($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>