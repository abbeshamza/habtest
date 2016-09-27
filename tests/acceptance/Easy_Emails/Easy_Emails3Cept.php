<?php

use Step\Acceptance\Feuille1\UserController as UserTester;
use Step\Acceptance\Feuille1\AdminController as AdminTester;
use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a member');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));