<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/26
 * Time: 10:38
 */

namespace backend\controllers;


class HomeController  extends BaseController
{
    public function actionIndex(){

       return $this->render("index");
    }
    public function actionTop(){

        return $this->render("top");
    }
    public function actionMenu(){

        return $this->render("menu");
    }
    public function actionMain(){

        return $this->render("main");
    }


}