<?php 

if(Auth::user())
{
    if(Auth::user()->user_type == 0)
    {
            if(Auth::user()->profile == 1)
            {
                $profile = 'true';
            }else{
               
                $profile = 'false';
            }
        
            $customerProfile = get_customer_and_address_by__user_id(Auth::user()->id);
            //pr($customerProfile);
           
            if(!empty($customerProfile)){
                $flag = ($customerProfile->status == 2);
            }else{
                $flag = ($profile == 'false' || $customerProfile->status == 2 || $customerProfile->status == 0);

            }
        if($flag)
        {

               
            
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    {{-- <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        {{-- <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li> --}}
        {{-- <li class="breadcrumb-item active">Profile</li>
    </ol>  --}}
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    
    <!-- <h1 class="page-header">CUSTOMER <small>Profile</small></h1> -->

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">CREATE YOUR PROFILE</h4>
                    
                </div>
                {{-- <div class="panel-body"> --}}
                    
                   
                        <!-- begin breadcrumb -->
                        {{-- <ol class="breadcrumb float-xl-right">
                            <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol> --}}
                        <!-- end breadcrumb -->
                        <!-- begin page-header -->
                    <!-- <h1 class="page-header form-layout">Profile <small>{{(@$customerProfile->status == 0)? 'Pending':((@$customerProfile->status == 2)? 'Rejected,':'')}} {{(@$customerProfile->remark)? 'Remark: '.@$customerProfile->remark:''}}</small></h1> -->
                        <!-- end page-header -->
                        <!-- begin wizard-form -->
                    <form action="{{route('saveCustomerProfileDetails')}}" method="POST" id="saveCustomerProfileDetails" class="form-control-with-bg form-layout saveCustomerProfileDetails" enctype="multipart/form-data">
                           
                        <input type="hidden" name="customer_id" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="c_id" value="{{@$customerProfile->cust_id}}"/>
                        <input type="hidden" name="address_id" value="{{@$customerProfile->address_id}}"/>
                        <input type="hidden" name="docs_id" value="{{@$customerProfile->docs_id}}"/>
                            <!-- begin wizard -->
                            <div id="wizard" class="sw-main sw-theme-default m-t-10">
                                <!-- begin wizard-step -->
                                <ul>
                                    <li>
                                        <a href="#step-1">
                                            <span class="number">1</span> 
                                            <span class="info">
                                                Personal Info
                                                <small>Name, Mobile Number and your Email address </small>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-2">
                                            <span class="number">2</span> 
                                            <span class="info">
                                                Business Profile
                                                <small>Your Business info</small>
                                            </span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="#step-3">
                                            <span class="number">3</span> 
                                            <span class="info">
                                                Enter your address
                                                <small>Enter your permanent address</small>
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li>
                                        <a href="#step-4">
                                            <span class="number">4</span> 
                                            <span class="info">
                                                Enter Your Team
                                                <small>Enter your Team Info</small>
                                            </span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="#step-5">
                                            <span class="number">3</span> 
                                            <span class="info">
                                                Document Upload
                                                <small>Please upload the document</small>
                                                <!-- <small>Upload your documents</small> -->
                                            </span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="#step-4">
                                            <span class="number">4</span> 
                                            <span class="info">
                                                Enter your default address
                                                <small>Enter your default address</small>
                                            </span>
                                        </a>
                                    </li> --}}
                                    {{-- <li>
                                        <a href="#step-5">
                                            <span class="number">5</span>
                                            <span class="info">
                                                Login Account
                                                <small>Enter your username and password</small>
                                            </span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="#step-6">
                                            <span class="number">4</span> 
                                            <span class="info">
                                                Completed
                                                <!-- <small>Create Your Profile</small> -->
                                                <small>Save your profile</small>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- end wizard-step -->
                                <!-- begin wizard-content -->
                                <div>
                                    <!-- begin step-1 -->
                                    <div id="step-1">
                                        
                                        <fieldset>
                                           
                                            <div >
                                               
                                                <div class="row">
                                                    <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Create your profile</legend> -->
                                                   
                                                  
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">First Name <span class="required-star">* </span></label>
                                                        <input class="form-control form-br" type="text" id="cutomer_fname" name="cutomer_fname" value="{{@$customerProfile->cutomer_fname}}" placeholder="Please enter first name" data-parsley-required="true">
                                                        </div>
                                               
                                                     
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class=" text-lg-right col-form-label">Last Name <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="cutomer_lname" name="cutomer_lname" value="{{@$customerProfile->cutomer_lname}}" placeholder="Please enter last name" data-parsley-required="true">
                                                        </div>
                                                  
                                                  
                                                      
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Mobile Number <span class="required-star">* </span></label>
                                                        <input class="form-control form-br" type="text" id="phone" name="mobile" value="{{Auth::user()->mobile}}" {{(Auth::user()->mobile)? 'readonly':''}} placeholder="Please enter phone number" data-parsley-required="true">
                                                        </div>
                                                   
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Email Address</label>
                                                            <input class="form-control form-br" type="email" id="email" name="email" value="{{Auth::user()->email}}" {{(Auth::user()->email)? 'readonly':''}} placeholder="Please enter your email" data-parsley-required="true">
                                                        </div>

                                                        
                                                        
                                                  
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Alternative Phone number</label>
                                                            <input class="form-control form-br" type="number" id="alternate_phone" name="alternate_phone" value="{{Auth::user()->alternate_phone}}"  placeholder="Please enter your alternate phone number" data-parsley-required="true">
                                                        </div>
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Date of Birth</label>
                                                            <input class="form-control form-br" type="date" id="dob" name="dob" value="{{@$customerProfile->dob}}" placeholder="Please enter date of birth">
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Spouse name </label>
                                                            <input class="form-control form-br" type="text" id="supouse_name" name="supouse_name" value="{{@$customerProfile->supouse_name}}" placeholder="Please enter supouse name">
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Anniversary Date </label>
                                                            <input class="form-control form-br" type="date" id="anniversary_date" name="anniversary_date" value="{{@$customerProfile->anniversary_date}}" placeholder="Please enter anniversary date">
                                                            
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Shop Establishment Date </label>
                                                            <input class="form-control form-br" type="date" id="shop_estable_date" name="shop_estable_date" value="{{@$customerProfile->shop_estable_date}}" placeholder="Please enter Shop Establishment Date">
                                                            
                                                        </div>


                                                   
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="phone">Phone</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="phone" name="phone" placeholder="Please enter phone number">
                                                        </div>
                                                    </div> --}}
                                                    
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="gender">Gender <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control" id="gender" name="gender" placeholder="Please select gender" data-parsley-required="true">
                                                                <option value="">Please select gender</option>
                                                                <option value="Male" {{(@$customerProfile->gender == 'Male')? 'selected':''}}>Male</option>
                                                                <option value="Female"  {{(@$customerProfile->gender == 'Female')? 'selected':''}}>Female</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="customer_type">Customer Type <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <select class="form-control" id="customer_type" name="customer_type" placeholder="Please select customer type">
                                                                <option value="">Please select customer type</option>
                                                                <option value="1" {{(@$customerProfile->customer_type == 1)? 'selected':''}}>General</option>
                                                                <option value="2" {{(@$customerProfile->customer_type == 2)? 'selected':''}}>Wholesale</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </fieldset>
                                       
                                    </div>
                                    <!-- end step-1 -->
                                    <!-- begin step-2 -->
                                    <div id="step-2">
                                       
                                        <fieldset>
                                            
                                            <div>
                                                
                                                <div class="row">
                                                    <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Your Business info, so that you can easily attach we</legend> -->
                                                   
                                                   
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Store Name <span class="required-star">* </span></label>
                                                        <input class="form-control form-br" type="text" id="store_name" name="store_name"  value="{{@$customerProfile->store_name}}" placeholder="Please enter your store name" data-parsley-required="true">
                                                        </div>
                                                  
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label" for="customer_type">Customer Type <span class="required-star">* </span></label>
                                                        <select class="form-control form-br" id="customer_type" name="customer_type" placeholder="Please select customer type">
                                                                <option value="">Please select customer type</option>
                                                                <option value="1" {{(@$customerProfile->customer_type == 1)? 'selected':''}}>Dealer</option>
                                                                <option value="2" {{(@$customerProfile->customer_type == 2)? 'selected':''}}>Wholesale</option>
                                                                <option value="3" {{(@$customerProfile->customer_type == 3)? 'selected':''}}>Distibuter</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Shop Number </label>
                                                            <input class="form-control form-br" type="text" id="shop_number" name="shop_number"  value="{{@$customerProfile->shop_number}}" placeholder="Please enter your shop number">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Street </label>
                                                            <input class="form-control form-br" type="text" id="street" name="street"  value="{{@$customerProfile->street}}" placeholder="Please enter your street">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                           <h5 class="m-t-10 m-b-0 f-w-700 f-s-16"> Communication Address</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                   
                                                        
                                                   
                                                        <div class="col-lg-12 col-xl-12">
                                                              <label class="text-lg-right col-form-label">Address <span class="required-star">* </span></label>
                                                            <textarea class="form-control form-br" id="business_street_address" name="business_street_address" placeholder="Please enter address" data-parsley-required="true">{{@$customerProfile->business_street_address}}</textarea>
                                                        </div>
                                                   </div>
                                                   <div class="row">
                                                   <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                            <input class="form-control form-br business_postal_code" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div>

                                                   
                                                      
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label" for="business_country">Country <span class="required-star">* </span></label>
                                                            <select class="form-control form-br country" id="business_country" name="business_country" placeholder="Please select country" data-parsley-required="true">
                                                                <option value="">Please select country</option>
                                                                <?php
                                                                        $countryes = getCountry();
                                                                        foreach($countryes as $country){
                                                                    ?>
                                                                                <option value="{{$country->id}}" {{($country->id == @$customerProfile->business_country || ($country->id == '101'))? 'selected':''}}>{{$country->name}}</option>
                        
                                                                    <?php } ?>
                                                             
                                                                
                                                            </select>
                                                      
                                                    </div>
                                                   
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                                <label class="text-lg-right col-form-label" for="business_state">State <span class="required-star">* </span></label>
                                                            <select class="form-control form-br state" id="business_state" name="business_state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <?php 
                                                                $state = get_stateNameByStateId(@$customerProfile->business_state);
                                                                $stateDefaultIndia = DB::table('states')->where('country_id', 101)->get();
                                                                foreach($stateDefaultIndia as $stateDef){ 
                                                            ?>
                                                                <option value="{{$stateDef->id}}" {{($stateDef->id == @$customerProfile->business_state) ? 'selected' : ''}}>{{ $stateDef->name }}</option>
                                                                <!-- <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option> -->
                                                                
                                                            <?php }?> 
                                                            </select>
                                                            
                                                            
                                                        </div>
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_city">City <span class="required-star">* </span></label>
                                                            <select class="form-control form-br city" id="business_city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select city</option>
                                                                <?php 
                                                                    $city = get_cityNameByCityId(@$customerProfile->business_city);
                                                                    
                                                                ?>
                                                                    <option value="{{@$customerProfile->business_city}}" selected>{{@$city->name}}</option>
                                                                
                                                            </select>
                                                            {{-- <input class="form-control" type="text" id="business_city" name="business_city" value="{{ @$customerProfile->business_city }}" placeholder="Please enter city" data-parsley-required="true"> --}}
                                                        </div>
                                                 
                                                  
                                                        <!-- <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div> -->
                                                   
                                                   </div>

                                                   <div class="row">
                                                       <div class="col-lg-12 m-t-20 m-b-20">
                                                   
                                                            <input type="checkbox" class="form-check-label m-r-5"> <strong>
                                                         Communication Address Copy to Billing Address
                                                            </strong>
                                                      
                                                       </div>
                                                   </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                           <h5 class="f-w-700 f-s-16">Billing Address</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                   
                                                        
                                                   
                                                        <div class="col-lg-12 col-xl-12">
                                                              <label class="text-lg-right col-form-label">Address <span class="required-star">* </span></label>
                                                            <textarea class="form-control form-br" id="business_street_address" name="business_street_address" placeholder="Please enter address" data-parsley-required="true">{{@$customerProfile->business_street_address}}</textarea>
                                                        </div>
                                                   </div>
                                                   <div class="row">
                                                   <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                            <input class="form-control form-br business_postal_code" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div>

                                                   
                                                      
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label" for="business_country">Country <span class="required-star">* </span></label>
                                                            <select class="form-control form-br country" id="business_country" name="business_country" placeholder="Please select country" data-parsley-required="true">
                                                                <option value="">Please select country</option>
                                                                <?php
                                                                        $countryes = getCountry();
                                                                        foreach($countryes as $country){
                                                                    ?>
                                                                                <option value="{{$country->id}}" {{($country->id == @$customerProfile->business_country || ($country->id == '101'))? 'selected':''}}>{{$country->name}}</option>
                        
                                                                    <?php } ?>
                                                             
                                                                
                                                            </select>
                                                      
                                                    </div>
                                                   
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                                <label class="text-lg-right col-form-label" for="business_state">State <span class="required-star">* </span></label>
                                                            <select class="form-control form-br state" id="business_state" name="business_state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <?php 
                                                                $state = get_stateNameByStateId(@$customerProfile->business_state);
                                                                $stateDefaultIndia = DB::table('states')->where('country_id', 101)->get();
                                                                foreach($stateDefaultIndia as $stateDef){ 
                                                            ?>
                                                                <option value="{{$stateDef->id}}" {{($stateDef->id == @$customerProfile->business_state) ? 'selected' : ''}}>{{ $stateDef->name }}</option>
                                                                <!-- <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option> -->
                                                                
                                                            <?php }?> 
                                                            </select>
                                                            
                                                            
                                                        </div>
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_city">City <span class="required-star">* </span></label>
                                                            <select class="form-control form-br city" id="business_city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select city</option>
                                                                <?php 
                                                                    $city = get_cityNameByCityId(@$customerProfile->business_city);
                                                                    
                                                                ?>
                                                                    <option value="{{@$customerProfile->business_city}}" selected>{{@$city->name}}</option>
                                                                
                                                            </select>
                                                            {{-- <input class="form-control" type="text" id="business_city" name="business_city" value="{{ @$customerProfile->business_city }}" placeholder="Please enter city" data-parsley-required="true"> --}}
                                                        </div>
                                                 
                                                  
                                                        <!-- <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div> -->
                                                   
                                                   </div>

                                                 <!--   <div class="row">
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="document_option">Statutory Document <span class="required-star">* </span></span></label>
                                                             
                                                             <input class="form-control form-br" type="hidden" name="checkNum" id="checkNum">
                                                            <select class="form-control form-br" id="document_option" name="document_option" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select Document</option> 
                                                                <option value="panNumber">PAN</option>
                                                                <option value="gstNumber">GST</option>
                                                                <option value="dlNumber">Driving License</option>
                                                                <option value="cancelCheck">Cancelled Cheque</option>  
                                                            </select>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-lg-3 col-xl-3" id="panNumber" style="display:none">

                                                            <label class="text-lg-right col-form-label removeField"> PAN <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="pan_number" id="pan_number" placeholder="Please enter your PAN number">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="gstNumber" style="display:none">

                                                            <label class="text-lg-right col-form-label removeField"> GSTIN <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span> </label>
                                                            <input class="form-control form-br" type="text" name="business_gst_number" id="business_gst_number" placeholder="Please enter your GSTIN">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="dlNumber" style="display:none">

                                                            <label class="text-lg-right col-form-label removeField"> Driving License <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="dl_number" id="dl_number" placeholder="Please enter your Driving License Number">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="cancelCheck" style="display:none">

                                                            <label class="text-lg-right col-form-label removeField"> Cancel Check <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="cancel_check"  id="cancel_check" placeholder="Please enter your Cancel Check Number">
                                                        </div>
                                                 
                                                   
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                        <a href="javascript:void(0);" class="btn btn-primary" onclick="getLocation();"><i class="map-marker"></i>Get current location</a>
                                                             <label class="text-lg-right col-form-label" for="geo_location">Current location</label>
                                                             <textarea class="form-control form-br"  id="geo_location" name="geo_location" placeholder="Please enter geo location"></textarea>
                                                            <input class="form-control form-br" type="hidden" id="latitude" name="latitude">
                                                            <input class="form-control form-br" type="hidden" id="longitude" name="longitude" >
                                                        </div>
                                                    
                                                </div> -->
                                                   <!-- <div class="row">
                                                        
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_city">Statutory Document <span class="required-star">* </span></label>
                                                            <select class="form-control form-br city" id="business_city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select Document</option> 
                                                                <option value="">PAN</option>
                                                                <option value="">GST</option>
                                                                <option value="">Driving License</option>
                                                                <option value="">Cancelled Cheque</option>  
                                                            </select>
                                                            
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">

                                                        <label class="text-lg-right col-form-label" for="business_gst_number"> GSTIN </label>
                                                            <input class="form-control form-br" type="text" name=""  placeholder="Please enter your GSTIN">
                                                        </div>
                                                 
                                                   
                                                   
                                                    
                                                </div> -->
                                                   <!-- <div class="row">
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_city">Statutory Document <span class="required-star">* </span></label>
                                                            <select class="form-control form-br city" id="business_city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select Document</option> 
                                                                <option value="">PAN</option>
                                                                <option value="">GST</option>
                                                                <option value="">Driving License</option>
                                                                <option value="">Cancelled Cheque</option>  
                                                            </select>
                                                            
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">

                                                        <label class="text-lg-right col-form-label" for="business_gst_number"> GSTIN </label>
                                                            <input class="form-control form-br" type="text" name=""  placeholder="Please enter your GSTIN">
                                                        </div>
                                                 
                                                   
                                                    
                                                    
                                                    
                                                </div> -->

                                                <!-- <div class="row">
                                                       
                                                       <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Payment Option <span class="required-star">* </span></label>
                                                            
                                                            <select class="form-control" name="payment_option">
                                                                <option value="">Select Payment Option</option>
                                                                <option value="Online payment" {{(trim(@$customerProfile->payment_option ==="Online payment"))? 'selected':''}}>Online payment</option>
                                                                <option value="Cash on Delivery" {{(trim(@$customerProfile->payment_option ==="Cash on Delivery"))? 'selected':''}}>Cash on Delivery</option>
                                                                <option value="On Credit" {{(trim(@$customerProfile->payment_option ==="On Credit"))? 'selected':''}}>On Credit</option>
                                                            </select>
                                                           
                                                       </div>
                                                       
                                                </div> -->
                                                
                                            </div>
                                            
                                        </fieldset>
                                       
                                    </div>
                                    <!-- end step-2 -->
                                    <!-- begin step-3 -->
                                    {{-- <div id="step-3">
                                        
                                        <fieldset>
                                           
                                            <div>
                                               
                                                <div class="row">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You address info, so that we can easily reach you</legend>
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">Company name</label>
                                                        <input type="text" name="company_name" value="{{@$customerProfile->company_name}}" placeholder="Please enter company name" class="form-control" />
                                                        </div>
                                                   
                                                 
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                                <label class="text-lg-right col-form-label">First name <span class="required-star">* </span></label>
                                                        <input type="text" name="f_name" value="{{@$customerProfile->f_name}}" placeholder="Please enter first name" class="form-control"  data-parsley-required="true"/>
                                                        </div>
                                               
                                                   
                                                        <div class="col-lg-3 col-xl-3">
                                                          <label class="text-lg-right col-form-label">Last name <span class="required-star">* </span></label>
                                                        <input type="text" name="l_name" value="{{@$customerProfile->l_name}}" placeholder="Please enter last name" class="form-control"  data-parsley-required="true"/>
                                                        </div>
                                               
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">phone <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="phone" placeholder="Please enter phone number" class="form-control" />
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Address <span class="required-star">*</span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <!-- <input class="form-control" type="text" id="street_address" name="business_street_address" value="{{@$customerProfile->business_street_address}}" placeholder="Please enter address" data-parsley-required="true"> -->
                                                            <input class="form-control" type="text" id="street_address" name="street_address" value="{{@$customerProfile->street_address}}" placeholder="Please enter address" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="country">Country <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control country" id="country" name="country" placeholder="Please select your country" data-parsley-required="true">
                                                                <option value="">Please select your country</option>
                                                                <?php
                                                                    $countryes = getCountry();
                                                                    foreach($countryes as $country){
                                                                ?>
                                                                    <option value="{{$country->id}}" {{($country->id == @$customerProfile->country)? 'selected':''}}>{{$country->name}}</option>

                                                                <?php } ?>
                                                              
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="state">State <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control state" id="state" name="state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <?php 
                                                                $state = get_stateNameByStateId(@$customerProfile->state);
                                                                
                                                            ?>
                                                                <option value="{{@$customerProfile->state}}" selected>{{@$state->name}}</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="city">City <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control city" id="city" name="city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select city</option>
                                                                <?php 
                                                                    $city = get_cityNameByCityId(@$customerProfile->city);
                                                                ?>
                                                                    <option value="{{@$customerProfile->city}}" selected>{{@$city->name}}</option>
                                                                
                                                            </select>
                                                            <input class="form-control" type="text" id="city" name="city" value="{{ @$customerProfile->city }}" placeholder="Please enter your city" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="postal_code">Postal Code <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="postal_code" name="postal_code" value="{{ @$customerProfile->postal_code }}" placeholder="Please enter your postal code" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="text-lg-right col-form-label" for="gst_number"> GSTIN <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="gst_number" name="gst_number" value="{{ @$customerProfile->gst_number }}" placeholder="Please enter your GSTIN">
                                                        </div>
                                                    </div>

                                                    <h2>Address 2</h2>

                                                    <?php
                                                    $addressSecound = DB::table('tbl_addresses')->where('customer_id', @$customerProfile->cust_id)
                                                                ->where('address_user_id', Auth::user()->id)
                                                                ->where('id', '!=', @$customerProfile->address_id)->first();
                                                             //pr($addressSecound); 
                                                             
                                                    ?>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">First name </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input type="text" name="addr2_fname" value="{{(@$addressSecound) ? @$addressSecound->f_name:''}}" placeholder="Please enter first name" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Last name </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input type="text" name="addr2_lname" value="{{(@$addressSecound) ? @$addressSecound->l_name:''}}" placeholder="Please enter last name" class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Address </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="addr2_street_address" name="addr2_street_address" value="{{(@$addressSecound) ? @$addressSecound->street_address:''}}" placeholder="Please enter address">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="addr2_country">Country</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control" id="addr2_country" name="addr2_country" placeholder="Please select your country">
                                                                <option value="">Please select your country</option>
                                                                <option value="India" {{(@$addressSecound && @$addressSecound->country == 'India')? 'selected':''}}>India</option>
                                                                <option value="Pakistan" {{(@$addressSecound && @$addressSecound->country == 'Pakistan')? 'selected':''}}>Pakistan</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="addr2_state">State </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control" id="addr2_state" name="addr2_state" placeholder="Please select state">
                                                                <option value="">Please select state</option>
                                                                <option value="up" {{(@$addressSecound && @$addressSecound->state == 'up')? 'selected':''}}>UP</option>
                                                                <option value="bihar" {{(@$addressSecound && @$addressSecound->state == 'bihar')? 'selected':''}}>Bihar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="addr2_city">City </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="addr2_city" name="addr2_city" value="{{(@$addressSecound && @$addressSecound->city)?  @$addressSecound->city:''}}" placeholder="Please enter your city">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="addr2_postal_code">Postal Code </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="addr2_postal_code" name="addr2_postal_code" value="{{ (@$addressSecound && @$addressSecound->postal_code)? @$addressSecound->postal_code:''}}" placeholder="Please enter your postal code">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="default_address"> Default Address</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="checkbox" id="default_address" name="default_address"/>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div> --}}
                                    <!-- end step-3 -->
                                    <!-- begin step-4 -->
                                    {{-- <div id="step-4">
                                        
                                        <fieldset>
                                           
                                            <div>
                                               
                                                <div class="row">
                                                    <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You team info, so that we can easily reach you</legend> -->
                                                   
                                                    
                                                    <div id="teamWrapper">
                                                       <?php
                                                       $teams = get_teams_by_customer_id(@$customerProfile->cust_id); 
                                                       foreach($teams as $team)
                                                       {
                                                       ?>
                                                       
                                                            <div class="col-lg-3 col-xl-3">
                                                                      <label class=" text-lg-right col-form-label">Name</label>
                                                            <input type="text" name="team_name[]" value="{{@$team->team_name}}" placeholder="Please enter name"/>
                                                            </div>
                                                    
                                                      
                                                           
                                                            <div class="col-lg-3 col-xl-3">
                                                                 <label class="text-lg-right col-form-label">Mobile number</label>
                                                            <input type="text" name="team_mobile[]" value="{{@$team->team_mobile}}" placeholder="Please enter mobile number"/>
                                                            </div>
                                                       
                                                        <div class="form-group row m-b-10">
                                                            <label class="col-lg-3 text-lg-right col-form-label">Email id</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                                <input type="text" name="team_email[]" value="{{@$team->team_email}}" placeholder="Please enter email id"/>
                                                            </div>
                                                        </div>

                                                    <?php
                                                       }
                                                    ?>

                                                        <button type="button" id="AddMoreTeam" class="btn btn-primary pull-right">
                                                            Add Team
                                                        </button>

                                                    </div>
                                                    
                                                    
                                                    
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div> --}}
                                    <!-- end step-4 -->
                                    <!-- begin step-5 -->
                                    <div id="step-5">
                                        
                                        <fieldset>
                                           
                                            <div>
                                               
                                                <div class="row">
                                                    <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You team info, so that we can easily reach you</legend> -->
                                                    <?php
                                                    $default_certificate = asset('/'.ITEM_IMG_PATH.'/default_img.jpg');
                                                    
                                                ?>https://dev.bartan.com/assets/img/user/user-4.jpg
                                                    
                                                   
                                                        
                                                        <div class="col-lg-3 col-xl-3">
                                                            <label class="text-lg-right col-form-label">GST Certificate <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="gst_certificate" id="gst_certificate"  class="docsValidation form-control form-br" placeholder="Please upload GST certificate"/>
                                                            <input type="hidden" name="gst_certificate_old"  id="gst_certificate_old" value="{{@$customerProfile->gst_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->gst_certificate)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                    </div>
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Shop establishment license<span class="required-star">(png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="shop_establishment_license" class="docsValidation form-control form-br" placeholder="Please upload shop establishment license"/>
                                                            <input type="hidden" name="shop_establishment_license_old"  value="{{@$customerProfile->shop_establishment_license}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->shop_establishment_license)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a> 
                                                            <?php }?>
                                                       
                                                    </div>
                                                    
	
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Shop establishment license <span class="required-star">(png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="shop_establishment_license"  placeholder="Please upload shop establishment license"/>
                                                        </div>
                                                    </div> --}}
                                                
                                                  
                                                        <!-- <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">MSME Registration/Udyog Adhaar <span class="required-star">* (Max. Size 5MB)</span></label>
                                                            <input type="file" name="msme_udyog_adhar" class="docsValidation form-control form-br" placeholder="Please upload MSME Registration/Udyog Adhaar"/>
                                                            <input type="hidden" name="msme_udyog_adhar_old"  value="{{@$customerProfile->msme_udyog_adhar}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->msme_udyog_adhar)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div> -->
                                                   
                                                  
                                                        
                                                        <!-- <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">FSSAI certificate <span class="required-star">* (Max. Size 5MB)</span></label>
                                                            <input type="file" name="FSSAI_certificate"  class="docsValidation form-control form-br" placeholder="Please upload FSSAI certificate"/>
                                                            <input type="hidden" name="FSSAI_certificate_old"  value="{{@$customerProfile->FSSAI_certificate}}"/>
                                                            
                                                            <?php //if(!empty(@$customerProfile->FSSAI_certificate)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php //}?>
                                                        </div> -->
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Trade certificate <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="Trade_certificate"  class="docsValidation form-control form-br" placeholder="Please upload Trade certificate"/>
                                                            <input type="hidden" name="Trade_certificate_old"  value="{{@$customerProfile->Trade_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->Trade_certificate)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>


                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">PAN Copy <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="FSSAI_certificate"  id="FSSAI_certificate" class="docsValidation form-control form-br" placeholder="Please upload FSSAI certificate"/>
                                                            <input type="hidden" name="FSSAI_certificate_old" id="FSSAI_certificate_old" value="{{@$customerProfile->FSSAI_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->FSSAI_certificate)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Driving License <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="driving_license" id="driving_license" class="docsValidation form-control form-br" placeholder="Please upload driving license"/>
                                                            <input type="hidden" name="driving_license_old" id="driving_license_old" value="{{@$customerProfile->driving_license}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->driving_license)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->driving_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->driving_license) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->driving_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->driving_license) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Cancelled Bank Cheque <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="cancel_bank_cheque" id="cancel_bank_cheque" class="docsValidation form-control form-br" placeholder="Please upload cancel bank cheque"/>
                                                            <input type="hidden" name="cancel_bank_cheque_old" id="cancel_bank_cheque_old" value="{{@$customerProfile->cancel_bank_cheque}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->cancel_bank_cheque)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>

                                                        
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Dealer Photo <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="dealer_photo"  class="docsValidation form-control form-br" placeholder="Please upload dealer photo"/>
                                                            <input type="hidden" name="dealer_photo_old"  value="{{@$customerProfile->dealer_photo}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->dealer_photo)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Other document <span class="required-star">* (png,jpg,jpeg,pdf,Max. Size 5MB)</span></label>
                                                            <input type="file" name="other_document"  class="docsValidation form-control form-br" placeholder="Please upload other document"/>
                                                            <input type="hidden" name="other_document_old"  value="{{@$customerProfile->other_document}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->other_document)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>
                                                  
     
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div>
                                    <!-- end step-5 -->
                                    <!-- begin step-4 -->
                                    {{-- <div id="step-4">
                                        
                                        <fieldset>
                                           
                                            <div class="row">
                                               
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You address info, so that we can easily reach you</legend>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Company name</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="default_company_name" placeholder="Please enter company name" class="form-control" />
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">phone <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="default_phone" placeholder="Please enter phone number" class="form-control" />
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Street Address <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="street_address" name="default_street_address" placeholder="Please enter your street address" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="country">Country <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control" id="country" name="default_country" placeholder="Please select your country" data-parsley-required="true">
                                                                <option value="">Please select your country</option>
                                                                <option value="India">India</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="state">State <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control" id="state" name="default_state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <option value="up">UP</option>
                                                                <option value="bihar">Bihar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="city">City <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="city" name="default_city" placeholder="Please enter your city" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="postal_code">Postal Code <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="postal_code" name="default_postal_code" placeholder="Please enter your postal code" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div> --}}
                                    <!-- end step-4 -->
                                    <!-- begin step-5-->
                                    {{-- <div id="step-5">
                                        <!-- begin fieldset -->
                                        <fieldset>
                                            <!-- begin row -->
                                            <div class="row">
                                                <!-- begin col-8 -->
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Select your login username and password</legend>
                                                    <!-- begin form-group row -->
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Username</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="username" placeholder="johnsmithy" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <!-- end form-group row -->
                                                    <!-- begin form-group row -->
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Pasword</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="password" name="password" placeholder="Your password" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <!-- end form-group row -->
                                                    <!-- begin form-group row -->
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Confirm Pasword</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="password" name="password2" placeholder="Confirmed password" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <!-- end form-group row -->
                                                </div>
                                                <!-- end col-8 -->
                                            </div>
                                            <!-- end row -->
                                        </fieldset>
                                        <!-- end fieldset -->
                                    </div> --}}
                                    <!-- end step-5 -->
                                    <!-- begin step-6 -->
                                    <div id="step-6">
                                        <div class="jumbotron m-b-0 text-center">
                                            <h2> Save your profile for being a member of Bartan Family </h2>
                                            <p class="lead mb-4">Your profile will be verify by our team and update you with rates.</p>
                                            {{-- <p><a href="javascript:;" class="btn btn-primary btn-lg">Proceed to User Profile</a></p> --}}
                                            <p><input type="submit" id="saveProfilBtn" class="btn btn-success btn-lg" value="Proceed to Save Profile"></p>
                                        </div>
                                    </div>
                                    <!-- end step-6 -->
                                </div>
                                <!-- end wizard-content -->
                            </div>
                            <!-- end wizard -->
                        </form>
                        <!-- end wizard-form -->
                   
                    <!-- end #content -->
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

    {{-- </div> --}}
	</div>
<!-- end row -->
{{-- </div> --}}
<!-- end #content -->

<?php } else if($customerProfile->status == 1) { ?>
    
    {{-- Start After approve customer --}}
    
    <link href="{{ BACKEND.'plugins/countdown/jquery.countdown.css'}}" rel="stylesheet" />
       <!-- begin #page-container -->
	<div id="page-container" class="page-container">
        
        <!-- begin coming-soon -->
          <div class="coming-soon">
              <!-- begin coming-soon-header -->
              <div class="coming-soon-header">
                  
                  <div class="bg-cover"></div>
                  <div class="brand">
                     
                    
                      <?php
                        if($customerProfile->deleted_at == 0){
                      ?>
                        <span class="logo fa-time"><i class="fa fa fa-times"></i></span> 
                            <p>Please contact to Subiksh team, Your account is deactivated.</p> 

                        <?php } else if($customerProfile->deleted_at == 1 && @Auth::user()->profile == 1) {?>

                             <span class="logo check-circle"><i class="fa fa-check-circle"></i></span> 

                          <p class="admin-wp mb-4"> <b>Congratulations</b> <br>Your profile has approved, enjoy shopping with us!</p>

                        <?php }else {?>
                            
                            
                           
                                <span class="logo mb-3"><img src="{{asset('assets/img/logo/logo.png')}}" alt=""></span><p class="admin-wp mb-4"> <b>Welcome</b> <br>
                                Please wait for a moment, <br> your KYC is pending for approval from Subiksh team.</p>
                              
                            
                           <?php }?>
                        
                  </div>
                  <div class="desc">
                                <a href="{{url('/')}}" class="btn btn-success btn-lg">Trial Order</a>
                                {{-- You are register successfully, Please wait admin approvel. --}}
                            </div>
                  {{-- <div class="timer">
                      <div id="timer"></div>
                  </div> --}}
              </div>
              <!-- end coming-soon-header -->
              <!-- begin coming-soon-content -->
              
              <!-- end coming-soon-content -->
          </div>
          <!-- end coming-soon -->
          
          
          
          <!-- begin scroll to top btn -->
          <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
          <!-- end scroll to top btn -->
      </div>
      <!-- end page container -->
          
    {{-- Start After approve customer --}}



<?php }else{ ?>

    {{-- Start After approve customer --}}
    <link href="{{ BACKEND.'plugins/countdown/jquery.countdown.css'}}" rel="stylesheet" />
       <!-- begin #page-container -->
	<div id="page-container" class="page-container">
        <!-- begin coming-soon -->
          <div class="coming-soon">
              <!-- begin coming-soon-header -->
              <div class="coming-soon-header">
                  <div class="bg-cover"></div>
                  <div class="brand">
                      <span class="logo mb-3"><img src="{{asset('assets/img/logo/logo.png')}}" alt=""></span><p class="admin-wp mb-4"> <b>Welcome</b> <br>
                    Please wait for a moment, <br> your KYC is pending for approval from our team.</p>
                    </div>
                  <div class="desc">
                    <a href="{{url('/')}}" class="btn btn-success btn-lg">Continue Buying</a>
                      {{-- You are register successfully, Please wait admin approvel. --}}
                  </div>
                  <div class="timer">
                      <div id="timer"></div>
                  </div>
              </div>
              <!-- end coming-soon-header -->
              <!-- begin coming-soon-content -->
              
              <!-- end coming-soon-content -->
          </div>
          <!-- end coming-soon -->
          
          
          
          <!-- begin scroll to top btn -->
          <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
          <!-- end scroll to top btn -->
      </div>
      <!-- end page container -->
          
    {{-- Start After approve customer --}}

<?php } }else{?>
    <div id="page-container" class="page-container">
        <div id="content" class="content">
    
    <!-- begin row -->
      <div class="invoice">
        <!-- begin coming-soon -->
        
              <div class="brand">
    <h1 style="color:#ed636c; text-align: center;">Welcome to Admin Panel </h1>
    </div>
    </div>
    </div>
    </div>



<?php } } ?>




