<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);


$I->wantTo('login as a member to edit the program');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->editProgram();
$U->logout();
$I->wantTo('login as a admin to activate program');
//$I->resetEmails();
$U->login(Fixtures::get('adminEmail'),Fixtures::get('pwd'));
$A->activateProgram();
$A->logout();

$I->wantTo('login as a member to active the production mode ');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->activationOfProduction();
$U->logout();