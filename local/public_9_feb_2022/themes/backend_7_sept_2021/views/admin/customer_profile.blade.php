<?php
if(!empty($customer->profile_pic) )
		{
			
			$profil_pic = asset('/'.ITEM_IMG_PATH.'/'.$customer->profile_pic);
		}else{
			
			$profil_pic = BACKEND.'img/user/user-4.jpg';
        }
        $customerProfile = get_customer_and_address_by__user_id(Auth::user()->id);
        $default_certificate = asset('/'.ITEM_IMG_PATH.'/default_img.jpg');
?>
<div id="content" class="content content-full-width">
    <!-- begin profile -->
    <div class="profile">
        <div class="profile-header">
            <!-- BEGIN profile-header-cover -->
            <div class="profile-header-cover"></div>
            <!-- END profile-header-cover -->
            <!-- BEGIN profile-header-content -->
            <div class="profile-header-content">
                <!-- BEGIN profile-header-img -->
                <div class="profile-header-img">
                <img src="{{$profil_pic}}" class="outputPic" alt="">
                </div>
                <!-- END profile-header-img -->
                <!-- BEGIN profile-header-info -->
                <div class="profile-header-info">
                    <h4 class="mt-0 mb-1">{{ucfirst($customer->cutomer_fname)}} {{$customer->cutomer_lname}}</h4>
                    <p class="mb-2">Store name: {{$customerProfile->store_name}}</p>
                <a href="{{route('customerProfile')}}" class="btn btn-xs btn-yellow">Edit Profile</a>
                </div>
                <!-- END profile-header-info -->
            </div>
            <!-- END profile-header-content -->
            <!-- BEGIN profile-header-tab -->
            <ul class="profile-header-tab nav nav-tabs">
                {{-- <li class="nav-item"><a href="#profile-post" class="nav-link" data-toggle="tab">POSTS</a></li> --}}
                <li class="nav-item"><a href="#profile-about" class="nav-link active" data-toggle="tab">ABOUT</a></li>
                <li class="nav-item"><a href="#profile-business" class="nav-link" data-toggle="tab">BUSINESS</a></li>
                {{-- <li class="nav-item"><a href="#profile-address" class="nav-link" data-toggle="tab">ADDRESS</a></li> --}}
                {{-- <li class="nav-item"><a href="#profile-team" class="nav-link" data-toggle="tab">TEAM</a></li> --}}
                <!-- <li class="nav-item"><a href="#profile-photos" class="nav-link" data-toggle="tab">DOCUMENTS</a></li> -->
                {{-- <li class="nav-item"><a href="#profile-videos" class="nav-link" data-toggle="tab">VIDEOS</a></li>
                <li class="nav-item"><a href="#profile-friends" class="nav-link active" data-toggle="tab">FRIENDS</a></li> --}}
            </ul>
            <!-- END profile-header-tab -->
        </div>
    </div>
    <!-- end profile -->
    <!-- begin profile-content -->
<form action="{{route('updateCustomerProfileDetails')}}" method="post" id="updateCustomerProfileDetails">
    
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
    <input type="hidden" name="c_id" value="{{@$customerProfile->cust_id}}"/>
    <input type="hidden" name="address_id" value="{{@$customerProfile->address_id}}"/>
    <input type="hidden" name="docs_id" value="{{@$customerProfile->docs_id}}"/>
    <div class="profile-content">
        <!-- begin tab-content -->
        <div class="tab-content p-0">
            
            <!-- begin #profile-about tab -->
            <div class="tab-pane fade active show" id="profile-about">
                <!-- begin table -->
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        
                        <tbody>

                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">First Name<span class="required-star">* </span>: </td>
                                <td>
                                    {{-- {{$customerProfile->cutomer_fname}} --}}
                                    <input class="form-control" type="text" id="cutomer_fname" name="cutomer_fname" value="{{@$customerProfile->cutomer_fname}}" placeholder="Please enter first name" data-parsley-required="true">
                                </td>
                            </tr>
                            <tr>
                                <td class="field">Last Name<span class="required-star">* </span>: </td>
                                <td>
                                    {{-- {{$customerProfile->cutomer_lname}} --}}
                                    <input class="form-control" type="text" id="cutomer_lname" name="cutomer_lname" value="{{@$customerProfile->cutomer_lname}}" placeholder="Please enter last name" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Mobile Number<span class="required-star">* </span>: </td>
                                <?php 
                                    ///$user = DB::table('users')->where('id', $customerProfile->user_id)->first();
                                    $user = get_user_by_user_id($customerProfile->user_id);
                                ?>
                                <td>
                                    {{-- {{$user['mobile']}} --}}
                                    {{-- <input class="form-control" type="text" id="phone" name="mobile" value="{{Auth::user()->mobile}}" {{(Auth::user()->mobile)? 'readonly':''}} placeholder="Please enter phone number" data-parsley-required="true"> --}}
                                    <input class="form-control" type="text" id="phone" name="mobile" value="{{Auth::user()->mobile}}" placeholder="Please enter phone number" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Email Address<span class="required-star">* </span>: </td>
                                
                                <td>
                                    {{-- {{$user['email']}} --}}
                                    <input class="form-control" type="email" id="email" name="email" value="{{Auth::user()->email}}"  placeholder="Please enter your email" data-parsley-required="true">
                                    {{-- <input class="form-control" type="email" id="email" name="email" value="{{Auth::user()->email}}" {{(Auth::user()->email)? 'readonly':''}} placeholder="Please enter your email" data-parsley-required="true"> --}}

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Date of registration: </td>
                                
                                <td>
                                    
                                    <span class="form-control">{{date("d-m-Y", strtotime(@Auth::user()->created_at))}}</span>
                                    

                                </td>
                            </tr>
                            
                            {{-- <tr class="highlight">
                                <td class="field">&nbsp;</td>
                                <td class="p-t-10 p-b-10">
                                    <button type="submit" class="btn btn-primary width-150">Update</button>
                                    <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div>
            <div class="tab-pane fade" id="profile-business">
                <!-- begin table -->
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        
                        <tbody>

                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">Store name<span class="required-star">* </span>:</td>
                                <td>
                                    {{-- {{$customerProfile->store_name}} --}}
                                    <input class="form-control" type="text" id="store_name" name="store_name"  value="{{@$customerProfile->store_name}}" placeholder="Please enter your store name" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Customer Type<span class="required-star">* </span>: </td>
                                <td>
                                    {{-- {{($customerProfile->customer_type == 1)? 'Dealer':(($customerProfile->customer_type==2)? 'Wholesale':'Distibuter')}} --}}
                                    <select class="form-control" id="customer_type" name="customer_type" placeholder="Please select customer type">
                                        <option value="">Please select customer type</option>
                                        <option value="1" {{(@$customerProfile->customer_type == 1)? 'selected':''}}>Dealer</option>
                                        <option value="2" {{(@$customerProfile->customer_type == 2)? 'selected':''}}>Wholesale</option>
                                        <option value="3" {{(@$customerProfile->customer_type == 3)? 'selected':''}}>Distibuter</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">Address: <span class="required-star">* </span> </td>
                                
                                <td>
                                    <input class="form-control" type="text" id="business_street_address" name="business_street_address" value="{{@$customerProfile->business_street_address}}" placeholder="Please enter address" data-parsley-required="true">
                                   

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Country<span class="required-star">* </span>: </td>
                                
                                <td>
                                    <select class="form-control country" id="business_country" name="business_country" placeholder="Please select country" data-parsley-required="true">
                                        <option value="">Please select country</option>
                                        <?php
                                                $countryes = getCountry();
                                                foreach($countryes as $country){
                                            ?>
                                                        <option value="{{$country->id}}" {{($country->id == @$customerProfile->business_country)? 'selected':''}}>{{$country->name}}</option>

                                            <?php } ?>
                                     
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">State<span class="required-star">* </span>:</td>
                                
                                <td>
                                    <select class="form-control state" id="state" name="business_state" placeholder="Please select state" data-parsley-required="true">
                                        <option value="">Please select state</option>
                                        <?php 
                                        $state = get_stateNameByStateId(@$customerProfile->business_state);
                                        
                                    ?>
                                        <option value="{{@$customerProfile->business_state}}" selected>{{@$state->name}}</option>
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">City<span class="required-star">* </span>: </td>
                                
                                <td>
                                    <select class="form-control city" id="city" name="business_city" placeholder="Please select city" data-parsley-required="true">
                                        <option value="">Please select city</option>
                                        <?php 
                                            $city = get_cityNameByCityId(@$customerProfile->business_city);
                                        ?>
                                            <option value="{{@$customerProfile->business_city}}" selected>{{@$city->name}}</option>
                                        
                                    </select>
                                    {{-- <input class="form-control" type="text" id="business_city" name="business_city" value="{{ @$customerProfile->business_city }}" placeholder="Please enter city" data-parsley-required="true"> --}}

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Postal Code<span class="required-star">* </span>: </td>
                                
                                <td>
                                    
                                    <input class="form-control" type="text" id="business_postal_code" name="business_postal_code" value="{{ @$customerProfile->business_postal_code }}" placeholder="Please enter postal code" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">GSTIN<span class="required-star">* </span>: </td>
                                
                                <td>
                                    
                                    <input class="form-control" type="text" id="business_gst_number" name="business_gst_number" value="{{ @$customerProfile->business_gst_number }}" placeholder="Please enter your GSTIN" data-parsley-required="true">


                                </td>
                            </tr>
                            
                                
                                <?php /*if($customerProfile->parent_code){?>
                            <tr>
                                    <td class="field">Parent organization: </td>
                                <td>
                                    <span class="badge badge-md badge-success">Yes</span><br>
                                    {{-- <input class="form-control" type="checkbox" id="parent_code" {{(@$customerProfile->parent_code)? 'checked':'' }} value="1" name="parent_code"> --}}
                                    

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Parent code: </td>
                                <td>
                                    
                                    {{$customerProfile->parent_code}}

                                </td>
                            </tr>

                                <?php }else{?>
                                <tr>
                                    <td class="field">Parent organization: </td>
                                    <td><span class="badge badge-md badge-success">No</span></td>
                                    
                                </tr>
                                <?php } */?>
                            
                            <tr class="highlight">
                                <td class="field">&nbsp;</td>
                                <td class="p-t-10 p-b-10">
                                    <button type="submit" class="btn btn-primary width-150">Update</button>
                                    <!-- <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button> -->
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div>
            {{-- <div class="tab-pane fade" id="profile-address">
                <!-- begin table -->
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        
                        <tbody>

                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">First name<span class="required-star">* </span>:</td>
                                <td>
                                    
                                    <input type="text" name="f_name" value="{{@$customerProfile->f_name}}" placeholder="Please enter first name" class="form-control"  data-parsley-required="true"/>

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Last name<span class="required-star">* </span>: </td>
                                <td>
                                   
                                    <input type="text" name="l_name" value="{{@$customerProfile->l_name}}" placeholder="Please enter last name" class="form-control"  data-parsley-required="true"/>

                                </td>
                            </tr>
                            
                            <tr>
                                <td class="field">Address<span class="required-star">* </span>: </td>
                                
                                <td>
                                   
                                    <input class="form-control" type="text" id="street_address" name="street_address" value="{{@$customerProfile->street_address}}" placeholder="Please enter address" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">Country<span class="required-star">* </span>: </td>
                                
                                <td>
                                    
                                <select class="form-control country" id="country" name="country" placeholder="Please select your country" data-parsley-required="true">
                                        <option value="">Please select your country</option>

                                       <?php
                                            $countryes = getCountry();
                                            foreach($countryes as $country){
                                       ?>
                                        <option value="{{$country->id}}" {{($country->id == @$customerProfile->country)? 'selected':''}}>{{$country->name}}</option>

                                        <?php } ?>
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">State<span class="required-star">* </span>: </td>
                                
                                <td>
                                    
                                    <select class="form-control state" id="state" name="state" placeholder="Please select state" data-parsley-required="true">
                                        <option value="">Please select state</option>
                                        <?php 
                                        $state = get_stateNameByStateId(@$customerProfile->state);
                                        
                                        ?>
                                        <option value="{{@$customerProfile->state}}" selected>{{@$state->name}}</option>
                                    
                                       
                                       
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">City<span class="required-star">* </span>: </td>
                                
                                <td>
                                    
                                    <select class="form-control city" id="city" name="city" placeholder="Please select city" data-parsley-required="true">
                                        <option value="">Please select city</option>
                                        <?php 
                                        $city = get_cityNameByCityId(@$customerProfile->city);
                                        ?>
                                        <option value="{{@$customerProfile->city}}" selected>{{@$city->name}}</option>
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">Postal Code<span class="required-star">* </span>: </td>
                                
                                <td>
                                   
                                    <input class="form-control" type="text" id="postal_code" name="postal_code" value="{{ @$customerProfile->postal_code }}" placeholder="Please enter your postal code" data-parsley-required="true">

                                </td>
                            </tr>
                            <tr>
                                <td class="field">GSTIN<span class="required-star">* </span>: </td>
                                <td>
                                    
                                    <input class="form-control" type="text" id="gst_number" name="gst_number" value="{{ @$customerProfile->gst_number }}" placeholder="Please enter your GSTIN">

                                </td>
                            </tr>
                            
                            
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div> --}}
            {{-- <div class="tab-pane fade" id="profile-team">
                <!-- begin table -->
                <div class="table-responsive form-inline">
                    <table class="table table-profile">
                        
                        <tbody>

                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <?php
                                $teams = get_teams_by_customer_id(@$customerProfile->cust_id); 
                                foreach($teams as $team)
                                {
                            ?>
                           
                            <tr>
                                <td class="field">Name: </td>
                                <td>{{$team->team_name}}</td>
                            </tr>
                            <tr>
                                <td class="field">Mobile number: </td>
                                <td>{{$team->team_mobile}}</td>
                            </tr>
                            <tr>
                                <td class="field">Email id: </td>
                                <td>{{$team->team_email}}</td>
                            </tr>
                            

                        <?php }?>
                            
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div> --}}
            <!-- end #profile-about tab -->
            <!-- begin #profile-photos tab -->
            <?php /*
            <div class="tab-pane fade" id="profile-photos" data-init="true">
                <h4 class="m-t-0 m-b-20">Documents </h4>
                <table class="table table-profile">
                    <thead>
                        
                            

                            <th class="field">GST Certificate<span class="required-star">* </span>:</th>
                            
                            <th class="field">Shop establishment license<span class="required-star">* </span>:</th>
                            <th class="field">MSME udyog adhar<span class="required-star">* </span>:</th>
                            <th class="field">FSSAI certificate<span class="required-star">* </span>:</th>
                            <th class="field">Trade certificate<span class="required-star">* </span>:</th>
                            
                            
                        
                    </thead>
                    <tbody>
                <tr>
                   <td>
                        
                        <?php if(!empty(@$customerProfile->gst_certificate)){?>
                            <a target="_blank" href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">
                                <img src="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}" width="70%" height="70%"/>
                            </a>
                        <?php }?>

                        <input type="file" class="docsValidation" name="gst_certificate"  placeholder="Please upload GST certificate"/>
                        <input type="hidden" name="gst_certificate_old"  value="{{@$customerProfile->gst_certificate}}"/>
                    
                    </td>
                
                    <td>
                        
                        <?php if(!empty(@$customerProfile->shop_establishment_license)){?>
                            <a target="_blank" href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">
                                <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}" width="70%" height="70%"/>
                            </a> 
                        <?php }?>

                        <input type="file" class="docsValidation" name="shop_establishment_license"  placeholder="Please upload shop establishment license"/>
                        <input type="hidden" name="shop_establishment_license_old"  value="{{@$customerProfile->shop_establishment_license}}"/>
                    </td>
                    <td>
                        
                        <?php if(!empty(@$customerProfile->msme_udyog_adhar)){?>
                            <a target="_blank" href="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}">
                                <img src="{{(@$customerProfile->msme_udyog_adhar)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->msme_udyog_adhar) : $default_certificate}}" width="70%" height="70%"/>
                            </a>
                        <?php }?>
                        <input type="file" class="docsValidation" name="msme_udyog_adhar"  placeholder="Please upload MSME Registration/Udyog Adhaar"/>
                        <input type="hidden" name="msme_udyog_adhar_old"  value="{{@$customerProfile->msme_udyog_adhar}}"/>
                    </td>
                    <td>
                        
                        <?php if(!empty(@$customerProfile->FSSAI_certificate)){?>
                            <a target="_blank" href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}" width="70%" height="70%"/>
                            </a>
                        <?php }?>
                        <input type="file" class="docsValidation" name="FSSAI_certificate"  placeholder="Please upload FSSAI certificate"/>
                        <input type="hidden" name="FSSAI_certificate_old"  value="{{@$customerProfile->FSSAI_certificate}}"/>
                    </td>
                    <td>
                        
                        <?php if(!empty(@$customerProfile->Trade_certificate)){?>

                            <a target="_blank" href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">
                                <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}" width="70%" height="70%"/>
                            </a>
                        <?php }?>
                        <input type="file" class="docsValidation" name="Trade_certificate" id="Trade_certificate"  placeholder="Please upload Trade certificate"/>
                        <input type="hidden" name="Trade_certificate_old"  value="{{@$customerProfile->Trade_certificate}}"/>
                    </td>
                </tr>
                
               
            </tbody>
            </table>
                <!-- begin superbox -->
               
                <!-- end superbox -->
                <div class="" id="updateCustomerPro" style="margin-left: 373px; margin-top: 100px;">
                    <button type="submit" class="btn btn-primary width-150">Update</button>
                    {{-- <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button> --}}
                </div>
            </div>
            <?php */?>
            <!-- end #profile-photos tab -->
            <!-- begin #profile-videos tab -->
            {{-- <div class="tab-pane fade" id="profile-videos">
                <h4 class="m-t-0 m-b-20">Videos (16)</h4>
                <!-- begin row -->
                <div class="row row-space-2">
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=RQ5ljyGg-ig" data-lity="">
                        <img src="https://img.youtube.com/vi/RQ5ljyGg-ig/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=5lWkZ-JaEOc" data-lity="">
                        <img src="https://img.youtube.com/vi/5lWkZ-JaEOc/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=9ZfN87gSjvI" data-lity="">
                        <img src="https://img.youtube.com/vi/9ZfN87gSjvI/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=w2H07DRv2_M" data-lity="">
                        <img src="https://img.youtube.com/vi/w2H07DRv2_M/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=PntG8KEVjR8" data-lity="">
                        <img src="https://img.youtube.com/vi/PntG8KEVjR8/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=q8kxKvSQ7MI" data-lity="">
                        <img src="https://img.youtube.com/vi/q8kxKvSQ7MI/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=cutu3Bw4ep4" data-lity="">
                        <img src="https://img.youtube.com/vi/cutu3Bw4ep4/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=gCspUXGrraM" data-lity="">
                        <img src="https://img.youtube.com/vi/gCspUXGrraM/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=COtpTM1MpAA" data-lity="">
                        <img src="https://img.youtube.com/vi/COtpTM1MpAA/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=8NVkGHVOazc" data-lity="">
                        <img src="https://img.youtube.com/vi/8NVkGHVOazc/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=QgQ7MWLsw1w" data-lity="">
                        <img src="https://img.youtube.com/vi/QgQ7MWLsw1w/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=Dmw0ucCv8aQ" data-lity="">
                        <img src="https://img.youtube.com/vi/Dmw0ucCv8aQ/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=r1d7ST2TG2U" data-lity="">
                        <img src="https://img.youtube.com/vi/r1d7ST2TG2U/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=WUR-XWBcHvs" data-lity="">
                        <img src="https://img.youtube.com/vi/WUR-XWBcHvs/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=A7sQ8RWj0Cw" data-lity="">
                        <img src="https://img.youtube.com/vi/A7sQ8RWj0Cw/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                    <!-- begin col-3 -->
                    <div class="col-md-3 col-sm-4 m-b-2">
                        <a href="https://www.youtube.com/watch?v=IMN2VfiXls4" data-lity="">
                        <img src="https://img.youtube.com/vi/IMN2VfiXls4/mqdefault.jpg" class="width-full">
                        </a>
                    </div>
                    <!-- end col-3 -->
                </div>
                <!-- end row -->
            </div> --}}
            <!-- end #profile-videos tab -->
            <!-- begin #profile-friends tab -->
            {{-- <div class="tab-pane fade active show" id="profile-friends">
                <h4 class="m-t-0 m-b-20">Friend List (14)</h4>
                <!-- begin row -->
                <div class="row row-space-6">
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-1.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">James Pittman</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-2.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Mitchell Ashcroft</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-3.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Ella Cabena</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-4.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Declan Dyson</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-5.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">George Seyler</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-6.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Patrick Musgrove</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-7.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Taj Connal</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-8.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Laura Pollock</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-9.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Dakota Mannix</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-10.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Timothy Woolley</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-11.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Benjamin Congreve</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-12.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Mariam Maddock</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-13.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Blake Gerrald</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- begin col-6 -->
                    <div class="col-xl-4 col-lg-6 m-b-5 p-b-1">
                        <div class="p-10 bg-white rounded">
                            <div class="media media-xs overflow-visible align-items-center">
                                <a class="media-left" href="javascript:;">
                                <img src="../assets/img/user/user-14.jpg" alt="" class="media-object img-circle">
                                </a>
                                <div class="media-body valign-middle">
                                    <b class="text-inverse">Gabrielle Bunton</b>
                                </div>
                                <div class="media-body valign-middle text-right overflow-visible">
                                    <div class="btn-group btn-group-sm dropdown">
                                        <a href="javascript:;" class="btn btn-default">Friends</a>
                                        <a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle"><b class="caret"></b></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:;" class="dropdown-item">Action 1</a>
                                            <a href="javascript:;" class="dropdown-item">Action 2</a>
                                            <a href="javascript:;" class="dropdown-item">Action 3</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item">Action 4</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                </div>
                <!-- end row -->
            </div> --}}
            <!-- end #profile-friends tab -->
        </div>
        <!-- end tab-content -->
        
    </div>
    
</form>
    <!-- end profile-content -->
</div>
