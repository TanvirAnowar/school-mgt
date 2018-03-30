<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@login');
      |
     */

    /* Render login form */
    public function login() {

        $user = Authenticate::hasSession();

        if($user){
            $userExist = User::find($user->id);
            if($userExist)
                return Redirect::to('dashboard');

        }

        $viewModel = array(
            'theme' => Theme::getTheme()
        );


        return Theme::make('login',$viewModel);

    }

    /* Action for authentication */
    public function authenticate(){

       if(Request::isMethod('post'))
       {

           $userId = Input::get('userId');
           $password = Input::get('password');
           try{
               $login = Authenticate::login($userId,$password);
               if($login){
                    return Redirect::to('dashboard');
               }else{
                    return Redirect::to('/');
               }
           }catch(DbConnectionException $e)
           {
               echo $e->getMessage(); die();
           }
       }

    }

    /* Logout a user and redirect to login page */
    public function logout()
    {
        if(Authenticate::check())
        {
			$carbonAPi = new Carbon51();
			
			$api_state = $carbonAPi->hasSession();
			$accessToken = $carbonAPi->getAccessToken($api_state);
			$carbonAPi->logoutapi($accessToken);
		
            Session::forget('user');
            return Redirect::to('/');
            exit();
        }

    }

}
