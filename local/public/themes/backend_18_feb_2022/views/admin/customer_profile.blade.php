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
                <li class="nav-item"><a href="#profile-photos" class="nav-link" data-toggle="tab">DOCUMENTS</a></li>
                {{-- <li class="nav-item"><a href="#profile-videos" class="nav-link" data-toggle="tab">VIDEOS</a></li>
                <li class="nav-item"><a href="#profile-friends" class="nav-link active" data-toggle="tab">FRIENDS</a></li> --}}
            </ul>
            <!-- END profile-header-tab -->
        </div>
    </div>
    <!-- end profile -->
    <!-- begin profile-content -->
    <form action="{{route('updateCustomerProfileDetails')}}" method="post" id="updateCustomerProfileDetails" enctype="multipart/form-data">

        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" />
        <input type="hidden" name="c_id" value="{{@$customerProfile->cust_id}}" />
        <input type="hidden" name="address_id" value="{{@$customerProfile->address_id}}" />
        <input type="hidden" name="docs_id" value="{{@$customerProfile->docs_id}}" />
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
                                        <input class="form-control" type="text" id="cutomer_fname" name="cutomer_fname"
                                            value="{{@$customerProfile->cutomer_fname}}"
                                            placeholder="Please enter first name" data-parsley-required="true">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Last Name<span class="required-star">* </span>: </td>
                                    <td>
                                        {{-- {{$customerProfile->cutomer_lname}} --}}
                                        <input class="form-control" type="text" id="cutomer_lname" name="cutomer_lname"
                                            value="{{@$customerProfile->cutomer_lname}}"
                                            placeholder="Please enter last name" data-parsley-required="true">

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
                                        {{-- <input class="form-control" type="text" id="phone" name="mobile" value="{{Auth::user()->mobile}}"
                                        {{(Auth::user()->mobile)? 'readonly':''}} placeholder="Please enter phone
                                        number" data-parsley-required="true"> --}}
                                        <input class="form-control" type="text" id="phone" name="mobile"
                                            value="{{Auth::user()->mobile}}" placeholder="Please enter phone number"
                                            data-parsley-required="true">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Email Address<span class="required-star">* </span>: </td>

                                    <td>
                                        {{-- {{$user['email']}} --}}
                                        <input class="form-control" type="email" id="email" name="email"
                                            value="{{Auth::user()->email}}" placeholder="Please enter your email"
                                            data-parsley-required="true">
                                        {{-- <input class="form-control" type="email" id="email" name="email" value="{{Auth::user()->email}}"
                                        {{(Auth::user()->email)? 'readonly':''}} placeholder="Please enter your email"
                                        data-parsley-required="true"> --}}

                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Date of registration: </td>

                                    <td>

                                        <span
                                            class="form-control">{{date("d-m-Y", strtotime(@Auth::user()->created_at))}}</span>


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Alternative Phone
                                                    number: </td>

                                    <td>

                                    <input class="form-control" type="number" id="alternate_phone"
                                                    name="alternate_phone" value="{{Auth::user()->alternate_phone}}"
                                                    placeholder="Please enter your alternate phone number"
                                                    data-parsley-required="true">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Date of Birth: </td>

                                    <td>

                                    <input class="form-control" type="date" id="dob" name="dob"
                                                    value="{{@$customerProfile->dob}}"
                                                    placeholder="Please enter date of birth">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Spouse name: </td>

                                    <td>

                                    <input class="form-control" type="text" id="supouse_name"
                                                    name="supouse_name" value="{{@$customerProfile->supouse_name}}"
                                                    placeholder="Please enter supouse name">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Spouse name: </td>

                                    <td>

                                    <input class="form-control" type="text" id="supouse_name"
                                                    name="supouse_name" value="{{@$customerProfile->supouse_name}}"
                                                    placeholder="Please enter supouse name">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Anniversary Date: </td>

                                    <td>

                                    <input class="form-control" type="date" id="anniversary_date"
                                                    name="anniversary_date"
                                                    value="{{@$customerProfile->anniversary_date}}"
                                                    placeholder="Please enter anniversary date">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Shop Establishment Date: </td>

                                    <td>

                                    <input class="form-control" type="date" id="shop_estable_date"
                                                    name="shop_estable_date"
                                                    value="{{@$customerProfile->shop_estable_date}}"
                                                    placeholder="Please enter Shop Establishment Date">


                                    </td>
                                </tr>

                                

                                          

                                          
                                           
                                {{-- <tr class="highlight">
                                <td class="field">&nbsp;</td>
                                <!-- <td class="p-t-10 p-b-10">
                                    <button type="submit" class="btn btn-primary width-150">Update</button>
                                    <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button>
                                </td> -->
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
                                        <input class="form-control" type="text" id="store_name" name="store_name"
                                            value="{{@$customerProfile->store_name}}"
                                            placeholder="Please enter your store name" data-parsley-required="true">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Customer Type<span class="required-star">* </span>: </td>
                                    <td>
                                        {{-- {{($customerProfile->customer_type == 1)? 'Dealer':(($customerProfile->customer_type==2)? 'Wholesale':'Distibuter')}}
                                        --}}
                                        <select class="form-control" id="customer_type" name="customer_type"
                                            placeholder="Please select customer type">
                                            <option value="">Please select customer type</option>
                                            <option value="1"
                                                {{(@$customerProfile->customer_type == 1)? 'selected':''}}>Dealer
                                            </option>
                                            <option value="2"
                                                {{(@$customerProfile->customer_type == 2)? 'selected':''}}>Wholesale
                                            </option>
                                            <option value="3"
                                                {{(@$customerProfile->customer_type == 3)? 'selected':''}}>Distibuter
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Address: <span class="required-star">* </span> </td>

                                    <td>
                                        <input class="form-control" type="text" id="business_street_address"
                                            name="business_street_address"
                                            value="{{@$customerProfile->business_street_address}}"
                                            placeholder="Please enter address" data-parsley-required="true">


                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Country<span class="required-star">* </span>: </td>

                                    <td>
                                        <select class="form-control country" id="business_country"
                                            name="business_country" placeholder="Please select country"
                                            data-parsley-required="true">
                                            <option value="">Please select country</option>
                                            <?php
                                                $countryes = getCountry();
                                                foreach($countryes as $country){
                                            ?>
                                            <option value="{{$country->id}}"
                                                {{($country->id == @$customerProfile->business_country)? 'selected':''}}>
                                                {{$country->name}}</option>

                                            <?php } ?>


                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">State<span class="required-star">* </span>:</td>

                                    <td>
                                        <select class="form-control state" id="state" name="business_state"
                                            placeholder="Please select state" data-parsley-required="true">
                                            <option value="">Please select state</option>
                                            <?php 
                                        $state = get_stateNameByStateId(@$customerProfile->business_state);
                                        
                                    ?>
                                            <option value="{{@$customerProfile->business_state}}" selected>
                                                {{@$state->name}}</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">City<span class="required-star">* </span>: </td>

                                    <td>
                                        <select class="form-control city" id="city" name="business_city"
                                            placeholder="Please select city" data-parsley-required="true">
                                            <option value="">Please select city</option>
                                            <?php 
                                            $city = get_cityNameByCityId(@$customerProfile->business_city);
                                        ?>
                                            <option value="{{@$customerProfile->business_city}}" selected>
                                                {{@$city->name}}</option>

                                        </select>
                                        {{-- <input class="form-control" type="text" id="business_city" name="business_city" value="{{ @$customerProfile->business_city }}"
                                        placeholder="Please enter city" data-parsley-required="true"> --}}

                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">Postal Code<span class="required-star">* </span>: </td>

                                    <td>

                                        <input class="form-control" type="text" id="business_postal_code"
                                            name="business_postal_code"
                                            value="{{ @$customerProfile->business_postal_code }}"
                                            placeholder="Please enter postal code" data-parsley-required="true">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="field">GSTIN<span class="required-star">* </span>: </td>

                                    <td>

                                        <input class="form-control" type="text" id="business_gst_number"
                                            name="business_gst_number"
                                            value="{{ @$customerProfile->business_gst_number }}"
                                            placeholder="Please enter your GSTIN" data-parsley-required="true">


                                    </td>
                                </tr>


                                <?php /*if($customerProfile->parent_code){?>
                                <tr>
                                    <td class="field">Parent organization: </td>
                                    <td>
                                        <span class="badge badge-md badge-success">Yes</span><br>
                                        {{-- <input class="form-control" type="checkbox" id="parent_code" {{(@$customerProfile->parent_code)? 'checked':'' }}
                                        value="1" name="parent_code"> --}}


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

                                <!-- <tr class="highlight">
                                    <td class="field">&nbsp;</td>
                                    <td class="p-t-10 p-b-10">
                                        <button type="submit" class="btn btn-primary width-150">Update</button>
                                     
                                    </td>
                                </tr> -->
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
                                    
                                    <input type="text" name="f_name" value="{{@$customerProfile->f_name}}"
                placeholder="Please enter first name" class="form-control" data-parsley-required="true"/>

                </td>
                </tr>
                <tr>
                    <td class="field">Last name<span class="required-star">* </span>: </td>
                    <td>

                        <input type="text" name="l_name" value="{{@$customerProfile->l_name}}"
                            placeholder="Please enter last name" class="form-control" data-parsley-required="true" />

                    </td>
                </tr>

                <tr>
                    <td class="field">Address<span class="required-star">* </span>: </td>

                    <td>

                        <input class="form-control" type="text" id="street_address" name="street_address"
                            value="{{@$customerProfile->street_address}}" placeholder="Please enter address"
                            data-parsley-required="true">

                    </td>
                </tr>
                <tr>
                    <td class="field">Country<span class="required-star">* </span>: </td>

                    <td>

                        <select class="form-control country" id="country" name="country"
                            placeholder="Please select your country" data-parsley-required="true">
                            <option value="">Please select your country</option>

                            <?php
                                            $countryes = getCountry();
                                            foreach($countryes as $country){
                                       ?>
                            <option value="{{$country->id}}"
                                {{($country->id == @$customerProfile->country)? 'selected':''}}>{{$country->name}}
                            </option>

                            <?php } ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="field">State<span class="required-star">* </span>: </td>

                    <td>

                        <select class="form-control state" id="state" name="state" placeholder="Please select state"
                            data-parsley-required="true">
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

                        <select class="form-control city" id="city" name="city" placeholder="Please select city"
                            data-parsley-required="true">
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

                        <input class="form-control" type="text" id="postal_code" name="postal_code"
                            value="{{ @$customerProfile->postal_code }}" placeholder="Please enter your postal code"
                            data-parsley-required="true">

                    </td>
                </tr>
                <tr>
                    <td class="field">GSTIN<span class="required-star">* </span>: </td>
                    <td>

                        <input class="form-control" type="text" id="gst_number" name="gst_number"
                            value="{{ @$customerProfile->gst_number }}" placeholder="Please enter your GSTIN">

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

<div class="tab-pane fade" id="profile-photos" data-init="true">



    <div class="panel-body">
        <h1 class="page-header">Statutory Document <br><small class="text-danger"> <i><strong>(Any two document from
                        first four options are mandatory)</strong></i></small></h1>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No.</th>

                        <th class="text-nowrap">Document Type</th>
                        <th class="text-nowrap">Document Number</th>
                        <th width="20%" class="text-nowrap">Upload Image <span class="tooltip-toggle"
                                aria-label="(png,jpg,jpeg,pdf,Max. Size 5MB)" tabindex="0">
                                <!-- <svg viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="#fff" fill-rule="evenodd">
                                        <path
                                            d="M13.5 27C20.956 27 27 20.956 27 13.5S20.956 0 13.5 0 0 6.044 0 13.5 6.044 27 13.5 27zm0-2C7.15 25 2 19.85 2 13.5S7.15 2 13.5 2 25 7.15 25 13.5 19.85 25 13.5 25z" />
                                        <path
                                            d="M12.05 7.64c0-.228.04-.423.12-.585.077-.163.185-.295.32-.397.138-.102.298-.177.48-.227.184-.048.383-.073.598-.073.203 0 .398.025.584.074.186.05.35.126.488.228.14.102.252.234.336.397.084.162.127.357.127.584 0 .22-.043.412-.127.574-.084.163-.196.297-.336.4-.14.106-.302.185-.488.237-.186.053-.38.08-.584.08-.215 0-.414-.027-.597-.08-.182-.05-.342-.13-.48-.235-.135-.104-.243-.238-.32-.4-.08-.163-.12-.355-.12-.576zm-1.02 11.517c.134 0 .275-.013.424-.04.148-.025.284-.08.41-.16.124-.082.23-.198.313-.35.085-.15.127-.354.127-.61v-5.423c0-.238-.042-.43-.127-.57-.084-.144-.19-.254-.318-.332-.13-.08-.267-.13-.415-.153-.148-.024-.286-.036-.414-.036h-.21v-.95h4.195v7.463c0 .256.043.46.127.61.084.152.19.268.314.35.125.08.263.135.414.16.15.027.29.04.418.04h.21v.95H10.82v-.95h.21z" />
                                    </g>
                                </svg> -->
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
                        <td><input type="text" value="{{@$customerProfile->business_gst_number}}" name="business_gst_number1" id="business_gst_number1"
                                onkeyup="saveValue(this);" class="docnumber-group form-control">
                        </td>

                        <!-- <td><input type="file" class="form-control" data-toggle="tooltip" data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                <td width="1%" class="with-img"><div class="card" style="width: 3rem;">
                <img src="https://dev.bartan.com/assets/img/user/user-4.jpg" class="img-rounded height-30" /></div></td> -->
                        <td><input type="file" name="gst_certificate" id="gst_certificate"
                                class="docsValidation certificateDocValidate" data-toggle="tooltip" data-placement="top"
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
                                <a target="_blank"
                                    href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->gst_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->gst_certificate) : $default_certificate}}">

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
                        <td><input type="text" value="{{@$customerProfile->pan_number}}" name="pan_number" id="pan_number" onkeyup="saveValue(this);"
                                class="form-control docnumber-group"></td>

                        <td>
                            <input type="file" name="FSSAI_certificate" id="FSSAI_certificate"
                                class="docsValidation certificateDocValidate" data-toggle="tooltip" data-placement="top"
                                title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                        </td>
                        <input type="hidden" name="FSSAI_certificate_old" id="FSSAI_certificate_old"
                            value="{{@$customerProfile->FSSAI_certificate}}" />
                        <td width="1%" class="with-img">

                            <div class="card" style="width: 3rem;">
                                <?php 
                        if(!empty(@$customerProfile->FSSAI_certificate)){
                            
                            $explodDocGst = explode(".", @$customerProfile->FSSAI_certificate);
                            $gstDocExten = end($explodDocGst);
                            if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}">
                                    <img src="{{(@$customerProfile->FSSAI_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->FSSAI_certificate) : $default_certificate}}"
                                        class="img-rounded height-30" />
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
                        <td><input type="text" value="{{@$customerProfile->adhar_number}}" name="adhar_number" id="adhar_number" onkeyup="saveValue(this);"
                                class="form-control docnumber-group"></td>

                        <td>
                            <input type="file" name="adhar_card" id="adhar_card"
                                class="docsValidation certificateDocValidate" data-toggle="tooltip" data-placement="top"
                                title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                        </td>
                        <input type="hidden" name="adhar_card_old" id="adhar_card_old"
                            value="{{@$customerProfile->adhar_card}}" />
                        <td width="1%" class="with-img">

                            <div class="card" style="width: 3rem;">
                                <?php 
                        if(!empty(@$customerProfile->adhar_card)){
                            
                            $explodDocGst = explode(".", @$customerProfile->adhar_card);
                            $gstDocExten = end($explodDocGst);
                            if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}">
                                    <img src="{{(@$customerProfile->adhar_card)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->adhar_card) : $default_certificate}}"
                                        class="img-rounded height-30" />
                                </a>
                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" />


                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr class="even gradeC">
                        <td>4</td>
                        <td><strong>Driving License </strong></td>
                        <td>
                            <input class="form-control docnumber-group" type="text" value="{{@$customerProfile->dl_number}}" name="dl_number" id="dl_number"
                                onkeyup="saveValue(this);" placeholder="">

                        </td>

                        <td>
                            <input type="file" name="driving_license" id="driving_license"
                                class="docsValidation certificateDocValidate" data-toggle="tooltip" data-placement="top"
                                title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="driving_license_old" id="driving_license_old"
                                value="{{@$customerProfile->driving_license}}" />
                        </td>

                        <td width="1%" class="with-img">
                            <div class="card" style="width: 3rem;">
                                <!-- <img src="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}"
                                class="img-rounded height-30" /> -->


                                <!-- <input type="file" name="cancel_bank_cheque" id="cancel_bank_cheque" class="docsValidation form-control form-br" placeholder="Please upload cancel bank cheque"/>
                    <input type="hidden" name="cancel_bank_cheque_old" id="cancel_bank_cheque_old" value="{{@$customerProfile->cancel_bank_cheque}}"/> -->

                                <?php if(!empty(@$customerProfile->driving_license)){
                        $explodDocGst = explode(".", @$customerProfile->driving_license);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->driving_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->driving_license) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->driving_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->driving_license) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->driving_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->driving_license) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr class="even gradeC">
                        <td>5</td>
                        <td><strong>Cancel Cheque</strong></td>
                        <td><input type="text" value="{{@$customerProfile->cancel_check}}" name="cancel_check" id="cancel_check" onkeyup="saveValue(this);"
                                class="form-control"></td>

                        <td>
                            <input type="file" name="cancel_bank_cheque" id="cancel_bank_cheque" class="docsValidation"
                                data-toggle="tooltip" data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="cancel_bank_cheque_old" id="cancel_bank_cheque_old"
                                value="{{@$customerProfile->cancel_bank_cheque}}" />
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
                                <a target="_blank"
                                    href="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->cancel_bank_cheque)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->cancel_bank_cheque) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr class="odd gradeX">
                        <td>6</td>
                        <td><strong>Shop Establishment</strong></td>
                        <td><input type="text" value="{{@$customerProfile->shop_establishment_number}}" name="shop_establishment_number" onkeyup="saveValue(this);"
                                id="shop_establishment_number" class="form-control"></td>

                        <td><input type="file" name="shop_establishment_license" class="docsValidation"
                                data-toggle="tooltip" data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                        </td>
                        <input type="hidden" name="shop_establishment_license_old"
                            value="{{@$customerProfile->shop_establishment_license}}" />
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
                                <a target="_blank"
                                    href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->shop_establishment_license)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->shop_establishment_license) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


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
                        <td>7</td>
                        <td><strong>Trade Certificate</strong></td>
                        <td><input type="text" value="{{@$customerProfile->Trade_certificate_number}}" name="Trade_certificate_number" onkeyup="saveValue(this);"
                                id="Trade_certificate_number" class="form-control"></td>

                        <td><input type="file" name="Trade_certificate" class="docsValidation" data-toggle="tooltip"
                                data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)"></td>
                        <input type="hidden" name="Trade_certificate_old"
                            value="{{@$customerProfile->Trade_certificate}}" />
                        <td width="1%" class="with-img">
                            <div class="card" style="width: 3rem;">
                                <?php 
                        if(!empty(@$customerProfile->Trade_certificate)){
                    $explodDocGst = explode(".", @$customerProfile->Trade_certificate);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->Trade_certificate)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->Trade_certificate) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


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
                        <td>8</td>
                        <td><strong>Dealer Photo</strong></td>
                        <td><input type="text" class="form-control" disabled=""></td>

                        <td><input type="file" name="dealer_photo" class="docsValidation" data-toggle="tooltip"
                                data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="dealer_photo_old" value="{{@$customerProfile->dealer_photo}}" />
                        </td>
                        <td width="1%" class="with-img">
                            <div class="card" style="width: 3rem;">
                                <?php 
                        if(!empty(@$customerProfile->dealer_photo)){
                    $explodDocGst = explode(".", @$customerProfile->dealer_photo);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->dealer_photo)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->dealer_photo) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


                                <?php }?>
                            </div>
                        </td>





                    </tr>
                    <tr class="even gradeC">
                        <td>9</td>
                        <td><strong>Other Document</strong></td>
                        <td><input type="text" name="other_document_number" id="other_document_number"
                                class="form-control" disabled=""></td>

                        <td><input type="file" name="other_document" id="other_document" class="docsValidation"
                                data-toggle="tooltip" data-placement="top" title="(png,jpg,jpeg,pdf,Max. Size 5MB)">
                            <input type="hidden" name="other_document_old"
                                value="{{@$customerProfile->other_document}}" />
                        </td>
                        <td width="1%" class="with-img">
                            <div class="card" style="width: 3rem;">
                                <?php 
                        if(!empty(@$customerProfile->other_document)){
                    $explodDocGst = explode(".", @$customerProfile->other_document);
                        $gstDocExten = end($explodDocGst);
                        if($gstDocExten == "pdf"){

                            ?>
                                <a target="_blank"
                                    href="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}">

                                    <img src="{{$default_certificate_pdf}}" class="img-rounded height-30" />

                                </a>
                                <?php }else{?>

                                <a target="_blank"
                                    href="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}">


                                    <img src="{{(@$customerProfile->other_document)? asset('/'.ITEM_IMG_PATH.'/'.@$customerProfile->other_document) : $default_certificate}}"
                                        class="img-rounded height-30" />

                                </a>

                                <?php }}else{?>


                                <img src="{{$default_certificate}}" class="img-rounded height-30" alt="doc" />


                                <?php }?>
                            </div>
                        </td>


                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="" id="updateCustomerPro" style="margin-left: 373px; margin-top: 100px;">
        <button type="submit" class="btn btn-primary width-150">Update</button>
        {{-- <button type="submit" class="btn btn-white btn-white-without-border width-150 m-l-5">Cancel</button> --}}
    </div>

</div>



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