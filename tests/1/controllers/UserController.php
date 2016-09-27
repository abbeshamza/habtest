<?php
namespace project1\controllers ;


use project1\pages\Login as LoginPage;

use project1\pages\MonEntreprise as Corporates;

use project1\pages\Program as Program;

use project1\pages\Registration;


class UserController extends \AcceptanceTester
{

    protected $msgOfInvitationEmail= "Vous pouvez désormais ";
    protected $msgOfInvitationParrainage="Invitation EDATIS Easy";
    protected $user;
    protected $regexOfInvitationUrl="/<a href(.*) target/";
    protected $regexOfParrainageInvitationUrl=" /http (.*)  A bien/";
    protected $labelForProgramSearch ="test";
    protected $msgSolde=" 460 ";
    protected $nameOfProposing= "EasyMember";



    public function __construct(\AcceptanceTester $I) {
        $this->user = $I;
    }

    /**
     * Login
     *
     * @param $username
     * @param $password
     */
    public function login($username, $password) {
        $this->user->wait(2);
        $this->user->amOnPage(LoginPage::$URL);
        $this->user->fillField(LoginPage::$usernameField, $username);
        $this->user->fillField(LoginPage::$passwordeField, $password);
        $this->user->click(LoginPage::$loginButton);
        $this->user->wait(2);
    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        $this->user->click("//a[@title='Déconnexion']");
    }

    /**
     * Add A Member
     * Add a new member to my entreprise
     * @param $firstName
     * @param $lastName
     * @param $email
     */
    public function addMember($firstName, $lastName, $email)
    {
        $this->user->amOnPage(Corporates::$URL);
        $this->user->wait(4);
        $this->user->click(Corporates::$addUserButton);
        $this->user->fillField(Corporates::$newUserFirsNameField, $firstName);
        $this->user->fillField(Corporates::$newUserLastNameField, $lastName);
        $this->user->fillField(Corporates::$newUserEmailField, $email);
        $this->user->click(Corporates::$newUserSendButton);
        $this->user->wait(2);

    }

    /**
     * Add a new Program for a given user
     * @param $programName
     * @param $fileName
     */
    public function addProgram($programName, $fileName)
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(3);
        $this->user->click(Program::$addProgramButton);
        $this->user->fillField(Program::$newProgramNameField, $programName);
        $this->user->attachFile(Program::$newProgramFileField, $fileName);
        $this->user->wait(2);
        $this->user->click(Program::$nextButton0);
        $this->user->wait(2);
        $this->user->click(Program::$nextButton2);
        $this->user->wait(2);
        $this->user->checkOption(Program::$firstCheckBox);
        $this->user->click(Program::$nextButton2);
        $this->user->checkOption(Program::$secondCheckBox);
        $this->user->click(Program::$paymentMethodVirement);
    }

    /**
     * Check for a given program's status and check for money for a given user
     * @param $status
     * @param $money
     */
    public function checkProgramStatus($status, $money)
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->see($status,Program::$statusOfProgram);
        $this->user->click(Program::$administrationButtom);
        $this->user->see($money,Program::$moneyLabel);

    }

    /**
     * Add a new participant for a given program
     * @param $firstName
     * @param $lastName
     * @param $email
     */
    public function addNewParticipentToProgram($firstName, $lastName, $email)
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(2);
        $this->user->click(Program::$administrationButtom);
        $this->user->fillField(Program::$newParticipantFirstNameField,$firstName);
        $this->user->fillField(Program::$newParticipantLastNameField,$lastName);
        $this->user->fillField(Program::$newParticipantEmailField,$email);
        $this->user->click(Program::$newParticipantButtom);
        $this->user->wait(2);
    }

    /**
     * Go to the URL generated from the server with the token
     *
     */
    public function goToUrlFromInvitationEmail()
    {
        $emailLastIndex=$this->user->findLastEmailBySubject($this->msgOfInvitationEmail);
        //$this->user->seeMyVar($emailLastIndex);
        $email= $this->user->getEmailBody($emailLastIndex);
        $urlInvitation=$this->user->grabMatchesFromAnEmail($email,$this->regexOfInvitationUrl);
        $toDelete= array("<a href=","target",'"',' ');
        $urlInvitation= str_replace($toDelete,"",$urlInvitation);
        $this->user->amOnUrl($urlInvitation);

    }

    /**
     * Complete registration from the URL of invitation sent by email
     * @param $plainPassword
     * @param $repeatedPassword
     * @param $adresse
     * @param $city
     * @param $postalCode
     * @param $phone
     */
    public function completeRegistration($plainPassword, $repeatedPassword, $adresse, $city, $postalCode, $phone)
    {
        $this->user->click(Registration::$registrationButton);
        $this->user->fillField(Registration::$plainPasswordeField,$plainPassword);
        $this->user->fillField(Registration::$repeatedPasswordField,$repeatedPassword);
        $this->user->fillField(Registration::$adresseField,$adresse);
        $this->user->fillField(Registration::$cityField,$city);
        $this->user->fillField(Registration::$postalCodeField,$postalCode);
        $this->user->fillField(Registration::$phoneNumberField,$phone);
        $this->user->checkOption(Registration::$firstCheckBox);
        $this->user->checkOption(Registration::$secondCheckBox);
        $this->user->click(Registration::$finishRegistration);
        $this->user->wait(2);

    }

    /**
     * Invite a new user : FirstName LastName <Email>
     * @param $char
     */
    public function parrainage($char)
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(2);
        $this->user->click(Program::$parrainageButtom);
        $this->user->fillField(Program::$emailsFilleulsField,$char);
        $this->user->click(Program::$inviteButtom);
        $this->user->wait(2);

    }

    /**
     * Go to the URL generated from the server with the token
     *
     */
    public function goToUrlFromParrainageInvitationEmail()
    {
        $emailLastIndex=$this->user->findLastEmailBySubject($this->msgOfInvitationParrainage);
        $email= $this->user->getEmailBody($emailLastIndex);
        $this->user->seeMyVar($email);
        $index= strpos($email['source'],"http");
        $urlInvitation="";
        while ($email['source'][$index] != '<')
        {
            $urlInvitation=$urlInvitation.$email['source'][$index];
            $index++;
        }
        $this->user->amOnUrl($urlInvitation);
        $this->user->wait(2);

    }

    /**
     * Validate the invitation and add the new member  to my program
     *
     */
    public function addMemberToMyProgram()
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->click(Program::$administrationButtom);
        $this->user->wait(2);
        $this->user->click(Program::$searchForProgramButtom);
        $this->user->fillField(Program::$searchForProgramField,$this->labelForProgramSearch);
        $this->user->pressKey(Program::$searchForProgramField,\WebDriverKeys::ENTER);
        $this->user->click(Program::$activationButtomForFirstIndex);
    }

    /**
     * Go to invited user from my own profile
     *
     */
    public function goToMember2Profile()
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->click(Program::$administrationButtom);
        $this->user->wait(2);
        $this->user->click(Program::$member2ProfilUrl);

    }
    /**
     *create "affaire"
     *
     *
     */

    public function createAffaire($name)
    {

        $this->user->fillField(Program::$affaireNameField,$name);
        $this->user->wait(2);
        $this->user->click(Program::$createAffaireButtom);
        $this->user->wait(2);

    }

    /**
     * cancel a specific case
     * @param $msg
     */
    public function abandonCase($msg)
    {
        $this->user->wait(2);
        $this->user->click(Program::$enApprocheButton);
        $this->user->wait(2);
        $this->user->fillField(Program::$abandonnerAffaireTextArea,$msg);
        $this->user->click(Program::$abandonnerAffairebutton);
        $this->user->wait(2);
    }

    /**
     * negotiation need to add vérification of money and emails
     * @param $value
     */
    public function negotiationCase($value)
    {
        $this->user->wait(2);
        $this->user->click(Program::$urlAffaire2);
        $this->user->wait(2);
        $this->user->fillField(Program::$negotiationField,$value);
        $this->user->click(Program::$negociationButton);
        $this->user->wait(2);
    }
    public function closeCase($value)
    {


        $this->user->fillField(Program::$negotiationField,$value);
        $this->user->click(Program::$closinngCaseButton);
        $this->user->wait(2);
    }
    public function reglement($value)

    {
        $this->user->fillField(Program::$negotiationField,$value);
        $this->user->click(Program::$negociationButton);

    }

    //--------------------------------------------------------------------------------------------------

    public function negotiationOfCase($value1,$value2)
    {
        $this->user->wait(2);
        $this->user->click(Program::$urlAffaireNewFeuille2);
        $this->user->wait(2);
        $this->user->fillField(Program::$negotiationField,$value1);
        $this->user->click(Program::$negociationButton);
        $this->user->wait(2);
        $this->user->fillField(Program::$negotiationField,$value2);
        $this->user->wait(2);
        $this->user->click(Program::$closingButtonNegotiation);
        $this->user->wait(2);
        $this->user->click(Program::$confirmationNegociationButton);
        $this->user->wait(2);
    }
    public function confirmationNegotiation()
    {
        $this->click(Program::$confirmationNegociationButton);
    }
    public function completeRegistrationClick($plainPassword, $repeatedPassword, $adresse, $city, $postalCode, $phone)
    {

        $this->user->click(Registration::$registrationButton);
        $this->user->click(Registration::$completeRegistrationButton);
        $this->user->fillField(Registration::$plainPasswordeField,$plainPassword);
        $this->user->fillField(Registration::$repeatedPWDField,$repeatedPassword);
        $this->user->fillField(Registration::$adresseField,$adresse);
        $this->user->fillField(Registration::$cityField,$city);
        $this->user->fillField(Registration::$postalCodeField,$postalCode);
        $this->user->fillField(Registration::$phoneNumberField,$phone);
        $this->user->checkOption(Registration::$firstCheckBox);
        $this->user->checkOption(Registration::$secondCheckBox);
        $this->user->click(Registration::$finishRegistration);
        $this->user->wait(2);
    }

    public function checkAccountMoney($money)

    {
    $this->user->amOnPage(Program::$URL);
    $this->user->see($money,Program::$checkSoldSpan);
    }
    public function goToMember1Profile()
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(2);
        $this->user->click(Program::$administrationButtom);
        $this->user->wait(2);
        $this->user->click(Program::$member1ProfilUrl);
        $this->user->wait(2);

    }
    public function confirmationOfProposing($name)

    {
        $this->user->click(Program::$searchProposingButton);
        $this->user->wait(2);
        $this->user->fillField(Program::$searchProposingField,$name);
        $this->user->wait(2);
        $this->user->pressKey(Program::$searchProposingField,\WebDriverKeys::ENTER);
        $this->user->wait(2);
        $this->user->click(Program::$confirmationProposingButton);
        $this->user->wait(2);
        $this->user->click(Program::$confirmationProposingPopupButton);
        $this->user->wait(2);

    }

    public function deleteLastEmailOfInvitation()
    {
        $emailLastIndex=$this->user->findLastEmailBySubject($this->msgOfInvitationEmail);
        $this->user->deleteEmailById($emailLastIndex);
    }







    //------------------------------------------------------------------------------
    public function editProgram()
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(2);
        $this->user->click(Program::$editProgramButton);
        $this->user->wait(2);
        $this->user->click(Program::$confirmPopupUpdateProgram);
        $this->user->wait(2);
        $this->user->click(Program::$nextButton);
        $this->user->wait(2);
        $this->user->pressKey(Program::$ratio1Img,\WebDriverKeys::ARROW_LEFT);
        $this->user->pressKey(Program::$ratio2Img,\WebDriverKeys::ARROW_RIGHT);
        $this->user->click(Program::$nextButton2);
        $this->user->wait(2);
        $this->user->checkOption(Program::$firstCheckBox);
        $this->user->click(Program::$nextButton2);
        $this->user->checkOption(Program::$secondCheckBox);
        $this->user->click(Program::$paymentMethodVirement);
    }
    public function activationOfProduction()
    {
        $this->user->amOnPage(Program::$URL);
        $this->user->wait(2);
        $this->user->click(Program::$configurationProgramButton);
        $this->user->wait(2);
        $this->user->click(Program::$productionModeButton);
        $this->user->wait(2);
        $this->user->click(Program::$confirmationProductionModeButton);
        $this->user->wait(2);


    }


}