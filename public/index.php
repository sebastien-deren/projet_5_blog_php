<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Sebastien\Blog\src\Test;
require_once(dirname(__FILE__).'/../bootstrap.php');

$dir_template = dirname(__FILE__).'/../template/';
$loader =new FilesystemLoader($dir_template);
$twig = new Environment($loader,['debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension);
$template = $twig->load("layout.html.twig");
$hello = new Test;
$content =" bonjour et bienvenu sur mon site";
$display= ["title" =>$hello->hello,"content"=>$content];
echo $template->render($display);
