
    <div id="content" class="content">
    

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Cart</h4>
                    <div class="panel-heading-btn">
                    
                       

                      
 
                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">SR.</th>
                                        <th class="text-nowrap">Customer name</th>
                                        <th class="text-nowrap">Location</th>
                                        <th class="text-nowrap">Email id</th>
                                        <th class="text-nowrap">Phone number</th>
                                        <th class="text-nowrap">Customer category</th>
                                        <th class="text-nowrap">No.of items</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $i=1;
                                    //$customerCartLists = (object) $customerCartLists;
                                     foreach($customerCartLists as $customerCartList)
                                     {
                                        $countCartItem = DB::table('customer_carts')->where('customer_id', @$customerCartList->customer_id)->count();
                                        $customerdetail = get_customer_and_address_by__user_id(@$customerCartList->customer_id);
                                        //echo @$customerCartList->customer_id;pr($customerdetail);
                                        $customer_name = ucfirst(optional($customerdetail)->cutomer_fname.' '.@$customerdetail->cutomer_lname);

                                        $country = getCountryByCountryId(@$customerdetail->business_country);
                                        $state = get_stateNameByStateId(@$customerdetail->business_state);
                                        $users = @$customerdetail->business_state;
                                        $city = get_cityNameByCityId(@$customerdetail->business_city);
                                       
                                       
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrder);
                                            
                                        //if(count($itemOrders)>0){
                                    ?>
                                   <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$customer_name}}</td>
                                        <td>{{@$customerdetail->business_street_address}}</td>
                                        <td>{{@Auth::user()->email}}</td>
                                        <td>{{@Auth::user()->mobile}}</td>
                                        <td>{{(@$customerdetail->customer_type == 1)? 'Dealer':((@$customerdetail->customer_type == 2)? 'Wholesaler':((@$customerdetail->customer_type == 3)? 'Distibuter':''))}}</td>

                                        <td>{{$countCartItem}}</td>
                                        <td>
                                        <?php
                                            @$custmerId = \Crypt::encrypt(@$customerCartList->customer_id);
                                        ?>
                                        <a target="_blank" href="{{route('view_cart_customer', $custmerId)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View cart"><i class="fas fa-lg fa-fw fa-eye"></i></a>
                                        </td>
                                   </tr>
                                         
                                <?php }?>
                                </tbody>
                            </table>

                    </div>
                <!-- end col-8 -->

                
            </div>


        </div>
    </div>

</div>

