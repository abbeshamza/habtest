<?php
namespace Page\project1;

class Program
{
    // include url of current page
    public static $URL = '/member/programs';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $addProgramButton = "//button[@aria-label='Nouveau Programme']";
    public static $newProgramNameField="//input[@id='input_0']";
    public static $newProgramFileField='input[name="image"]';
    public static $nextButton0="//button[@aria-label='Suivant']";
    public static $nextButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content/div/md-card/div/form/div[3]/a/span";
    public static $nextButton2="//button[@id='next']";
    public static $firstCheckBox="//md-checkbox[@aria-label='Checkbox 1']";
    public static $secondCheckBox="//md-checkbox[@aria-label='cgv']";
    public static $paymentMethodVirement="//a[@aria-label='Virement']";
    public static $statusOfProgram="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/ul/li/div[1]/span[2]";
    public static $administrationButtom="//div[@id='global']/div/div/div/div/div[2]/md-content/div[2]/div/md-content/div/ul/li/div[2]/a[2]/ng-md-icon";
    public static $moneyLabel="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/div[4]/div/md-content/div/md-card/md-table-container/table/tbody/tr[1]/td[4]";
    public static $newParticipantFirstNameField="//input[@id='form_firstName']";
    public static $newParticipantLastNameField="//input[@id='form_lastName']";
    public static $newParticipantEmailField="//input[@id='form_email']";
    public static $newParticipantButtom="//button[@id='createEasyMember']";
    public static $parrainageButtom="//div[@id='global']/div/div/div/div/div[2]/md-content/div[2]/div/md-content/div/ul/li/div[2]/a/ng-md-icon";
    public static $emailsFilleulsField="//textarea[@id='emailsFilleuls']";
    public static $inviteButtom="//button[@id='submitEmails']";
    public static $searchForProgramButtom="//button[@aria-label='Search']";
    public static $searchForProgramField="//div[@id='global']/div/div/div/div/div[2]/md-content/div[2]/div/div[3]/md-card/md-content/md-toolbar[2]/div/md-input-container/input";
    public static $activationButtomForFirstIndex="//div[@id='global']/div/div/div/div/div[2]/md-content/div[2]/div/div[3]/md-card/md-content/md-table-container/table/tbody/tr/td/div/button";
    public static $member1ProfilUrl="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/div[3]/md-card/md-content/md-table-container/table/tbody/tr[1]/td[1]/div/a/ng-md-icon";
    public static $member2ProfilUrl="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/div[3]/md-card/md-content/md-table-container/table/tbody/tr[2]/td[1]/div/a/ng-md-icon";
    public static $affaireNameField="//input[@id='form_label']";
    public static $createAffaireButtom="//button[@id='createAffair']";
    public static $enApprocheButton="//div[@id='formAffairNew-placeholder']/div/md-content[2]/div/md-card/md-table-container/table/tbody/tr/td[2]/a/span";
    public static $abandonnerAffaireTextArea="//textarea[@id='cancelMsg']";
    public static $abandonnerAffairebutton = "//form[@id='formAbandon']/md-input-container[2]/button";
    public static $urlAffaire2 ="//div[@id='formAffairNew-placeholder']/div/md-content[2]/div/md-card/md-table-container/table/tbody/tr[2]/td[1]/a/span";
    public static $negotiationField="//input[@id='amount']";
    public static $negociationButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/md-card/form/md-input-container[2]/button";
    public static $closinngCaseButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/md-card/form/md-input-container[2]/button";

    /////////////////////////////////////// Feuille 2 ///////////////////////////////////////////////
    public static $urlAffaireNewFeuille2 ="//div[@id='formAffairNew-placeholder']/div/md-content[2]/div/md-card/md-table-container/table/tbody/tr[1]/td[1]/a/span";
    public static $closingButtonNegotiation="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/md-card/form/md-input-container[2]/button";
    public static $confirmationNegociationButton="//div[@id='ngdialog1']/div[2]/div[1]/footer/button[2]";
    public static $checkSoldSpan="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/infos-mandataire/div/md-content/div/md-card/md-card-title/md-card-title-text/span";
    public static $searchProposingButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content/div/md-card/md-toolbar/div/md-toolbar[1]/div/button";
    public static $searchProposingField="//input[@id='input_1']";
    public static $confirmationProposingButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content/div/md-card/md-table-container/table/tbody/tr/td[4]/span/i";
    public static $confirmationProposingPopupButton="//div[@id='ngdialog1']/div[2]/footer/button[2]";



    //////////////////////////////////  Feuille 3   //////////////////////////////////////////////////////////
    public static $editProgramButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/ul/li/div[2]/button[1]";
    public static $confirmPopupUpdateProgram ="//div[@id='ngdialog1']/div[2]/footer/button[2]";
    public static $ratio1Img="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content/div/md-card/div[1]/div/div[1]/div[1]/div/md-slider";
    public static $ratio2Img="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content/div/md-card/div[1]/div/div[1]/div[2]/div/md-slider";
    public static $configurationProgramButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/ul/li/div[2]/a[1]/ng-md-icon";
    public static $productionModeButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/md-content[1]/div/md-card/div/button[2]";
    public static $confirmationProductionModeButton="//div[@id='ngdialog1']/div[2]/div[1]/footer/button[2]";


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

}
