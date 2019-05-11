<?php

class IndexController extends \Base\ApplicationController
{

    public function indexAction()
    {
        $userModel = \M\Mapper\MytUser::getInstance();
        $user = $userModel->findById(1);

    }




}
