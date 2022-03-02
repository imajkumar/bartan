<!-- begin #content -->

<div id="content" class="content">
    
    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">SELLER</h4>
                    <div class="panel-heading-btn">
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('UpdateSalesPersion')}}" id="UpdateSalesPersion" name="UpdateSalesPersion" class="form-layout" data-parsley-validate="true">
                    @csrf  
                    <input type="hidden" name="seller_id" value="{{$seller->id}}"/> 
                    <input type="hidden" name="user_id" value="{{$seller->user_id}}"/> 
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_name">Name <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="seller_name" name="seller_name" value="{{optional($seller)->seller_name}}" placeholder="Please enter first name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_name">Sales Designation <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="seller_type" name="seller_type" data-parsley-required="true">
                                            <option selected disabled>Select Sales Designation</option>
                                            
                                            <?php
                                                foreach($sellerTpes as $sellerTpe){
                                            ?>

                                            <option value="{{$sellerTpe->id}}" {{($sellerTpe->id == $seller->seller_type_id)? 'selected':''}}>{{$sellerTpe->seller_type}}</option>

                                            <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_password">Password <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="seller_password" name="seller_password" value="{{optional($seller)->seller_password}}" placeholder="Please enter password" data-parsley-required="true">
                                    </div>
                                </div> --}}
                                
                                
                               
                               
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_email">Email </label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="email" id="seller_email" name="seller_email" value="{{optional($seller)->seller_email}}" placeholder="Please enter your email" data-parsley-required="true">
                                    </div>
                                </div>
                               
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_phone">Alternate phone</label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="number" id="alternate_phone" name="alternate_phone" value="{{optional($seller)->alternate_phone}}" placeholder="Please enter alternate phone">
                                    </div>
                                </div>
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                               
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="seller_phone">Mobile number <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="seller_phone" name="seller_phone" value="{{optional($seller)->seller_phone}}" placeholder="Please enter mobile number">
                                    </div>
                                </div>
                               
                                
                       

                            </div>
                            
                            
                         

                            
                        </div>
                        <fieldset style="padding: 17px;">
                           
                                <button type="submit" id="updateSellerBtn" class="btn btn-success">Save </button>
                                <button type="reset" class="btn btn-default">Cancel</button>
                            
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
