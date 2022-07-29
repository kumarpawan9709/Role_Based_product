<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Validator;
use Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $model				=	'jobs';
    public function __construct(Request $request) {
		$this->middleware('auth');
        View()->share('model',$this->model);
        $this->request = $request;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View("addJobs");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $userDetails			=	Auth::user();
        
		if(!in_array($userDetails->type,[ADMIN_ROLE_ID,SALES_ROLE_ID])){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
            $thisData                       =    $request->all();
        
            $validator = Validator::make(
                array(
                    'name'           => $thisData['name'],
                    'email'          => $thisData['email'],
                    'phone'          => $thisData['phone'],
                    'comment'        => $thisData['comment'],
                ),
                array(   
                    'name'          =>  'required',
                    'email'         =>  'required|email|unique:jobs',
                    'phone'         =>  'required|numeric',
                    'comment'       =>  'required',
                ),
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }  else{
                
                $obj 							= new Job;
                $obj->name   	            	= $thisData['name'];
                $obj->email   	            	= $thisData['email'];
                $obj->phone   	            	= $thisData['phone'];
                $obj->comment   	            = $thisData['comment'];
                $objSave				        = $obj->save();
                if(!$objSave) {
                    Session()->flash('error', trans("Something went wrong.")); 
                    return redirect('login');
                }
                
                Session()->flash('success',"Job has been added successfully");
                return redirect('login');
            } 
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($enjobid)
    {
        $userDetails			=	Auth::user();
        
		if(!in_array($userDetails->type,[ADMIN_ROLE_ID,SALES_ROLE_ID,MANAGER_ROLE_ID])){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
            $job_id   = ''; 
            $multiLanguage		 	=	array();
            if (!empty($enjobid)) {
                $job_id = base64_decode($enjobid);
                $jobDetails             =   Job::find($job_id); 
                
                return  View("editJobs",array('catDetails' => $jobDetails));
            } else {
                return redirect()->route($this->model . ".index");
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enjobid)
    {
        $userDetails			=	Auth::user();
        
		if(!in_array($userDetails->type,[ADMIN_ROLE_ID,SALES_ROLE_ID,MANAGER_ROLE_ID])){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
             
                $job_id = '';  
                $thisData                       =    $request->all();
                if (!empty($enjobid)) {
                    $job_id = base64_decode($enjobid);   
                    $validator = Validator::make(
                        array(
                            'name'           => $thisData['name'],
                            'email'          => $thisData['email'],
                            'phone'          => $thisData['phone'],
                            'comment'        => $thisData['comment'],
                            'job_status'        => $thisData['job_status'],
                        ),
                        array(   
                            'name'          =>  'required',
                            'email'         =>  'required|email',
                            'phone'         =>  'required|numeric',
                            'comment'       =>  'required',
                            'job_status'       =>  'required',
                        ),
                    );
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                    
                        
                        $obj                            =   Job::find($job_id);
                        $obj->name   	            	=   $thisData['name'];
                        $obj->email   	            	=   $thisData['email'];
                        $obj->phone   	            	=   $thisData['phone'];
                        $obj->comment   	            =   $thisData['comment'];
                        $obj->job_status   	            =   $thisData['job_status'];
                        $objSave	                    =   $obj->save();

                        if(!$objSave) {
                            Session()->flash('error', trans("Something went wrong.")); 
                            return back();
                        }
                        
                        Session()->flash('success',"Job has been updated successfully");
                        return back();
                    }

                } else {
                    return back();
                }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($enjobid)
    {
        $userDetails			=	Auth::user();
        
		if(!in_array($userDetails->type,[ADMIN_ROLE_ID])){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
            $job_id = '';
            if (!empty($enjobid)) {
                $job_id = base64_decode($enjobid);
            } else {
                return redirect('login');
            }
            Job::where('id', $job_id)->delete();
        
            Session()->flash('flash_notice', trans("Job has been removed successfully"));
            return back();
        }
    }
    public function changeStatus($modelId = 0, $status = 0){
        $userDetails			=	Auth::user(); 
		if(!in_array($userDetails->type,[ADMIN_ROLE_ID,SALES_ROLE_ID])){
            return response()->json(['You do not have permission to access for this page.']); 
			// return Redirect::route('user.dashboard');
		}else{
            if ($status == 1) {
                $statusMessage   =   trans("Job has been deactivated successfully");
            } else {
                $statusMessage   =   trans("Job has been activated successfully");
            }
            $user = Job::find($modelId);
            if ($user) {
                $currentStatus = $user->is_active;
                if (isset($currentStatus) && $currentStatus == 0) {
                    $NewStatus = 1;
                } else {
                    $NewStatus = 0;
                }
                $user->is_active = $NewStatus;
                $ResponseStatus = $user->save();
            }
            Session()->flash('flash_notice', $statusMessage);
            return back();
        }
    }

    public function updatePrice(Request $request){
        $job_id	=	!empty($request->input('job_id')) ? $request->input('job_id') : 0;
        $price	=	!empty($request->input('price')) ? $request->input('price') : 0;
		$model			=	Job::where('id',$job_id) 
							->where("is_active",1)
							->first();	
							
		if(!empty($model)) {
            $data=Job::where('id', $job_id)->update(array('amount' =>  $price));
			if(!empty($data)){
				return response()->json( array('success' => true,'message'=>trans('Amount has been updated.')) );
			}else{
                return response()->json( array('success' => false,'message'=>trans('Currently there is no any job with this id.')) );
            } 
		} else{
            return response()->json( array('success' => false,'message'=>trans('Currently there is no any job with this id.')) );
        } 
    }
}
