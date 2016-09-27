<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a member to verify easymember2');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->checkProgramStatus(Fixtures::get('StatusProgramPreProduction'),Fixtures::get('monyToCheck'));
$U->goToMember2Profile();
$U->createAffaire(Fixtures::get('affaire1Name'));
$I->wait(2);
$U->abandonCase(Fixtures::get('cancelCaseReason'));
$U->goToMember2Profile();
//need to change redirection to administration
$U->createAffaire(Fixtures::get('affaire2Name'));
$U->negotiationCase(Fixtures::get('affaire2NegotiationMoney'));
$U->closeCase(Fixtures::get('affaire2ClosingMoney'));
$U->reglement(Fixtures::get('affaire2Reg1Money'));
$U->reglement(Fixtures::get('affaire2Reg2Money'));
$I->wait(2);
