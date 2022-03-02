<!-- begin #content -->
<div id="content" class="content">
   
    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Customer</h4>
                    <div class="panel-heading-btn">
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 -->
                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                   
                        <!-- begin breadcrumb -->
                        {{-- <ol class="breadcrumb float-xl-right">
                            <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol> --}}
                        <!-- end breadcrumb -->
                        <!-- begin page-header -->
                        
                    <h1 class="page-header form-layout">Customer <small>{{($customerProfile->status == 0)? 'Pending':(($customerProfile->status == 2)? 'Rejected':(($customerProfile->status == 3)? 'Updated':'Approve'))}}</small></h1>
                        <!-- end page-header -->
                        <!-- begin wizard-form -->
                       
                    <form action="{{route('saveCustomerApproval')}}" method="POST" id="saveCustomerApproval" class="form-control-with-bg form-layout saveCustomerProfileDetails">
                            @csrf
                        <input type="hidden" name="customer_id" value="{{$customerProfile->id}}"/>
                        <input type="hidden" name="customer_id" value="{{$user->id}}"/>
                        <input type="hidden" name="c_id" value="{{@$customerProfile->cust_id}}"/>
                        <input type="hidden" name="address_id" value="{{@$customerProfile->address_id}}"/>
                            <!-- begin wizard -->
                            <div id="wizard">
                                <!-- begin wizard-step -->
                                <ul>
                                    <li>
                                        <a href="#step-1">
                                            <span class="number">1</span> 
                                            <span class="info">
                                                Personal Info
                                                <small>Name, DOB and about yourself</small>
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
                                                <small>Upload your documents</small>
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
                                                <small>Complete Registration</small>
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
                                           
                                            <div>
                                               
                                                <div class="row">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Personal info about yourself</legend>
                                                   
                                                 
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">First Name <span class="required-star">* </span></label>
                                                        <input class="form-control form-br" type="text" id="cutomer_fname" name="cutomer_fname" value="{{@$customerProfile->cutomer_fname}}" placeholder="Please enter first name" data-parsley-required="true">
                                                        </div>
                                                  
                                                   
                                                     
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">Last Name <span class="required-star">* </span></label>
                                                            <input class="form-control" type="text" id="cutomer_lname" name="cutomer_lname" value="{{@$customerProfile->cutomer_lname}}" placeholder="Please enter last name" data-parsley-required="true">
                                                        </div>
                                                    
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                                  <label class="ext-lg-right col-form-label">Mobile Number <span class="required-star">* </span></label>
                                                        <input class="form-control form-br" type="text" id="phone" name="mobile" value="{{$user->mobile}}" {{($user->mobile)? 'readonly':''}} placeholder="Please enter phone number" data-parsley-required="true">
                                                        </div>
                                                  
                                                    
                                                  
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                                  <label class="text-lg-right col-form-label">Email Address <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="email" id="email" name="email" value="{{$user->email}}" {{($user->email)? 'readonly':''}} placeholder="Please enter your email" data-parsley-required="true">
                                                        </div>
                                                 
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Alternative Phone number</label>
                                                            <input class="form-control form-br" type="number" id="alternate_phone" name="alternate_phone" value="{{$user->alternate_phone}}"  placeholder="Please enter your alternate phone number" data-parsley-required="true">
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
                                                        <label class="col-lg-3 text-lg-right col-form-label">Date of Birth</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="datepicker-autoClose" name="dob" value="{{@$customerProfile->dob}}" placeholder="Please enter date of birth">
                                                        </div>
                                                    </div> --}}
                                                   
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
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="customer_type">Customer Type</label>
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
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Your Business info, so that you can easily attach we</legend>
                                                   
                                                    
                                                     
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">Store name <span class="required-star">* </span></label>
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
                                                               <label class="text-lg-right col-form-label">Address <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="business_street_address" name="business_street_address" value="{{@$customerProfile->business_street_address}}" placeholder="Please enter address" data-parsley-required="true">
                                                        </div>
                                                  
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">Country <span class="required-star">* </span></label>
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
                                                                 <label class="text-lg-right col-form-label" for="business_state">State<span class="required-star">* </span></label>
                                                            <select class="form-control form-br state" id="state" name="business_state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <?php 
                                                                $state = get_stateNameByStateId(@$customerProfile->business_state);
                                                                $stateDefaultIndia = DB::table('states')->where('country_id', 101)->get();
                                                                foreach($stateDefaultIndia as $stateDef){ 
                                                            ?>
                                                                <option value="{{$stateDef->id}}" {{($stateDef->id == @$customerProfile->business_state) ? 'selected' : ''}}>{{ $stateDef->name }}</option>
                                                                <!-- <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option> -->
                                                                
                                                            <?php }?>
                                                                
                                                           
                                                                <!-- <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option> -->
                                                                
                                                            </select>
                                                        </div>
                                                   
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label" for="business_city">City <span class="required-star">* </span></label>
                                                            <select class="form-control form-br city" id="city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select city</option>
                                                                <?php 
                                                                    $city = get_cityNameByCityId(@$customerProfile->business_city);
                                                                ?>
                                                                    <option value="{{@$customerProfile->business_city}}" selected>{{@$city->name}}</option>
                                                                
                                                            </select>
                                                        </div>
                                                 
                                                    
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div>
                                                  
                                                 
                                                      
                                                        <!-- <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label" for="business_gst_number"> GSTIN <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="business_gst_number" name="business_gst_number" value="{{ @$customerProfile->business_gst_number }}" placeholder="Please enter your GSTIN">
                                                        </div> -->

                                                        <!-- <div class="row"> -->
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label" for="document_option">Statutory Document <span class="required-star">* </span></label>
                                                             
                                                             <input class="form-control form-br" type="hidden" name="checkNum" id="checkNum">
                                                            <select class="form-control form-br" id="document_option" name="document_option" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select Document</option> 
                                                                <option value="panNumber">PAN</option>
                                                                <option value="gstNumber">GST</option>
                                                                <option value="dlNumber">Driving License</option>
                                                                <option value="cancelCheck">Cancelled Cheque</option>  
                                                            </select>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-lg-3 col-xl-3" id="panNumber" style="display:{{(@$customerProfile->pan_number)? 'block':'none'}}">

                                                            <label class="text-lg-right col-form-label removeField"> PAN <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="pan_number" id="pan_number" value="{{ @$customerProfile->pan_number }}" placeholder="Please enter your PAN number">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="gstNumber" style="display:{{(@$customerProfile->business_gst_number)? 'block':'none'}}">

                                                            <label class="text-lg-right col-form-label removeField"> GSTIN <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="business_gst_number" id="business_gst_number" value="{{ @$customerProfile->business_gst_number }}" placeholder="Please enter your GSTIN">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="dlNumber" style="display:{{(@$customerProfile->dl_number)? 'block':'none'}}">

                                                            <label class="text-lg-right col-form-label removeField"> Driving License <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="dl_number" id="dl_number" value="{{ @$customerProfile->dl_number }}" placeholder="Please enter your Driving License Number">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3" id="cancelCheck" style="display:{{(@$customerProfile->cancel_check)? 'block':'none'}}">

                                                            <label class="text-lg-right col-form-label removeField"> Cancel Check <span class="required-star"><i class="fa fa-times" aria-hidden="true"></i></span></label>
                                                            <input class="form-control form-br" type="text" name="cancel_check"  id="cancel_check" value="{{ @$customerProfile->cancel_check }}" placeholder="Please enter your Cancel Check Number">
                                                        </div>
                                                 
                                                        <div class="col-lg-3 col-xl-3">
                                                        <label class="text-lg-right col-form-label">Payment Option <span class="required-star">* </span></label>
                                                            
                                                            <select class="form-control" name="payment_option" id="payment_option">
                                                                <option value="">Select Payment Option</option>
                                                                <option value="Online payment" {{(trim(@$customerProfile->payment_option ==="Online payment"))? 'selected':''}}>Online payment</option>
                                                                <option value="Cash on Delivery" {{(trim(@$customerProfile->payment_option ==="Cash on Delivery"))? 'selected':''}}>Cash on Delivery</option>
                                                                <option value="On Credit" {{(trim(@$customerProfile->payment_option ==="On Credit"))? 'selected':''}}>On Credit</option>
                                                            </select>
                                                            
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Shop number </label>
                                                            <input class="form-control form-br" type="text" id="shop_number" name="shop_number"  value="{{@$customerProfile->shop_number}}" placeholder="Please enter your shop number">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Street </label>
                                                            <input class="form-control form-br" type="text" id="street" name="street"  value="{{@$customerProfile->street}}" placeholder="Please enter your street">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Dealer Target </label>
                                                            <input class="form-control form-br" type="text" id="dealer_target" name="dealer_target"  value="{{@$customerProfile->dealer_target}}" placeholder="Please enter dealer target">
                                                        </div>


                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Customer current location </label>
                                                            <textarea class="form-control form-br" id="geo_location" name="geo_location" placeholder="Please enter geo location">{{@$customerProfile->geo_location}}</textarea>
                                                        </div>
                                                   
                                                    

                                                        
                                                   

                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Delivery charge (In %) </label>
                                                            <input class="form-control form-br" type="text" id="delivery_charge" name="delivery_charge"  value="{{@$customerProfile->delivery_charge}}" placeholder="Please enter delivery charge">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Packing charge (In %)</label>
                                                            <input class="form-control form-br" type="text" id="packing_charge" name="packing_charge"  value="{{@$customerProfile->packing_charge}}" placeholder="Please enter packing charge">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Delivery discount (In %)</label>
                                                            <input class="form-control form-br" type="text" id="delivery_discount" name="delivery_discount"  value="{{@$customerProfile->delivery_discount}}" placeholder="Please enter delivery discount">
                                                        </div>
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Packing discount (In %)</label>
                                                            <input class="form-control form-br" type="text" id="packing_discount" name="packing_discount"  value="{{@$customerProfile->packing_discount}}" placeholder="Please enter packing discount">
                                                        </div>

                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Brand</label>
                                                            <select class="multiple-select2 form-control" name="customer_brand[]" multiple="multiple" autocomplete="off">
                                                                <option value="">Select Brand</option>
                                                                
                                                                <?php 
                                                                //$brands = getBarnds();
                                                                $brands = DB::table('tbl_brands')->get();
                                                                //pr($brands);
                                                                foreach ($brands as $brand) {
                                                                    @$customerBrands = DB::table('customer_wise_brands')->where('customer_id', @$customerProfile->cust_id)
                                                                    ->where('user_id', $user->id)
                                                                    ->where('brand_id', $brand->id)
                                                                    ->first();
                                                                    if($customerBrands){
                                                                        @$selected = 'selected';
                                                                    }else{
                                                                        @$selected = '';
                                                                    }
                                                                ?>
                                                                
                                                                <option value="{{$brand->id}}" {{@$selected}}>{{$brand->name}}</option>
                                                                <?php }?>
                                                            
                                                                
                                                                
                                                                
                                                            </select>
                                                        </div> 
                                                   
                                                    
                                                <!-- </div> -->
                                                   

                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="parent_code">Do you have parent organization </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="checkbox" id="parent_code"  {{(@$customerProfile->parent_code)? 'checked':'' }} name="parent_code" readonly />
                                                        
                                                        <style>
                                                            input[type="checkbox"][readonly] 
                                                            {
                                                                pointer-events: none;
                                                            }
                                                        </style>
                                                        </div>
                                                    </div>  --}}
                                                    
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Email Address <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="email" id="email" name="email" value="{{Auth::user()->email}}" {{(Auth::user()->email)? 'readonly':''}} placeholder="Please enter your email" data-parsley-required="true">
                                                        </div>
                                                    </div> --}}
                                                    
                                                </div>
                                                
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
                                                        <input type="text" name="company_name" value="{{@$customerProfile->company_name}}" placeholder="Please enter company name" class="form-control form-br" />
                                                        </div>
                                                   
                                                   
                                                  
                                                        <div class="col-lg-3 col-xl-3">
                                                                  <label class="text-lg-right col-form-label">First name <span class="required-star">* </span></label>
                                                        <input type="text" name="f_name" value="{{@$customerProfile->f_name}}" placeholder="Please enter first name" class="form-control form-br"  data-parsley-required="true"/>
                                                        </div>
                                                   
                                              
                                                      
                                                        <div class="col-lg-3 col-xl-3">
                                                              <label class="text-lg-right col-form-label">Last name <span class="required-star">* </span></label>
                                                        <input type="text" name="l_name" value="{{@$customerProfile->l_name}}" placeholder="Please enter last name" class="form-control form-br"  data-parsley-required="true"/>
                                                        </div>
                                                    
                                                    
                                                     
                                                        <div class="col-lg-3 col-xl-3">
                                                               <label class="text-lg-right col-form-label">phone <span class="required-star">* </span></label>
                                                            <input type="text" name="phone" placeholder="Please enter phone number" class="form-control form-br" />
                                                        </div>
                                               
                                                       
                                                        <div class="col-lg-3 col-xl-3">
                                                             <label class="text-lg-right col-form-label">Address <span class="required-star">* </span></label>
                                                            <input class="form-control form-br" type="text" id="street_address" name="street_address" value="{{@$customerProfile->street_address}}" placeholder="Please enter address" data-parsley-required="true">
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
                                                                    <option value="{{@$customerProfile->state}}" selected>{{$state->name}}</option>
                                                                
                                                                   
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
                                                                    <option value="{{@$customerProfile->city}}" selected>{{$city->name}}</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="postal_code">Postal Code <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="postal_code" name="postal_code" value="{{ @$customerProfile->postal_code }}" placeholder="Please enter your postal code" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="gst_number"> GSTIN <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="gst_number" name="gst_number" value="{{ @$customerProfile->gst_number }}" placeholder="Please enter your GSTIN">
                                                        </div>
                                                    </div>

                                                    <h2>Address 2</h2>
                                                    {{-- 
                                                    <?php
                                                    $addressSecound = DB::table('tbl_addresses')->where('customer_id', @$customerProfile->cust_id)
                                                                ->where('address_user_id', $user->id)
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
                                                    </div> -
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
                                    {{-- <div id="step-4">
                                        
                                        <fieldset>
                                           
                                            <div class="row">
                                               
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You team info, so that we can easily reach you</legend>
                                                   
                                                    
                                                    <div id="teamWrapper">
                                                       <?php
                                                       $teams = get_teams_by_customer_id(@$customerProfile->cust_id); 
                                                       foreach($teams as $team)
                                                       {
                                                       ?>
                                                        <div class="form-group row m-b-10">
                                                            <label class="col-lg-3 text-lg-right col-form-label">Name</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="team_name[]" value="{{@$team->team_name}}" placeholder="Please enter name"/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row m-b-10">
                                                            <label class="col-lg-3 text-lg-right col-form-label">Mobile number</label>
                                                            <div class="col-lg-9 col-xl-6">
                                                            <input type="text" name="team_mobile[]" value="{{@$team->team_mobile}}" placeholder="Please enter mobile number"/>
                                                            </div>
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

                                                        

                                                    </div>
                                                    
                                                    
                                                    
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div> --}}
                                    <div id="step-5">
                                        
                                        <fieldset>
                                           
    <div class="row">
        <h1 class="page-header">Statutory Document <br><small class="text-danger"> <i><strong>(Any two document from
                        first four options are mandatory)</strong></i></small></h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Sr No.</th>

                    <th class="text-nowrap">Document Type</th>
                    <th class="text-nowrap">Document Number</th>
                    <th width="20%" class="text-nowrap">Upload Image <span class="tooltip-toggle"
                            aria-label="(png,jpg,jpeg,pdf,Max. Size 5MB)" tabindex="0">
                            <svg viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
                                <g fill="#fff" fill-rule="evenodd">
                                    <path
                                        d="M13.5 27C20.956 27 27 20.956 27 13.5S20.956 0 13.5 0 0 6.044 0 13.5 6.044 27 13.5 27zm0-2C7.15 25 2 19.85 2 13.5S7.15 2 13.5 2 25 7.15 25 13.5 19.85 25 13.5 25z" />
                                    <path
                                        d="M12.05 7.64c0-.228.04-.423.12-.585.077-.163.185-.295.32-.397.138-.102.298-.177.48-.227.184-.048.383-.073.598-.073.203 0 .398.025.584.074.186.05.35.126.488.228.14.102.252.234.336.397.084.162.127.357.127.584 0 .22-.043.412-.127.574-.084.163-.196.297-.336.4-.14.106-.302.185-.488.237-.186.053-.38.08-.584.08-.215 0-.414-.027-.597-.08-.182-.05-.342-.13-.48-.235-.135-.104-.243-.238-.32-.4-.08-.163-.12-.355-.12-.576zm-1.02 11.517c.134 0 .275-.013.424-.04.148-.025.284-.08.41-.16.124-.082.23-.198.313-.35.085-.15.127-.354.127-.61v-5.423c0-.238-.042-.43-.127-.57-.084-.144-.19-.254-.318-.332-.13-.08-.267-.13-.415-.153-.148-.024-.286-.036-.414-.036h-.21v-.95h4.195v7.463c0 .256.043.46.127.61.084.152.19.268.314.35.125.08.263.135.414.16.15.027.29.04.418.04h.21v.95H10.82v-.95h.21z" />
                                </g>
                            </svg>
                        </span></th>
                    <th class="text-nowrap">View Image</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $default_certificate = asset('/'.ITEM_IMG_PATH.'/user-4.jpg');
                $default_certificate_pdf = asset('/'.ITEM_IMG_PATH.'/default_pdf.png');
                
            ?>
                <tr class="odd gradeX">
                    <td>1</td>
                    <td><strong>GST</strong></td>
                    <td><input type="text" name="business_gst_number" id="business_gst_number" class="form-control">
                    </td>

                    <!-- <td><input type="file" class="form-control" data-toggle="tooltip" data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                <td width="1%" class="with-img"><div class="card" style="width: 3rem;">
                <img src="https://dev.bartan.com/assets/img/user/user-4.jpg" class="img-rounded height-30" /></div></td> -->
                    <td><input type="file" name="gst_certificate" id="gst_certificate"
                            class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                    
                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                            <input type="hidden" name="gst_certificate_old" id="gst_certificate_old"
                                value="{{@$customerProfile->gst_certificate}}" />

                            <?php 
                           
                            if(!empty(@$customerProfile->gst_certificate)){
                                $explodDocGst = explode(".", @$customerProfile->gst_certificate);
                                $gstDocExten = end($explodDocGst);
                                if($gstDocExten == "pdf"){

                                ?>
                                    <a target="_blank" href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}"
                                        class="img-rounded height-30" />

                                    </a>
                                    <?php }else{?>

                                        <a target="_blank" href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">

                                        <img src="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}"
                                            class="img-rounded height-30" />

                                        </a>
                            <?php }}else{?>
                               

                                    <img src="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                       
                                <?php }?>
                        </div>
                    </td>
                </tr>


                <tr class="even gradeC">
                    <td>2</td>
                    <td><strong>PAN</strong></td>
                    <td><input type="text" name="pan_number" id="pan_number" class="form-control"></td>

                    <td>
                        <input type="file" name="FSSAI_certificate"  id="FSSAI_certificate" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                    </td>
                    <input type="hidden" name="FSSAI_certificate_old" id="FSSAI_certificate_old" value="{{@$customerProfile->FSSAI_certificate}}"/>
                    <td width="1%" class="with-img">

                        <div class="card" style="width: 3rem;">
                        <?php 
                        if(!empty(@$customerProfile->FSSAI_certificate)){
                            
                            $explodDocGst = explode(".", @$customerProfile->FSSAI_certificate);
                            $gstDocExten = end($explodDocGst);
                            if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">

                                <img src="{{$default_certificate_pdf}}"
                                    class="img-rounded height-30" />

                                </a>
                                <?php }else{?>
                            <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}" class="img-rounded height-30" />
                            </a>
                            <?php }}else{?>
                               

                               <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}"
                                   class="img-rounded height-30" />

                                  
                           <?php }?>
                        </div>

                    </td>

                    <!-- <td width="1%" class="with-img">

                        <div class="card" style="width: 3rem;">
                            <img src="https://dev.bartan.com/assets/img/user/user-4.jpg"
                                class="img-rounded height-30" />
                        </div>

                    </td> -->
                    <!-- <input type="file" name="FSSAI_certificate"  id="FSSAI_certificate" class="docsValidation form-control form-br" placeholder="Please upload FSSAI certificate"/> -->
                    
                    
                    
                </tr>
                <tr class="odd gradeX">
                    <td>3</td>
                    <td><strong>Aadhar Card </strong></td>
                    <td><input type="text" name="adhar_number" id="adhar_number" class="form-control"></td>

                    <td>
                        <input type="file" name="adhar_card"  id="adhar_card" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                    </td>
                    <input type="hidden" name="adhar_card_old" id="adhar_card_old" value="{{@$customerProfile->adhar_card}}"/>
                    <td width="1%" class="with-img">

                        <div class="card" style="width: 3rem;">
                        <?php 
                        if(!empty(@$customerProfile->adhar_card)){
                            
                            $explodDocGst = explode(".", @$customerProfile->adhar_card);
                            $gstDocExten = end($explodDocGst);
                            if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank" href="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}">

                                <img src="{{$default_certificate_pdf}}"
                                    class="img-rounded height-30" />

                                </a>
                                <?php }else{?>
                            <a target="_blank" href="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}">
                                <img src="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}" class="img-rounded height-30" />
                            </a>
                            <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" />

                                  
                           <?php }?>
                        </div>
                    </td>
                </tr>
                <tr class="even gradeC">
                    <td>4</td>
                    <td><strong>Cancel Cheque</strong></td>
                    <td><input type="text" name="cancel_check" id="cancel_check" class="form-control"></td>

                    <td>
                        <input type="file" name="cancel_bank_cheque" id="cancel_bank_cheque" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="cancel_bank_cheque_old" id="cancel_bank_cheque_old" value="{{@$customerProfile->cancel_bank_cheque}}"/>
                    </td>

                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                            <!-- <img src="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}"
                                class="img-rounded height-30" /> -->
                        

                    <!-- <input type="file" name="cancel_bank_cheque" id="cancel_bank_cheque" class="docsValidation form-control form-br" placeholder="Please upload cancel bank cheque"/>
                    <input type="hidden" name="cancel_bank_cheque_old" id="cancel_bank_cheque_old" value="{{@$customerProfile->cancel_bank_cheque}}"/> -->
                    
                    <?php if(!empty(@$customerProfile->cancel_bank_cheque)){
                        $explodDocGst = explode(".", @$customerProfile->cancel_bank_cheque);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                            <a target="_blank" href="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}">

                            <img src="{{$default_certificate_pdf}}"
                                class="img-rounded height-30" />

                            </a>
                            <?php }else{?>

                         <a target="_blank" href="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}">
                            
                            
                            <img src="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}"
                                class="img-rounded height-30" />
                        
                        </a> 
                        
                        <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" alt="doc"/>

                                  
                           <?php }?>
                           </div>
                    </td>
                </tr>
                <tr class="odd gradeX">
                    <td>5</td>
                    <td><strong>Shop Establishment</strong></td>
                    <td><input type="text" name="shop_establishment_number" id="shop_establishment_number"class="form-control"></td>

                    <td><input type="file" name="shop_establishment_license" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                        <input type="hidden" name="shop_establishment_license_old"  value="{{@$customerProfile->shop_establishment_license}}"/>
                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                            <!-- <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}"
                                class="img-rounded height-30" /> -->
                        <?php 
                        if(!empty(@$customerProfile->shop_establishment_license)){
                    $explodDocGst = explode(".", @$customerProfile->shop_establishment_license);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                            <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">

                            <img src="{{$default_certificate_pdf}}"
                                class="img-rounded height-30" />

                            </a>
                            <?php }else{?>

                         <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">
                            
                            
                            <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}"
                                class="img-rounded height-30" />
                        
                        </a> 
                        
                        <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" alt="doc"/>

                                  
                           <?php }?>
                           </div>
                    </td>
                    <!-- <input type="file" name="shop_establishment_license" class="docsValidation form-control form-br" placeholder="Please upload shop establishment license"/>
                    <input type="hidden" name="shop_establishment_license_old"  value="{{@$customerProfile->shop_establishment_license}}"/> -->
                    
                    <?php //if(!empty(@$customerProfile->shop_establishment_license)){?>
                        <!-- <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">
                            <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}" width="80%" height="50%"/>
                        </a>  -->
                    <?php //}?>
                </tr>
                <tr class="even gradeC">
                    <td>6</td>
                    <td><strong>Trade Certificate</strong></td>
                    <td><input type="text" name="Trade_certificate_number" id="Trade_certificate_number" class="form-control"></td>

                    <td><input type="file" name="Trade_certificate" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                            <input type="hidden" name="Trade_certificate_old"  value="{{@$customerProfile->Trade_certificate}}"/>
                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                        <?php 
                        if(!empty(@$customerProfile->Trade_certificate)){
                    $explodDocGst = explode(".", @$customerProfile->Trade_certificate);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                            <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">

                            <img src="{{$default_certificate_pdf}}"
                                class="img-rounded height-30" />

                            </a>
                            <?php }else{?>

                         <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">
                            
                            
                            <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}"
                                class="img-rounded height-30" />
                        
                        </a> 
                        
                        <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" alt="doc"/>

                                  
                           <?php }?>
                           </div>
                    </td>

                    <!-- <input type="file" name="Trade_certificate"  class="docsValidation form-control form-br" placeholder="Please upload Trade certificate"/>
                    <input type="hidden" name="Trade_certificate_old"  value="{{@$customerProfile->Trade_certificate}}"/> -->
                    
                    <?php //if(!empty(@$customerProfile->Trade_certificate)){?>

                        <!-- <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">
                            <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}" width="80%" height="50%"/>
                        </a> -->
                    <?php //}?>
                </tr>

                <tr class="odd gradeX">
                    <td>7</td>
                    <td><strong>Dealer Photo</strong></td>
                    <td><input type="text" class="form-control" disabled=""></td>

                    <td><input type="file" name="dealer_photo" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="dealer_photo_old"  value="{{@$customerProfile->dealer_photo}}"/></td>
                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                        <?php 
                        if(!empty(@$customerProfile->dealer_photo)){
                    $explodDocGst = explode(".", @$customerProfile->dealer_photo);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                            <a target="_blank" href="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}">

                            <img src="{{$default_certificate_pdf}}"
                                class="img-rounded height-30" />

                            </a>
                            <?php }else{?>

                         <a target="_blank" href="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}">
                            
                            
                            <img src="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}"
                                class="img-rounded height-30" />
                        
                        </a> 
                        
                        <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" alt="doc"/>

                                  
                           <?php }?>
                           </div>
                    </td>


                    
                    
                    
                </tr>
                <tr class="even gradeC">
                    <td>8</td>
                    <td><strong>Other Document</strong></td>
                    <td><input type="text" name="other_document_number" id="other_document_number" class="form-control" disabled=""></td>

                    <td><input type="file" name="other_document" id="other_document" class="docsValidation form-control" data-toggle="tooltip" data-placement="top"
                            title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="other_document_old"  value="{{@$customerProfile->other_document}}"/>
                    </td>
                    <td width="1%" class="with-img">
                        <div class="card" style="width: 3rem;">
                        <?php 
                        if(!empty(@$customerProfile->other_document)){
                    $explodDocGst = explode(".", @$customerProfile->other_document);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                            <a target="_blank" href="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}">

                            <img src="{{$default_certificate_pdf}}"
                                class="img-rounded height-30" />

                            </a>
                            <?php }else{?>

                         <a target="_blank" href="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}">
                            
                            
                            <img src="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}"
                                class="img-rounded height-30" />
                        
                        </a> 
                        
                        <?php }}else{?>
                               

                               <img src="{{$default_certificate}}"
                                   class="img-rounded height-30" alt="doc"/>

                                  
                           <?php }?>
                           </div>
                    </td>

                   
                </tr>

            </tbody>
        </table>
    </div>
                        </div>
                                           
                                        </fieldset>
                                       
                                    </div>
                                    <!-- begin step-6 -->
                                    <div id="step-6">
                                        <div class="m-b-0 text-center">
                                            <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Status</legend>
                                            <div class="form-group row m-b-10">
                                                <label class="col-lg-3 text-lg-right col-form-label" for="status">status <span class="required-star">* </span></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <select class="form-control form-br" id="status" name="status" placeholder="Please select state" data-parsley-required="true">
                                                        <option value="">Please select status</option>
                                                        
                                                        <option value="0" {{(@$customerProfile->status == '0')? 'selected':''}}>Pending</option>
                                                        <option value="1" {{(@$customerProfile->status == '1')? 'selected':''}}>Approve</option>
                                                        <option value="2" {{(@$customerProfile->status == '2')? 'selected':''}}>Rejected</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="form-group row m-b-10" id="remarkField" style="display:{{($customerProfile->status == 2) ? '':'none'}}">
                                                <label class="col-lg-3 text-lg-right col-form-label" for="remark">Remark <span class="required-star">* </span></label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input class="form-control" type="textarea" rows="4" cols="50" id="remark" name="remark" value="{{ @$customerProfile->remark }}" placeholder="Please enter remark" data-parsley-required="true">
                                                </div>
                                            </div>
                                            {{-- <p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat commodo porttitor. <br />Vivamus eleifend, arcu in tincidunt semper, lorem odio molestie lacus, sed malesuada est lacus ac ligula. Aliquam bibendum felis id purus ullamcorper, quis luctus leo sollicitudin. </p> --}}
                                            {{-- <p><a href="javascript:;" class="btn btn-primary btn-lg">Proceed to User Profile</a></p> --}}
                                            <p><input type="submit" id="saveProfilBtn" class="btn btn-success btn-lg" value="Proceed"></p>
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

