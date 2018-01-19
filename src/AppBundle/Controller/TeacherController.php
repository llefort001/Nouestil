<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

class TeacherController extends controller{

    public function userListAction (){
        return $this->render('App:Teachers:userList');
    }
}