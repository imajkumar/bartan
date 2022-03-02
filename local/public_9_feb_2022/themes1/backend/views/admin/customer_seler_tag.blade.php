<div id="content" class="content">

    <div class="row">

        <div class="col-xl-12">

            <ul class="nav nav-tabs m-b-10">
                <!-- <li class="nav-item m-r-10">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Class discounts</span>
                        <span class="d-sm-block d-none">Class discounts</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Category discounts</span>
                        <span class="d-sm-block d-none">Category discounts</span>
                    </a>
                </li> -->
                
            </ul>
            <div class="tab-content">

                <div class="tab-pane fade active show" id="default-tab-1">

                    <div id="editCustomerSalesTagingForm"> </div>
                    <form action="{{route('saveCustomerSales')}}" method="post" class="" id="saveCustomerSales">
                       
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                   <select  name="customer_id" id="customer_id" class="form-control">
                                   <option value="">Select customer</option>
                                   
                                   <?php 
                                        $customers = DB::table('tbl_customers')
                                        ->where('status', 1)
                                        ->where('deleted_at', 1)
                                        ->get();
                                    //pr( $customers);
                                    foreach($customers as $customer){

                                   $customerType = (@$customer->customer_type == 1)? 'Dealer':((@$customer->customer_type == 2)? 'Wholesaler':((@$customer->customer_type == 3)? 'Distibuter':''));
                                   ?>
                                   <option value="{{$customer->user_id}}">{{ucfirst(@$customer->cutomer_fname.' '.@$customer->cutomer_lname).'-'.$customerType.'-'.$customer->phone.'-'.$customer->email}}</option>

                                  <?php }?>
                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="se_sales_id">SE</label>
                                    <select  name="se_id" id="se_sales_id" class="form-control">
                                    <option value="">Select Sales SE</option>
                                    
                                    <?php 
                                        $SE_salers = DB::table('tbl_sellers')
                                        ->where('status', 1)
                                        ->where('seller_type_id', 4)
                                        
                                        ->get();
                                   
                                    foreach($SE_salers as $SE_sales){

                                  
                                   ?>
                                   <option value="{{$SE_sales->user_id}}">{{ucfirst($SE_sales->seller_name)}}</option>
                                    
                                    <?php }?>
                                   
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="asm_sales_id">ASM</label>
                                   <select  name="asm_id" id="asm_sales_id" class="form-control">
                                        <option value="">Select Sales ASM</option>
                                    <?php 
                                        $SE_salers = DB::table('tbl_sellers')
                                        ->where('status', 1)
                                        ->where('seller_type_id', 3)
                                        
                                        ->get();
                                   
                                    foreach($SE_salers as $SE_sales){

                                  
                                   ?>
                                   <option value="{{$SE_sales->user_id}}">{{ucfirst($SE_sales->seller_name)}}</option>
                                    
                                    <?php }?>

                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rsm_sales_id">RSM</label>
                                   <select  name="rsm_id" id="rsm_sales_id" class="form-control">
                                        <option value="">Select Sales RSM</option>
                                        <?php 
                                        $SE_salers = DB::table('tbl_sellers')
                                        ->where('status', 1)
                                        ->where('seller_type_id', 2)
                                        
                                        ->get();
                                   
                                    foreach($SE_salers as $SE_sales){

                                  
                                   ?>
                                   <option value="{{$SE_sales->user_id}}">{{ucfirst($SE_sales->seller_name)}}</option>
                                    
                                    <?php }?>

                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nsm_sales_id">SM</label>
                                   <select  name="nsm_id" id="nsm_sales_id" class="form-control">
                                        <option value="">Select Sales SM</option>
                                        <?php 
                                        $SE_salers = DB::table('tbl_sellers')
                                        ->where('status', 1)
                                        ->where('seller_type_id', 1)
                                        
                                        ->get();
                                   
                                    foreach($SE_salers as $SE_sales){

                                  
                                   ?>
                                   <option value="{{$SE_sales->user_id}}">{{ucfirst($SE_sales->seller_name)}}</option>
                                    
                                    <?php }?>

                                   </select>
                                </div>

                            </div>
                          
                            
                           
                            
                            
                        </div>


                        <fieldset>
                            <input type="submit" value="Save" class="btn btn-success m-b-10" />

                        </fieldset>
                        

                        <!-- volume settings  -->
                    </form>

                    <table id="" class="table table-striped table-bordered table-td-valign-middle">
                    <!-- <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle"> -->
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Customer</th>
                                        <th class="text-nowrap">SE</th>
                                        <th class="text-nowrap">ASM</th>
                                        <th class="text-nowrap">RSM</th>
                                        <th class="text-nowrap">SM</th>
                                        <th class="text-nowrap">Created Date</th>
                                       
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="appendCustomerSales">
                                    
                                <?php
                                    
                                    foreach($customerSaleses as $customerSale){
                                        @$customerDetail = DB::table('tbl_customers')->where('id', $customerSale->customer_id)->first();
                                           

                                            if (@$customerDetail->customer_type == 1) {
                                                $customerType = 'Dealer';

                                            }else if (@$customerDetail->customer_type == 2) {
                                                $customerType = 'Wholesaller';

                                            }else{
                                                $customerDetail = 'Distibuter';
                                            }

                                            @$se_sales_detail = DB::table('tbl_sellers')->where('user_id', @$customerSale->se_id)->first();
                                            @$SE_sales_name = @$se_sales_detail->seller_name;
                                        
                                            @$asm_sales_detail = DB::table('tbl_sellers')->where('user_id', @$customerSale->asm_id)->first();
                                            @$ASM_sales_name = @$asm_sales_detail->seller_name;

                                            @$rsm_sales_detail = DB::table('tbl_sellers')->where('user_id', @$customerSale->rsm_id)->first();
                                            @$RSM_sales_name = @$rsm_sales_detail->seller_name;

                                            @$nsm_sales_detail = DB::table('tbl_sellers')->where('user_id', @$customerSale->nsm_id)->first();
                                            @$NSM_sales_name = @$nsm_sales_detail->seller_name;

                                            
                                            $customerName = ucfirst(@$customerDetail->cutomer_fname.' '.@$customerDetail->cutomer_lname).'-'.@$customerType.'-'.@$customerDetail->phone.'-'.@$customerDetail->email;
                                            
                                        ?>
                                    <tr>
                                        
                                        <td>{{@$customerSale->id}}</td>
                                        <td>{{@$customerName}}</td>
                                        <td>{{ucfirst(@$SE_sales_name)}}</td>
                                            
                                        <td>{{ucfirst(@$ASM_sales_name)}}</td>
                                        <td>{{ucfirst(@$RSM_sales_name)}}</td>
                                        <td>{{ucfirst(@$NSM_sales_name)}}</td>
                                        
                                        <td>{{date("d-m-Y", strtotime(@$customerSale->created_at))}}</td>
                                       
                                       
                                        <td>
                                            <a class="btn btn-default" id="{{@$customerSale->id}}" onclick="editCustomerSalesTaging(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <!-- <a class="btn btn-danger hellodel" id="{{@$customerSale->id}}" href="javascript:void();">Delete</a> -->
                                        </td>
                                       
                                    </tr>

                                <?php }?>

                                </tbody>
                            </table>

               </div>

                 
               

            </div>


         </div>

    </div>

</div>


