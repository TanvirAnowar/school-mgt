<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 2/18/14
 * Time: 7:27 PM
 */

class NotFoundController extends BaseController{

    public function index()
    {
        $viewModel = $viewModel = array(
            'theme' => Theme::getTheme()
        );
        return Theme::make('404',$viewModel);
    }

} 