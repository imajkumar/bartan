<!-- begin #content -->

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        {{-- <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li> --}}
        <li class="breadcrumb-item active">Edit customer</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    
    <h1 class="page-header">CUSTOMER <small>edit</small></h1>

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">CUSTOMERS</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('updateCustomer')}}" id="updateCustomer" name="updateCustomer" class="form-layout" data-parsley-validate="true">
                    <input type="hidden" name="customer_id" id="customer_id" value="{{$customer->id}}"/>
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="f_name">First Name <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                    <input class="form-control" type="text" id="f_name" name="f_name" value="{{$customer->f_name}}" placeholder="Please enter first name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="gender">Gender <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="gender" name="gender" placeholder="Please select gender" data-parsley-required="true">
                                            <option value="">Please select gender</option>
                                            <option value="Male" {{($customer->gender == 'Male')? 'selected':''}}>Male</option>
                                            <option value="Female" {{($customer->gender == 'Female')? 'selected':''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="customer_type">Customer Type</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="customer_type" name="customer_type" placeholder="Please select customer type">
                                            <option value="">Please select customer type</option>
                                            <option value="1" {{($customer->customer_type == 1)? 'selected':''}}>General</option>
                                            <option value="2" {{($customer->customer_type == 2)? 'selected':''}}>Wholesale</option>
                                        </select>
                                    </div>
                                </div>
                               
                               
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="l_name">Last Name <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="l_name" name="l_name" value="{{$customer->l_name}}" placeholder="Please enter last name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="dob">Date of Birth</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="dob" name="dob" value="{{$customer->dob}}" placeholder="Please enter date of birth">
                                    </div>
                                </div>
                               
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="email">Email <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="email" id="email" name="email" value="{{$customer->email}}" placeholder="Please enter your email" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="phone">Phone</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="phone" name="phone" value="{{$customer->phone}}" placeholder="Please enter phone number">
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
