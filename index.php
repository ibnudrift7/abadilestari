<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
// error_reporting(0);

include 'get_setting.php';

require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

/* Global constants */
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('APP_PATH', dirname(ROOT_PATH).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR);
define('ASSETS_PATH', ROOT_PATH.DIRECTORY_SEPARATOR);

// Register Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Register Swiftmailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

// Register URL Generator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Register Validator
$app->register(new Silex\Provider\ValidatorServiceProvider());

// $app->before(function (Request $request) {
//     $url = $_SERVER['REQUEST_URI'];
//     $str_url = '';
//     if($url != '/sitondi/'){
//         $exp1 = explode('/', $url);
//         $str_url = $exp1[2];
//     }

// });
// $app["twig"]->addGlobal("url_redirect_language", $str_url);

$app_name = "PT. Abadi Lestari";
$app["twig"]->addGlobal("app_name", $app_name);

$facilities_data = $data_facilities;
$app["twig"]->addGlobal("facilities_data", $data_facilities);


$app->before(function (Request $request) use ($app) {
    if (!isset($_GET['lang'])) {
        return $app->redirect($app['url_generator']->generate('homepage').'?lang=en');
    }

    $app['twig']->addGlobal('lang_active', $_GET['lang']);

    $urls = $_SERVER['REQUEST_URI'];
    $urls = substr($urls, 0, -8);
    $app['twig']->addGlobal('current_page_name', $urls);

    $lang_message = array();
    if (isset($_GET['lang'])) {
        if ($_GET['lang'] == 'en') {
            $lang_message = include('lang/en/app.php');
        } else {
            $lang_message = include('lang/ch/app.php');
        }
    }
    $app["twig"]->addGlobal("lang_message", $lang_message);

    // $Gsetting = getSetting($_GET['lang']);
    // $app["twig"]->addGlobal("get_setting", $Gsetting);
});

// ------------------ Homepage ------------------------
$app->get('/', function () use ($app) {
	return $app['twig']->render('page/home.twig', array(
        'layout' => 'layouts/column1.twig',
        // 'benefits' => $app['data_benefits'],
    ));
})
->bind('homepage');

// ------------------ About ------------------
$app->get('/about', function () use ($app) {
    
    return $app['twig']->render('page/about.twig', array(
        'layout' => 'layouts/inside.twig',
    ));
})
->bind('about');

// ------------------ Process ------------------
$app->get('/process', function () use ($app) {
    return $app['twig']->render('page/process.twig', array(
        'layout' => 'layouts/inside.twig',
    ));
})
->bind('process');

// ------------------ Facility ------------------
$app->get('/facility', function () use ($app) {
    return $app['twig']->render('page/facility.twig', array(
        'layout' => 'layouts/inside.twig',
    ));
})
->bind('facility');

// ------------------ contact ------------------
$app->match('/contact', function (Request $request) use ($app) {

    $data = $request->get('Contact');
    if ($data == null) {
        $data = array(
            'name'=>'',
            'company'=>'',
            'phone'=>'',
            'email'=>'',
            'address'=>'',
            // 'city'=>'',
            'message'=>'',
        );
    }

    if ($_POST) {
        
        $constraint = new Assert\Collection( array(
            'name' => new Assert\NotBlank(),
            'email' => array(new Assert\Email(), new Assert\NotBlank()),
            'phone' => new Assert\Length(array('max'=>2000)),
            'company' => new Assert\Length(array('max'=>2000)),
            'address' => new Assert\Length(array('max'=>2000)),
            // 'city' => new Assert\Length(array('max'=>2000)),
            'message' => new Assert\Length(array('max'=>2000)),
        ) );

        $errors = $app['validator']->validateValue($data, $constraint);
        $errorMessage = array();

         if (!isset($_POST['g-recaptcha-response'])) {
            $errorMessage[] = 'Please Check Captcha for sending contact form!';
        }
        
        $secret_key = "6Ldj-WIUAAAAACp2FlER0x8va4IkttYJzfCqv8nM";
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret_key."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);

        $response = json_decode($response);
        if($response->success==false)
        {
            $errorMessage[] = 'Please Check Captcha for sending contact form!';
        }
        // else {

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorMessage[] = $error->getPropertyPath().' '.$error->getMessage();
            }
        }

        if (count($errorMessage) == 0) {
            
            // $app['swiftmailer.options'] = array(
            //         'host' => 'mail.abadilestariindonesia.com',
            //         'port' => '26',
            //         'username' => 'no-reply@abadilestari.co.id',
            //         'password' => 'V?#gNBE&IW6s',
            //         'encryption' => null,
            //         'auth_mode' => login
            //     );

            $pesan = \Swift_Message::newInstance()
                ->setSubject('Hi, Contact Website PT. Abadi Lestari')
                ->setFrom(array('no-reply@abadilestariindonesia.com'))
                ->setTo( array('info@abadilestariindonesia.com', $data['email']) )
                ->setBcc( array('deoryzpandu@gmail.com', 'ibnufajar372@gmail.com') )
                ->setReplyTo(array('info@abadilestariindonesia.com'))
                ->setBody($app['twig']->render('page/mail.twig', array(
                    'data' => $data,
                )), 'text/html');
            $app['mailer']->send($pesan);

            return $app->redirect($app['url_generator']->generate('contact').'?msg=success');
        }

        // }
        // else captcha
    }

    return $app['twig']->render('page/contactus.twig', array(
        'layout' => 'layouts/inside.twig',
        'error' => $errorMessage,
        'data' => $data,
        'msg' =>$_GET['msg'],
    ));
})
->bind('contact');

$app['debug'] = true;

$app->run();