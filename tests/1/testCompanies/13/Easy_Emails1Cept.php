<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a member');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->checkProgramStatus(Fixtures::get('StatusProgramProduction'),Fixtures::get('monyToCheck'));
$I->wait(2);
$I->wantTo('add easymember1 to program');
$I->wait(2);
$U->addNewParticipentToProgram(Fixtures::get('newParticipant1FirstName'),Fixtures::get('newParticipant1LastName'),Fixtures::get('newParticipant1Email'));
$U->addNewParticipentToProgram(Fixtures::get('newParticipant2FirstName'),Fixtures::get('newParticipant2LastName'),Fixtures::get('newParticipant2Email'));
$U->goToMember2Profile();
$I->wait(2);
$U->createAffaire(Fixtures::get('affaire2Name'));
$U->negotiationOfCase(Fixtures::get('affaire2NegotiationMoneyFeuille2'),Fixtures::get('affaire2Reglement1MoneyFeuille2'));
$U->reglement(Fixtures::get('affaire2Reglement2MoneyFeuille2'));
$U->logout();
$I->wantTo('complete registration to easymember2');
$U->goToUrlFromInvitationEmail();
$I->wait(2);
$U->completeRegistrationClick(Fixtures::get('pwd'),Fixtures::get('pwd'),Fixtures::get('newParticipant2Adresse'),Fixtures::get('newParticipant2City'),Fixtures::get('newParticipant2PostalCode'),Fixtures::get('newParticipant2PhoneNumber'));
$U->logout();

