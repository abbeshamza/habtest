<?php
namespace project7\pages ;

class Registration
{
    // include url of current page
    public static $URL = '/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static $registrationButton="//div[2]/a/span";
    public static $plainPasswordeField = "//input[@id='plainPassword']";
    public static $repeatedPasswordField = "//input[@id='input_3']";
    public static $adresseField = "//input[@id='registration_contact_address']";
    public static $cityField = "//input[@id='registration_contact_city']";
    public static $postalCodeField = "//input[@id='registration_contact_postalCode']";
    public static $phoneNumberField="//input[@id='registration_contact_phone']";
    public static $firstCheckBox="//md-checkbox/div";
    public static $secondCheckBox="//md-checkbox[@id='cgvProgram']/div";
    public static $finishRegistration="//button[@id='registration_Valider']";


    ///////////////////////////////////////
    public static $completeRegistrationButton="//div[@id='global']/div/div/div[1]/div/div[2]/md-content/div[2]/div/div/div/div/div[2]/div/md-input-container/a/span";
    public static $repeatedPWDField="//input[@id='input_4']";
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
