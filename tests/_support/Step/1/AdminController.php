<?php
namespace Step\project1;
use Page\project1\AdminDashboard as Dashboard;


class AdminController extends \AcceptanceTester
{


    protected $user;

    public function __construct(\AcceptanceTester $I) {
        $this->user = $I;
    }

    public function logout()
    {
        $this->user->wait(2);
        $this->user->click(Dashboard::$logOutButtom);
    }
    public function activateProgram()
    {
        $this->user->wait(2);
        $this->user->click(Dashboard::$programCheckBox);
        $this->user->click(Dashboard::$validationButtom);
        $this->user->click(Dashboard::$confirmationButton);

    }


}