<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 4/7/14
 * Time: 1:09 PM
 */

class GitController extends BaseController{

    public function __construct(){

    }

    public function index()
    {
        exec("cd /home/carbon51/public_html/sms\n sh /home/carbon51/git.sh\n pwd",$output);

    }
} 