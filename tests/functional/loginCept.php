<?php
$I = new FunctionalTester($scenario);


$I->wantTo('perform actions and see result');

//$I->executeJS("window.confirm = function(msg){return true;};");

$I->amOnUrl('http://localhost/~hab/cooperons/front/login');

/*
$I->makeScreenshot('11');
$I->makeScreenshot('21');
$I->makeScreenshot('31');
$I->makeScreenshot('41');
$I->makeScreenshot('51');
$I->makeScreenshot('61');
$I->makeScreenshot('71');
*/

$I->makeScreenshot('2');

$I->makeScreenshot('71');
$email = "member@test.com";
$pwd="123456";
$I->fillField('input[name="username"]', $email);
$I->makeScreenshot('21');
$I->makeScreenshot('31');

$I->fillField('input[name="password"]',$pwd );
$I->makeScreenshot('11');
$I->makeScreenshot('41');


$I->click("//button[@aria-label='Se connecter']");



$I->amOnUrl('http://127.0.0.1/~hab/cooperons/front/login');


$I->amOnUrl('http://localhost/~hab/cooperons/front/program/0/edit/step1/1');

$I->fillField("//input[@id='input_0']", "EDATIS Easy");


$I->makeScreenshot('51');
$I->makeScreenshot('61');

$I->attachFile('input[name="image"]', 'Statistiques.png');


$I->click("//button[@aria-label='Suivant']");

/*
$I->makeScreenshot('21');
$I->makeScreenshot('31');
$I->makeScreenshot('41');
$I->makeScreenshot('51');
$I->makeScreenshot('61');
$I->makeScreenshot('71');
*/