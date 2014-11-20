<?php

class UsersController extends \BaseController {

	protected $layout = "layouts.main";
	
	public function __construct() {
    	$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->beforeFilter('auth', array('only'=>array('getDashboard','getOffers')));
	}
	public function getRegister() {
	    $this->layout->content = View::make('users.register');
	}
	
	public function postCreate() {
    	$rules = array(
		    'firstname'=>'required|alpha|min:2',
		    'lastname'=>'required|alpha|min:2',
		    'email'=>'required|email|unique:users',
		    'password'=>'required|alpha_num|between:6,12|confirmed',
		    'password_confirmation'=>'required|alpha_num|between:6,12',
		);
    	$validator = Validator::make(Input::all(), $rules);
 	    if ($validator->passes()) {
	        // validation has passed, save user in DB
		        $user = new User;
			    $user->firstname = Input::get('firstname');
			    $user->lastname = Input::get('lastname');
			    $user->email = Input::get('email');
			    $user->password = Hash::make(Input::get('password'));
			    $user->save();
			    return Redirect::to('users/login')->with('message', 'Thanks for registering!');
	    } else {
	        // validation has failed, display error messages    
				return Redirect::to('users/register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function getLogin() {
    	$this->layout->content = View::make('users.login');
	}
	
	public function postSignin() {
    	if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
		    return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
		} else {
		    return Redirect::to('users/login')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
		}         
	}

	public function getDashboard() {

		$data['rows'] = DB::select("select 
				offers_taken.*,
				resturants_offers.*,
				offers.offername,
				resturants.r_name,
				locations.loc_name
				from offers_taken 
				inner join resturants_offers on resturants_offers.idresturants_offers=offers_taken.offer_id 
				inner join offers on offers.idoffers=resturants_offers.offer_id
				inner join resturants on resturants.r_id=resturants_offers.resturant_id 
				inner join locations on locations.loc_id = resturants_offers.location_id
				where user_id =".Auth::user()->id ." order by resturants_offers.resturant_id DESC"
			);
		
		//echo '<pre>';die(print_r($rows));
		$this->layout->nest('content','users.dashboard',$data);
        //$this->layout->content = View::make('users.dashboard');
	}

	public function getLogout() {
        Auth::logout();
	    return Redirect::to('users/login')->with('message', 'Thanks For Visiting Have a Good Day!');
	}

	
	public function postUserinfo() {
		$rules = array(
		    'time_of_meal' => 'required',
		    'budget' => 'required',
		    'location' => 'required',
		    'no_of_guests' => 'required'
    	);
		$messages = array(
		    'no_of_guests.required' => 'it needs to be filled', 
	    );
		$validator = Validator::make(Input::all(), $rules);
 	    if ($validator->passes()) {
		     // validation has passed, save user in DB
 	    	$data = array();
 	    	$data['time_of_meal'] = Input::get('time_of_meal');
 	    	$data['budget'] = Input::get('budget');
 	    	$data['location_id'] = Input::get('location');
 	    	$data['no_of_guests'] = Input::get('no_of_guests');
 	    	DB::table('users')->where('id', Auth::user()->id)->update($data);
 	    		return Redirect::to('users/dashboard')->with('message', 'Your Profile has been updated successfully');
	    }
		else {
	        // validation has failed, display error messages    
				return Redirect::to('users/dashboard')->with('message', 'Please provide us correct information! You can see erros by by clicking Add/edit my info button')->withErrors($validator)->withInput();
	    }
	}

	public function getOffers(){
		try{
			$data['offers'] = DB::select("select resturants_offers.*,
			locations.loc_name as location,
			resturants.r_name as resturant_name,
			offers.offer_content,offers.offername,
			GROUP_CONCAT(rel_days_resurantoffers.days_id SEPARATOR ', ') as days
			from `resturants_offers` 
			inner join locations on locations.loc_id=resturants_offers.location_id 
			inner join resturants on resturants.r_id = resturants_offers.resturant_id
			inner join offers on offers.idoffers = resturants_offers.offer_id
			inner join rel_days_resurantoffers on rel_days_resurantoffers.resurant_offers_id = resturants_offers.idresturants_offers
			where location_id=".Auth::user()->location_id.' and 
			price<='.Auth::user()->budget." and 
			max_guests>=".Auth::user()->no_of_guests." and 
			min_guests<=".Auth::user()->no_of_guests." and 
			time='".Auth::user()->time_of_meal."' and
			resturants_offers.active=1
			group by resturants_offers.offer_id

			");
			//group by resturants_offers.offer_id
		}
		catch(Exception $e){
			die('<h1>oops! Syntax Error Sorry</h1>'.print_r($e));

		}
		//$this->layout->nest('content','users.offers',$data);
  	
		$this->layout->content = View::make('users.offers',$data);
	}

	
	public function postMyoffers(){
		$resturant_offer_id = Input::get('resturant_offer_id');
		//die(print_r(Input::all()));
		date_default_timezone_set('Asia/Calcutta');
		$user_id = Auth::user()->id;
    			if($this->goodtogo($resturant_offer_id)){
					$data = array();
		 	    	$data['user_id'] = Auth::user()->id;
		 	    	$data['offer_id'] = Input::get('resturant_offer_id');
		 	    	$data['starting_at'] = Input::get('starting_at');
		 	    	$data['ending_at'] = '';
		 	    	$data['taken_at'] = date("Y-m-d H:i:s");
		 	    	$dayname = DB::select("select name from days where iddays=".Input::get('day_id'));
		 	    	$dayname  = $dayname[0]->name;
		 	    	$date = date("Y/m/d");
		 	    	if($dayname == date('l')){
		 	    		$starting_at = strtotime(Input::get('starting_at'));
		 	    		$current_time = strtotime(date('H:i:s'));
		 	    		if($current_time >= $starting_at){
		 	    			$nextDate =  date('Y/m/d',strtotime($date . "+1 days"));
					 	}
					 	else{
					 		$nextDate =$date;
					 	} 
		 	    	}
		 	    	else{
		 	    		$nextDate =$date;
		 	    	}
					$tomorrow = date('l',strtotime($nextDate));
					while($tomorrow!=$dayname){
						$nextDate = date('Y/m/d',strtotime($nextDate . "+1 days"));
						$tomorrow = date('l',strtotime($nextDate));
					}
					$nextDate = str_replace('/', '-', $nextDate);
					$data['starting_at'] = $nextDate. ' '.$data['starting_at'];  
					$validity = explode(":",Input::get('validity'));
					$hr = $validity[0];
					$minute = $validity[1];
					$ending_at = date('Y-m-d H:i:s',strtotime($data['starting_at'] . "+$hr hour"));
					$ending_at = date('Y-m-d H:i:s',strtotime($ending_at . "+$minute minute"));
		 	    	$data['ending_at'] = $ending_at;
		 	    	DB::table('offers_taken')->insert($data);
		 	    	
				return Redirect::to('users/dashboard')->with('message', 'Offer Successfully taken');
	 	    }
			else{
				return Redirect::to('users/dashboard')->with('message', 'Your offer timings are conflicting with an existing offer at same location and resturant try choosing another offer');
			}
	   }

	public function goodtogo($resturant_offer_id = null){
		if($resturant_offer_id){
			$user_id=Auth::user()->id;
			$ifAnyoffer = DB::select('select * from offers_taken where user_id='.$user_id);
			//there is not even an order to conflict
			if(empty($ifAnyoffer)){
				//die('good to go');
				return true;
			}
			//there may be an confliction go chekc it!
			else{

			/* starting at calculate */
					$dayname = DB::select("select name from days where iddays=".Input::get('day_id'));
		 	    	$dayname  = $dayname[0]->name;
		 	    	$tmpStart = Input::get('starting_at');
		 			$date = date("Y/m/d");
		 	    	if($dayname == date('l')){
		 	    		$starting_at = strtotime(Input::get('starting_at'));
		 	    		$current_time = strtotime(date('H:i:s'));
		 	    		if($current_time >= $starting_at){
		 	    			$nextDate =  date('Y/m/d',strtotime($date . "+1 days"));
					 	}
					 	else{
					 		$nextDate =$date;
					 	} 
		 	    	}
		 	    	else{
		 	    		$nextDate =$date;
		 	    	}
					$tomorrow = date('l',strtotime($nextDate));
					while($tomorrow!=$dayname){
						$nextDate = date('Y/m/d',strtotime($nextDate . "+1 days"));
						$tomorrow = date('l',strtotime($nextDate));
					}
					$nextDate = str_replace('/', '-', $nextDate);
					echo $starting_at = $nextDate. ' '.$tmpStart;  
			/* starting at calculate ends */
			
/*Custom*/
$conf = DB::select("select idresturants_offers,location_id,resturant_id from resturants_offers where idresturants_offers=".Input::get('resturant_offer_id'));
$loc_id = $conf[0]->location_id;
$rest_id = $conf[0]->resturant_id;
/*Custom Ends*/


				$confliction = DB::select("select 
					offers_taken.*,
					resturants_offers.*,
					offers.offername,
					resturants.r_id,
					locations.loc_id
					from offers_taken 
					inner join resturants_offers on resturants_offers.idresturants_offers=offers_taken.offer_id 
					inner join offers on offers.idoffers=resturants_offers.offer_id
					inner join resturants on resturants.r_id=resturants_offers.resturant_id 
					inner join locations on locations.loc_id = resturants_offers.location_id
					where  
					offers_taken.ending_at>'$starting_at' 
					and resturants_offers.location_id=$loc_id 
					and resturants_offers.resturant_id=$rest_id 
					and user_id =".Auth::user()->id ." 
					order by resturants_offers.resturant_id DESC"
				);
				if(!empty($confliction)){
					return  false;
				}
				else{
					return true;
				}
/*custom finding ends*/
				
			}
			return true;
		}
		else{
			return false;
		}
	}
}
/*
$rules = array(
			'password'         => 'required',
			'password_confirm' => 'required|same:password',
			'email' => 'unique:tb_users,email',
			'username' => 'unique:tb_users,username'
		);
		if(Input::get('id') !=''){
			array_pop($rules);
			array_pop($rules);
		}
		
		$messages = array(
		    'password_confirm.same' => 'Both Passwords Must Match',
		    'email.unique'=> 'User email is already taken.  Please enter a different Location Manager’s Email',
		    'username.unique'=> 'UserName is already taken.  Please enter a different Location Manager’s UserName'
		);
		*/