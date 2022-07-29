<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
  use Auth,View,Config;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public $model				=	'jobs';
    public function __construct(Request $request) {
		$this->middleware('auth');
        View()->share('model',$this->model);
        $this->request = $request;
    }
   /* sales blade */
    public function index(Request $request)
    {
        $userDetails			=	Auth::user();
        
		if($userDetails->type != SALES_ROLE_ID){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
			$DB					=	Job::query();
			$searchVariable		=	array(); 
			$inputGet			=	$request->all();
			if ($request->all()) {
				$searchData			=	$request->all();
				unset($searchData['display']);
				unset($searchData['_token']);
	
				if(isset($searchData['order'])){
					unset($searchData['order']);
				}
				if(isset($searchData['sortBy'])){
					unset($searchData['sortBy']);
				}
				if(isset($searchData['page'])){
					unset($searchData['page']);
				}
				if((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))){
					$dateS = $searchData['date_from'];
					$dateE = $searchData['date_to'];
					$DB->whereBetween('jobs.created_at', [$dateS." 00:00:00", $dateE." 23:59:59"]); 											
				}elseif(!empty($searchData['date_from'])){
					$dateS = $searchData['date_from'];
					$DB->where('jobs.created_at','>=' ,[$dateS." 00:00:00"]); 
				}elseif(!empty($searchData['date_to'])){
					$dateE = $searchData['date_to'];
					$DB->where('jobs.created_at','<=' ,[$dateE." 00:00:00"]); 						
				}
				foreach($searchData as $fieldName => $fieldValue){
					if($fieldValue != ""){
						if($fieldName == "name"){
							$DB->where("jobs.name",'like','%'.$fieldValue.'%');
						}
						if($fieldName == "is_active"){
							$DB->where("jobs.is_active",$fieldValue);
						}
					}
					$searchVariable	=	array_merge($searchVariable,array($fieldName => $fieldValue));
				}
			}
			$DB->where("job_status",'created');
			$DB->select("jobs.*");
			$sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'created_at';
			$order  = ($request->input('order')) ? $request->input('order')   : 'DESC';	
			$records_per_page	    =	($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
			$results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
			$complete_string		=	$request->query();
			unset($complete_string["sortBy"]);
			unset($complete_string["order"]);
			$query_string			=	http_build_query($complete_string);
			$results->appends($inputGet)->render();
			return  View("salesHome",compact('results','searchVariable','sortBy','order','query_string'));
			 
		}
        // return view('salesHome');
    } 
   
    public function adminHome(Request $request)
    {
		$userDetails			=	Auth::user();
        
		if($userDetails->type != ADMIN_ROLE_ID){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
			$DB					=	Job::query();
			$searchVariable		=	array(); 
			$inputGet			=	$request->all();
			if ($request->all()) {
				$searchData			=	$request->all();
				unset($searchData['display']);
				unset($searchData['_token']);
	
				if(isset($searchData['order'])){
					unset($searchData['order']);
				}
				if(isset($searchData['sortBy'])){
					unset($searchData['sortBy']);
				}
				if(isset($searchData['page'])){
					unset($searchData['page']);
				}
				if((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))){
					$dateS = $searchData['date_from'];
					$dateE = $searchData['date_to'];
					$DB->whereBetween('jobs.created_at', [$dateS." 00:00:00", $dateE." 23:59:59"]); 											
				}elseif(!empty($searchData['date_from'])){
					$dateS = $searchData['date_from'];
					$DB->where('jobs.created_at','>=' ,[$dateS." 00:00:00"]); 
				}elseif(!empty($searchData['date_to'])){
					$dateE = $searchData['date_to'];
					$DB->where('jobs.created_at','<=' ,[$dateE." 00:00:00"]); 						
				}
				foreach($searchData as $fieldName => $fieldValue){
					if($fieldValue != ""){
						if($fieldName == "name"){
							$DB->where("jobs.name",'like','%'.$fieldValue.'%');
						}
						if($fieldName == "is_active"){
							$DB->where("jobs.is_active",$fieldValue);
						}
					}
					$searchVariable	=	array_merge($searchVariable,array($fieldName => $fieldValue));
				}
			}
			// $DB->where("job_status",'order');
			$DB->select("jobs.*");
			$sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'created_at';
			$order  = ($request->input('order')) ? $request->input('order')   : 'DESC';	
			$records_per_page	    =	($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
			$results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
			$complete_string		=	$request->query();
			unset($complete_string["sortBy"]);
			unset($complete_string["order"]);
			$query_string			=	http_build_query($complete_string);
			$results->appends($inputGet)->render();
			return  View("adminHome",compact('results','searchVariable','sortBy','order','query_string'));
			 
		}
        // return view('adminHome');
    }
   
    public function managerHome(Request $request)
    {
		$userDetails			=	Auth::user();
        
		if($userDetails->type != MANAGER_ROLE_ID){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
			$DB					=	Job::query();
			$searchVariable		=	array(); 
			$inputGet			=	$request->all();
			if ($request->all()) {
				$searchData			=	$request->all();
				unset($searchData['display']);
				unset($searchData['_token']);
	
				if(isset($searchData['order'])){
					unset($searchData['order']);
				}
				if(isset($searchData['sortBy'])){
					unset($searchData['sortBy']);
				}
				if(isset($searchData['page'])){
					unset($searchData['page']);
				}
				if((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))){
					$dateS = $searchData['date_from'];
					$dateE = $searchData['date_to'];
					$DB->whereBetween('jobs.created_at', [$dateS." 00:00:00", $dateE." 23:59:59"]); 											
				}elseif(!empty($searchData['date_from'])){
					$dateS = $searchData['date_from'];
					$DB->where('jobs.created_at','>=' ,[$dateS." 00:00:00"]); 
				}elseif(!empty($searchData['date_to'])){
					$dateE = $searchData['date_to'];
					$DB->where('jobs.created_at','<=' ,[$dateE." 00:00:00"]); 						
				}
				foreach($searchData as $fieldName => $fieldValue){
					if($fieldValue != ""){
						if($fieldName == "name"){
							$DB->where("jobs.name",'like','%'.$fieldValue.'%');
						}
						if($fieldName == "is_active"){
							$DB->where("jobs.is_active",$fieldValue);
						}
					}
					$searchVariable	=	array_merge($searchVariable,array($fieldName => $fieldValue));
				}
			}
			$DB->where("job_status",'order');
			$DB->select("jobs.*");
			$sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'created_at';
			$order  = ($request->input('order')) ? $request->input('order')   : 'DESC';	
			$records_per_page	    =	($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
			$results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
			$complete_string		=	$request->query();
			unset($complete_string["sortBy"]);
			unset($complete_string["order"]);
			$query_string			=	http_build_query($complete_string);
			$results->appends($inputGet)->render();
			return  View("managerHome",compact('results','searchVariable','sortBy','order','query_string'));
			 
		}
        // return view('managerHome');
    }
    public function cashierHome(Request $request)
    {
		$userDetails			=	Auth::user();
        
		if($userDetails->type != CASHIER_ROLE_ID){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
			$DB					=	Job::query();
			$searchVariable		=	array(); 
			$inputGet			=	$request->all();
			if ($request->all()) {
				$searchData			=	$request->all();
				unset($searchData['display']);
				unset($searchData['_token']);
	
				if(isset($searchData['order'])){
					unset($searchData['order']);
				}
				if(isset($searchData['sortBy'])){
					unset($searchData['sortBy']);
				}
				if(isset($searchData['page'])){
					unset($searchData['page']);
				}
				if((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))){
					$dateS = $searchData['date_from'];
					$dateE = $searchData['date_to'];
					$DB->whereBetween('jobs.created_at', [$dateS." 00:00:00", $dateE." 23:59:59"]); 											
				}elseif(!empty($searchData['date_from'])){
					$dateS = $searchData['date_from'];
					$DB->where('jobs.created_at','>=' ,[$dateS." 00:00:00"]); 
				}elseif(!empty($searchData['date_to'])){
					$dateE = $searchData['date_to'];
					$DB->where('jobs.created_at','<=' ,[$dateE." 00:00:00"]); 						
				}
				foreach($searchData as $fieldName => $fieldValue){
					if($fieldValue != ""){
						if($fieldName == "name"){
							$DB->where("jobs.name",'like','%'.$fieldValue.'%');
						}
						if($fieldName == "is_active"){
							$DB->where("jobs.is_active",$fieldValue);
						}
					}
					$searchVariable	=	array_merge($searchVariable,array($fieldName => $fieldValue));
				}
			}
			$DB->where("job_status",'completed');
			$DB->select("jobs.*");
			$sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'created_at';
			$order  = ($request->input('order')) ? $request->input('order')   : 'DESC';	
			$records_per_page	    =	($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
			$results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
			$complete_string		=	$request->query();
			unset($complete_string["sortBy"]);
			unset($complete_string["order"]);
			$query_string			=	http_build_query($complete_string);
			$results->appends($inputGet)->render();
			return  View("cashierHome",compact('results','searchVariable','sortBy','order','query_string'));
			 
		}
        // return view('cashierHome');
    }
}