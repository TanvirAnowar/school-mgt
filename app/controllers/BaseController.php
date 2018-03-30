<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */


    protected $layout;



    public function __construct() {
        $this->layout = Theme::getLayout();
        View::share('theme',Theme::getTheme());
    }


    protected function setupLayout()
	{

		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}