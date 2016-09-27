<?php
namespace project7\pages ;

class AdminDashboard
{
    // include url of current page
    public static $URL = '/admin';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $programCheckBox = "//div[@id='content']/div/div/md-content/div/md-card/md-table-container/table/tbody/tr/td/md-checkbox/div";
    public static $validationButtom = "//div[@id='content']/div/div/md-content/div/md-card/md-toolbar/div/div[2]/button";
    public static $confirmationButton ="//div[@id='ngdialog1']/div[2]/div/footer/button[2]";
    public static $logOutButtom="//header[@id='header']/nav/div/ul/li[3]/a/ng-md-icon";

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
