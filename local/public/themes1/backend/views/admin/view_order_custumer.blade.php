<?php 

$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$city = get_cityNameByCityId(@$customerdetail->business_city);

?>

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb hidden-print float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Order</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header hidden-print">Order detail <small>About order</small></h1>
    <!-- end page-header -->
    <!-- begin invoice -->
    <div class="invoice">
        <!-- begin invoice-company -->
        <div class="invoice-company">
            {{-- <span class="pull-right hidden-print">
                <a href="javascript:;" class="btn btn-sm btn-white m-b-10"><i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
                <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a> --}}
            </span>
            {{$customer_name}}
        </div>
        <!-- end invoice-company -->
        <!-- begin invoice-header -->
        <div class="invoice-header">
            {{-- <div class="invoice-from">
                <small>from</small>
                <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Twitter, Inc.</strong><br />
                    Street Address<br />
                    City, Zip Code<br />
                    Phone: (123) 456-7890<br />
                    Fax: (123) 456-7890
                </address>
            </div> --}}
            <div class="invoice-to">
                {{-- <small>to</small> --}}
                <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Customer name: {{@$customer_name}}</strong><br />
                    STREET ADDRESS: {{@$customerdetail->business_street_address}}<br />
                    COUNTRY:        {{@$country->name}}, 
                    STATE:          {{@$state->name}}, 
                    CITY:           {{@$city->name}}<br/> 
                    ZIP CODE:       {{@$customerdetail->business_postal_code}}<br />
                    PHONE NO.:      {{@Auth::user()->mobile}}<br />
                    EMAIL ID:       {{@Auth::user()->email}}<br />
                    GST NO.:        {{@$customerdetail->business_gst_number}}<br />
                    {{-- Fax: (123) 456-7890 --}}
                </address>
            </div>
           <div class="invoice-date">
                <!-- <small>Invoice / July period</small> -->
                <div class="date text-inverse m-t-5">{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</div>
                <div class="invoice-detail">
                Order no: {{$itemOrders[0]->order_id}}<br />
                Stage: 
                @if($itemOrders[0]->stage == 1)
                            <span class="badge badge-md badge-success">Confirmed</span>

                        @elseif($itemOrders[0]->stage == 0)
                            <span class="badge badge-md badge-danger">Pending</span>

                        @elseif($itemOrders[0]->stage == 2)
                            <span class="badge badge-md badge-danger">Packaging</span>

                       
                        @elseif($itemOrders[0]->stage == 3)
                            <span class="badge badge-md badge-danger">Shipping</span>

                        @elseif($itemOrders[0]->stage == 4)
                            <span class="badge badge-md badge-danger">Delivered</span>
                            
                        @elseif($itemOrders[0]->stage == 5)
                            <span class="badge badge-md badge-danger">Hold</span>
                            
                        @elseif($itemOrders[0]->stage == 6)
                            <span class="badge badge-md badge-danger">Cancel</span>

                        @else
                            <span class="badge badge-md badge-danger">Return</span>
                       
                       
                      
                        @endif
                <br />

                Payment status:
                <?php
                         $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrders[0]->order_id)
                        ->first();
                        ?>

                        @if(@$paymntStaus->status == 1)
                             <span class="badge badge-md badge-success">Success</span>

                         @elseif(@$paymntStaus->status == 0)
                             <span class="badge badge-md badge-danger">Pending</span>

                         
                         @endif

                
                    
                </div>
            </div>
        </div>
        <!-- end invoice-header -->
        <!-- begin invoice-content -->
        <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
                <table class="table table-invoice">
                    <thead>
                        <tr>
                            <!-- <th class="field">Order no</th>
                            <th class="field">Order date</th> -->
                            
                            <th class="field">Item</th>
                            <th class="field">Item Name</th>
                            <th class="field">Quantity</th>
                            <th class="field">Unit</th>
                            
                            <th class="field">Item Rate</th>
                            <th class="field">Discount</th>
                            <th class="field">Net Rate</th>
                            <th class="field">Amount</th>
                            <?php
                                $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first();
                                if ($users->cutomer_state == 10) {
                                ?>
                                    <th class="text-center">CGST</th>
                                    <th class="text-center">SGST</th>
                                <?php
                                } else {
                                ?>
                                    <th class="text-center">IGST</th>
                                <?php
                                }

                                ?>
                            <!-- <th class="field">Total Item Price</th> -->
                            <th class="field">Total Amount</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                    //pr($itemOrders);
                                    foreach($itemOrders as $itemOrder){
                                             
                                        $item = get_item_detail($itemOrder->item_id);
                                        $itemImages = get_item_default_img_item_id($itemOrder->item_id);
                                        
                                        if($itemImages)
                                        {
                                            
                                            $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                            
                                        } else {
                                            
                                            $itemImg = FRONT.'img/product/product-iphone.png';
                                        }
                                        
                                        ?>
                        <tr>
                            <!-- <td class="value">{{$itemOrder->order_id}}</td>
                            <td class="value">
                                {{date("d-m-Y", strtoTime($itemOrder->created_at))}}
                            </td> -->
                            <td class="value"><img src="{{$itemImg}}" width="50px" height="50px"/></td>
                            
                            <td class="value">{{optional($item)->product_name }}</td>
                            <td class="value">{{optional($itemOrder)->quantity}}</td>
                            <td class="value">{{optional($itemOrder)->unit}}</td>
                            <td class="value">{{optional($itemOrder)->item_price}}</td>
                            <td class="value">{{optional($itemOrder)->discount}}</td>
                            <td class="value">{{optional($itemOrder)->net_rate}}</td>
                            <td class="value">{{optional($itemOrder)->total_price}}</td>
                            <?php
                                $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first();
                                if ($users->cutomer_state == 10) {
                                ?>

                                <td class="value">{{optional($itemOrder)->cgst}}</td>
                                <td class="value">{{optional($itemOrder)->sgst}}</td>
                                
                                   
                                <?php
                                } else {
                                ?>
                                    <td class="value">{{optional($itemOrder)->igst}}</td>
                                <?php
                                }

                                ?>
                            <!-- <td class="value">{{$itemOrder->total_price}}</td> -->
                             <td class="value">{{$itemOrder->total_amount}}</td>
                    
                   
                   
                    
                    
                            
                        </tr>
                        
                        
                    <?php }?>
                        
                    <tr>
                                <td class="cart-summary" colspan="12">
                                    <div class="summary-container">
                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <div class="value">{{optional($itemOrders[0])->subTotalAmt}}</div>
                                        </div>
                                        <?php
                                        if ($users->cutomer_state == 10) {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">CGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtCGST}}</div>
                                            </div>
                                            <div class="summary-row text-primary">
                                                <div class="field">SGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtSGST}}</div>
                                            </div>

                                        <?php
                                        } else {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">IGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtIGST}}</div>
                                            </div>
                                        <?php
                                        }
                                        ?>


                                        <div class="summary-row total">
                                            <div class="field">Grand Total</div>
                                            <div class="value">{{optional($itemOrders[0])->grand_total}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>  
                        
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
                {{-- <div class="invoice-price-left">
                    <div class="invoice-price-row">
                        <div class="sub-price">
                            <small>SUBTOTAL</small>
                            <span class="text-inverse">$4,500.00</span>
                        </div>
                        <div class="sub-price">
                            <i class="fa fa-plus text-muted"></i>
                        </div>
                        <div class="sub-price">
                            <small>PAYPAL FEE (5.4%)</small>
                            <span class="text-inverse">$108.00</span>
                        </div>
                    </div>
                </div> --}}
               <!--  <div class="invoice-price-right">
                    <small>TOTAL</small> <span class="f-w-600">₹{{@$itemOrders[0]->grand_total}}</span>
                </div> -->
            </div>
            <!-- end invoice-price -->
        </div>
        <!-- end invoice-content -->
        <!-- begin invoice-note -->
        {{-- <div class="invoice-note">
            * Make all cheques payable to [Your Company Name]<br />
            * Payment is due within 30 days<br />
            * If you have any questions concerning this invoice, contact  [Name, Phone Number, Email]
        </div> --}}
        <!-- end invoice-note -->
        <!-- begin invoice-footer -->
        <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
                THANK YOU FOR YOUR BUSINESS
            </p>
            <p class="text-center">
            <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {{url('/')}}</span>
                <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T:016-18192302</span>
                <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {{env('MAIL_FROM_ADDRESS')}}</span>
            </p>
        </div>
        <!-- end invoice-footer -->
    </div>
    <!-- end invoice -->
</div>