<?php

use project7\controllers\UserController as UserTester;

use project7\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a prospect to add a member');
$U->login(Fixtures::get('prospectUsername'),Fixtures::get('pwd'));
$U->addMember(Fixtures::get('firstNameMember'),Fixtures::get('lastNameMember'),Fixtures::get('emailMember'));
$U->logout();
