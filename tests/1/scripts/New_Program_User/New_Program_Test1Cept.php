<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);

$I->wantTo('login as a prospect to add a member');
$U->login(Fixtures::get('prospectUsername'),Fixtures::get('pwd'));
$U->addMember(Fixtures::get('firstNameMember'),Fixtures::get('lastNameMember'),Fixtures::get('emailMember'));
$U->logout();
$I->wantTo('login as a member to add a program');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->addProgram(Fixtures::get('programName'),Fixtures::get('programFile'));
$U->logout();
$I->wantTo('login as a admin to activate program');
//$I->resetEmails();
$U->login(Fixtures::get('adminEmail'),Fixtures::get('pwd'));
$A->activateProgram();
$A->logout();
//test
$I->wantTo('login as a member and check the program');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->checkProgramStatus(Fixtures::get('StatusProgramPreProduction'),Fixtures::get('monyToCheck'));
$I->wantTo('add easymember1 to program');
$I->wait(2);
$U->addNewParticipentToProgram(Fixtures::get('newParticipant1FirstName'),Fixtures::get('newParticipant1LastName'),Fixtures::get('newParticipant1Email'));
$U->logout();
$I->wait(2);
$I->wantTo('complete registration to easymember1');
$U->goToUrlFromInvitationEmail();
$I->wait(3);
$U->completeRegistration(Fixtures::get('pwd'),Fixtures::get('pwd'),Fixtures::get('newParticipant1Adresse'),Fixtures::get('newParticipant1City'),Fixtures::get('newParticipant1PostalCode'),Fixtures::get('newParticipant1PhoneNumber'));
$U->logout();
$I->wait(2);
//redirection to a wrong url--------------------------------------------------------
