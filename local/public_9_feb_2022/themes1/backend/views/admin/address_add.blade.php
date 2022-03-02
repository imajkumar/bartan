<!-- begin #content -->

<div id="content" class="content">
   

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    {{-- <h4 class="panel-title">CUSTOMERS</h4> --}}
                    <h4 class="panel-title">ADDRESS</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('addAddress')}}" id="addAddress" name="addAddress" class="form-layout" data-parsley-validate="true">
                <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                <input type="hidden" name="user_id" value="{{$customer->user_id}}"/>
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">
                                {{-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="company_name">Company name</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="company_name" name="company_name" placeholder="Please enter company name">
                                    </div>
                                </div> --}}
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="f_name">First Name <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="f_name" name="f_name" placeholder="Please enter first name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="state">State <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="state" name="state" placeholder="Please select state" data-parsley-required="true">
                                            <option value="">Please select state</option>
                                            <option value="up">UP</option>
                                            <option value="bihar">Bihar</option>
                                        </select>
                                    </div>
                                </div>
                                
                               
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="default_address"> Default Address</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="checkbox" id="default_address" name="default_address"/>
                                    </div>
                                </div>
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                                {{-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="phone">Phone</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="phone" name="phone" placeholder="Please enter phone number">
                                    </div>
                                </div> --}}

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="l_name">Last Name <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="l_name" name="l_name" placeholder="Please enter last name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="city">City <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="city" name="city" placeholder="Please enter your city" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="postal_code">Postal Code <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="postal_code" name="postal_code" placeholder="Please enter your postal code" data-parsley-required="true">
                                    </div>
                                </div>
                               
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="street_address">Street Address <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="street_address" name="street_address" placeholder="Please enter your street address" data-parsley-required="true">
                                    </div>
                                </div>
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="country">Country <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="country" name="country" placeholder="Please select your country" data-parsley-required="true">
                                            <option value="">Please select your country</option>
                                            <option value="India">India</option>
                                            <option value="Pakistan">Pakistan</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                
                                
                               
                                
                       

                            </div>
                            
                            
                         

                            
                        </div>
                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                            <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                        </fieldset>
                    </form> 

                    
                    <!-- end #content -->
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

    </div>

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
