<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a easymember1');
$U->login(Fixtures::get('newParticipant1Email'),Fixtures::get('pwd'));
$U->parrainage(Fixtures::get('newParticipant2EmailInscription'));
$U->logout();
//$I->resetEmails();
$I->wantTo('login as member to add easymember2 to the program');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->addMemberToMyProgram();
$I->wait(2);
$U->logout();
$I->wantTo('complete registration to easymember2');
$U->goToUrlFromInvitationEmail();
$I->wait(2);
$U->completeRegistration(Fixtures::get('pwd'),Fixtures::get('pwd'),Fixtures::get('newParticipant2Adresse'),Fixtures::get('newParticipant2City'),Fixtures::get('newParticipant2PostalCode'),Fixtures::get('newParticipant2PhoneNumber'));
$U->logout();
