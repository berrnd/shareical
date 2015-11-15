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
        $jsonStringEncrypted = simple_encrypt($jsonString, CRYPT_SALT);
        echo APP_ROOT_URL . 'index.php/calendar/' . urlencode($jsonStringEncrypted);
    }
});

$webApp->get('/admin', function () use ($webApp)
{
    include_once 'localization/' . LANGUAGE . '.php';
    include 'backend.php';
});

$webApp->get('/calendar/:cryptdata', function ($cryptdata) use ($webApp)
{
    $data = json_decode(simple_decrypt($cryptdata, CRYPT_SALT));
    $data->icalcontent = @file_get_contents($data->icallink);
    
    include_once 'localization/' . LANGUAGE . '.php';
    include 'frontend.php';
});

$webApp->run();

function simple_encrypt($text, $salt)
{
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function simple_decrypt($text, $salt)
{
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

?>