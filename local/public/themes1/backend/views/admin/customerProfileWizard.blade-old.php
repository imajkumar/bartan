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
            
           
            if(!empty($customerProfile)){
                 $flag = ($profile == 'false' || $customerProfile->status == 2 || $customerProfile->status == 0);
                
            }else{
                $flag = ($profile == 'false' || $customerProfile->status == 2 || $customerProfile->status == 0);
                 
            }
            
        if($flag)
        {

            
            
?>
<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    
    <!-- begin page-header -->
    
    <h1 class="page-header">CUSTOMER <small>Profile</small></h1>

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">PROFILE</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                   
                        <!-- begin breadcrumb -->
                       
                        <!-- end breadcrumb -->
                        <!-- begin page-header -->
                    <h1 class="page-header form-layout">Profile <small>{{(@$customerProfile->status == 0)? 'Pending':((@$customerProfile->status == 2)? 'Rejected,':'')}} {{(@$customerProfile->remark)? 'Remark: '.@$customerProfile->remark:''}}</small></h1>
                        <!-- end page-header -->
                        <!-- begin wizard-form -->
                    <form action="{{route('saveCustomerProfileDetails')}}" method="POST" id="saveCustomerProfileDetails" class="form-control-with-bg form-layout" enctype="multipart/form-data">
                           
                        <input type="hidden" name="customer_id" value="{{Auth::user()->id}}"/>
                        <input type="hidden" name="c_id" value="{{@$customerProfile->cust_id}}"/>
                        <input type="hidden" name="address_id" value="{{@$customerProfile->address_id}}"/>
                        <input type="hidden" name="docs_id" value="{{@$customerProfile->docs_id}}"/>
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
                                    
                                    <li>
                                        <a href="#step-5">
                                            <span class="number">5</span> 
                                            <span class="info">
                                                Document Upload
                                                <small>Upload your documents</small>
                                            </span>
                                        </a>
                                    </li>
                                   
                                    <li>
                                        <a href="#step-6">
                                            <span class="number">6</span> 
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
                                           
                                            <div class="row">
                                               
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Personal info about yourself</legend>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">First Name <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control" type="text" id="cutomer_fname" name="cutomer_fname" value="{{@$customerProfile->cutomer_fname}}" placeholder="Please enter first name" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Last Name <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="cutomer_lname" name="cutomer_lname" value="{{@$customerProfile->cutomer_lname}}" placeholder="Please enter last name" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Mobile Number <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control" type="text" id="phone" name="mobile" value="{{Auth::user()->mobile}}" {{(Auth::user()->mobile)? 'readonly':''}} placeholder="Please enter phone number" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Email Address <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="email" id="email" name="email" value="{{Auth::user()->email}}" {{(Auth::user()->email)? 'readonly':''}} placeholder="Please enter your email" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    
                                                   
                                                </div>
                                                
                                            </div>
                                            
                                        </fieldset>
                                       
                                    </div>
                                    <!-- end step-1 -->
                                    <!-- begin step-2 -->
                                    <div id="step-2">
                                       
                                        <fieldset>
                                            
                                            <div class="row">
                                                
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Your Business info, so that you can easily attach we</legend>
                                                   
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Store name <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control" type="text" id="store_name" name="store_name"  value="{{@$customerProfile->store_name}}" placeholder="Please enter your store name" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                   <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="customer_type">Customer Type</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <select class="form-control" id="customer_type" name="customer_type" placeholder="Please select customer type">
                                                                <option value="">Please select customer type</option>
                                                                <option value="1" {{(@$customerProfile->customer_type == 1)? 'selected':''}}>Dealer</option>
                                                                <option value="2" {{(@$customerProfile->customer_type == 2)? 'selected':''}}>Wholesale</option>
                                                                <option value="3" {{(@$customerProfile->customer_type == 3)? 'selected':''}}>Distibuter</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Address <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="business_street_address" name="business_street_address" value="{{@$customerProfile->business_street_address}}" placeholder="Please enter address" data-parsley-required="true">
                                                        </div>
                                                    </div>

                                                     <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="business_country">Country <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control country" id="business_country" name="business_country" placeholder="Please select country" data-parsley-required="true">
                                                                <option value="">Please select country</option>
                                                                <?php
                                                                        $countryes = getCountry();
                                                                        foreach($countryes as $country){
                                                                    ?>
                                                                                <option value="{{$country->id}}" {{($country->id == @$customerProfile->business_country)? 'selected':''}}>{{$country->name}}</option>
                        
                                                                    <?php } ?>
                                                             
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="business_state">State <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control state" id="business_state" name="business_state" placeholder="Please select state" data-parsley-required="true">
                                                                <option value="">Please select state</option>
                                                                <?php 
                                                                $state = get_stateNameByStateId(@$customerProfile->business_state);
                                                                
                                                            ?>
                                                                <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="business_city">City <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <select class="form-control city" id="business_city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                                                <option value="">Please select city</option>
                                                                <?php 
                                                                    $city = get_cityNameByCityId(@$customerProfile->business_city);
                                                                ?>
                                                                    <option value="{{@$customerProfile->business_city}}" selected>{{@$city->name}}</option>
                                                                
                                                            </select>
                                                            {{-- <input class="form-control" type="text" id="business_city" name="business_city" value="{{ @$customerProfile->business_city }}" placeholder="Please enter city" data-parsley-required="true"> --}}
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="business_postal_code">Postal Code <span class="required-star">* </span></label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="business_gst_number"> GSTIN </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control" type="text" id="business_gst_number" name="business_gst_number" value="{{ @$customerProfile->business_gst_number }}" placeholder="Please enter your GSTIN">
                                                        </div>
                                                    </div>
                                                   {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label" for="parent_code">Do you have parent organization </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control" type="checkbox" id="parent_code" {{(@$customerProfile->parent_code)? 'checked':'' }} value="1" name="parent_code">
                                                        </div>
                                                    </div> --}}
                                                    
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
                                    
                                    <!-- end step-4 -->
                                    <!-- begin step-5 -->
                                    <div id="step-5">
                                        
                                        <fieldset>
                                           
                                            <div class="row">
                                               
                                                <div class="col-xl-8 offset-xl-2">
                                                    <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You team info, so that we can easily reach you</legend>
                                                    <?php
                                                    $default_certificate = asset('/'.ITEM_IMG_PATH.'/default_img.jpg');
                                                    
                                                ?>
                                                    
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">GST Certificate</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="gst_certificate" class="docsValidation" placeholder="Please upload GST certificate"/>
                                                            <input type="hidden" name="gst_certificate_old"  value="{{@$customerProfile->gst_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->gst_certificate)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                    </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Shop establishment license</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="shop_establishment_license" class="docsValidation" placeholder="Please upload shop establishment license"/>
                                                            <input type="hidden" name="shop_establishment_license_old"  value="{{@$customerProfile->shop_establishment_license}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->shop_establishment_license)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a> 
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    
	
                                                    {{-- <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Shop establishment license</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="shop_establishment_license"  placeholder="Please upload shop establishment license"/>
                                                        </div>
                                                    </div> --}}
                                                
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">MSME Registration/Udyog Adhaar</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="msme_udyog_adhar" class="docsValidation" placeholder="Please upload MSME Registration/Udyog Adhaar"/>
                                                            <input type="hidden" name="msme_udyog_adhar_old"  value="{{@$customerProfile->msme_udyog_adhar}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->msme_udyog_adhar)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">FSSAI certificate</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="FSSAI_certificate"  class="docsValidation" placeholder="Please upload FSSAI certificate"/>
                                                            <input type="hidden" name="FSSAI_certificate_old"  value="{{@$customerProfile->FSSAI_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->FSSAI_certificate)){?>
                                                                <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-10">
                                                        <label class="col-lg-3 text-lg-right col-form-label">Trade certificate</label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input type="file" name="Trade_certificate"  class="docsValidation" placeholder="Please upload Trade certificate"/>
                                                            <input type="hidden" name="Trade_certificate_old"  value="{{@$customerProfile->Trade_certificate}}"/>
                                                            
                                                            <?php if(!empty(@$customerProfile->Trade_certificate)){?>

                                                                <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">
                                                                    <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}" width="80%" height="50%"/>
                                                                </a>
                                                            <?php }?>
                                                        </div>
                                                    </div>



                                                    



                                                        
                                                </div>
                                               
                                            </div>
                                           
                                        </fieldset>
                                       
                                    </div>
                                    <!-- end step-5 -->
                                   
                                    <!-- end step-5 -->
                                    <!-- begin step-6 -->
                                    <div id="step-6">
                                        <div class="jumbotron m-b-0 text-center">
                                            <h2 class="display-4">Profile </h2>
                                            <p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat commodo porttitor. <br />Vivamus eleifend, arcu in tincidunt semper, lorem odio molestie lacus, sed malesuada est lacus ac ligula. Aliquam bibendum felis id purus ullamcorper, quis luctus leo sollicitudin. </p>
                                            {{-- <p><a href="javascript:;" class="btn btn-primary btn-lg">Proceed to User Profile</a></p> --}}
                                            <p><input type="submit" id="saveProfilBtn" class="btn btn-primary btn-lg" value="Proceed to Save Profile"></p>
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


<?php }}} ?>