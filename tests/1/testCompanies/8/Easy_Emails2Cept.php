<?php

use project1\controllers\UserController as UserTester;

use project1\controllers\AdminController as AdminTester;

use Codeception\Util\Fixtures;


$I = new AcceptanceTester($scenario);
$U = new UserTester($I);
$A = new AdminTester($I);
$I->wantTo('login as a member');
$U->login(Fixtures::get('emailMember'),Fixtures::get('pwd'));
$U->checkAccountMoney(Fixtures::get('moneyToCheckEasy2'));
$U->goToMember1Profile();
$U->confirmationOfProposing(Fixtures::get('proposingNameToSearch'));
$U->logout();
$U->deleteLastEmailOfInvitation();
$I->wait(2);
$I->wantTo('complete registration to easymember1');
$U->goToUrlFromInvitationEmail();
$U->completeRegistrationClick(Fixtures::get('pwd'),Fixtures::get('pwd'),Fixtures::get('newParticipant1Adresse'),Fixtures::get('newParticipant1City'),Fixtures::get('newParticipant1PostalCode'),Fixtures::get('newParticipant1PhoneNumber'));
$U->logout();

