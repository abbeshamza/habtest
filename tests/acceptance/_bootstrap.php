<?php
// Here you can initialize variables that will be available to your tests
use Codeception\Util\Fixtures;
Fixtures::add('adminEmail','admin@admin.com');
Fixtures::add('prospectUsername','prospect@test.com');
Fixtures::add('pwd','123456');

Fixtures::add('lastNameMember','Test');
Fixtures::add('firstNameMember','Member');
Fixtures::add('emailMember','member@test.com');

Fixtures::add('programName','EDATIS Easy');
Fixtures::add('programFile','Statistiques.png');

Fixtures::add('StatusProgramPreProduction','Pré-production');
Fixtures::add('monyToCheck','-561,60 €');

Fixtures::add('newParticipant1LastName','Test');
Fixtures::add('newParticipant1FirstName','EasyMember1');
Fixtures::add('newParticipant1Email','easymember1@test.com');
Fixtures::add('newParticipant1Adresse',"12 rue du Test");
Fixtures::add('newParticipant1City',"Test");
Fixtures::add('newParticipant1PostalCode',"12345");
Fixtures::add('newParticipant1PhoneNumber',"0123456789");

Fixtures::add('newParticipant2EmailInscription',"Test EasyMember2 <easymember2@test.com>");
Fixtures::add('newParticipant2LastName','Test');
Fixtures::add('newParticipant2FirstName','EasyMember2');
Fixtures::add('newParticipant2Email','easymember2@test.com');
Fixtures::add('newParticipant2Adresse',"12 rue du Test");
Fixtures::add('newParticipant2City',"Test");
Fixtures::add('newParticipant2PostalCode',"12345");
Fixtures::add('newParticipant2PhoneNumber',"0123456789");


Fixtures::add('affaire1Name','MyLittleFantaisie');
Fixtures::add("cancelCaseReason","Le prospect n'est finalement pas intéressé");
Fixtures::add('affaire2Name','MyLittleFantaisie New');
Fixtures::add('affaire2NegotiationMoney','5000');
Fixtures::add('affaire2ClosingMoney','4500');
Fixtures::add('affaire2Reg1Money','3000');
Fixtures::add('affaire2Reg2Money','1500');
///////////////////////////////                2éme Feuille                        ////////////////////////////////////


Fixtures::add('StatusProgramProduction','En production');
Fixtures::add('affaire2NegotiationMoneyFeuille2','10000');
Fixtures::add('affaire2Reglement1MoneyFeuille2','9000');
Fixtures::add('affaire2Reglement2MoneyFeuille2','6000');
Fixtures::add('moneyToCheckEasy2','Le solde du Compte Programme (460,00 €) ');
Fixtures::add('proposingNameToSearch','EasyMember');








