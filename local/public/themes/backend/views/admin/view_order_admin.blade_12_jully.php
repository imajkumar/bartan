<?php 

//pr($itemOrders);
$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$users = @$customerdetail->business_state;
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
    <div class="invoice" id="checkout-cart">
        <!-- begin invoice-company -->
        <div class="invoice-company">
        <div class="col-lg-3 pull-right">
                        <!-- <a href="javascript:void();" id="downViewCart" onclick="getPDF()" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> -->
                            <!-- <a href="javascript:void();" id="printViewCart" onclick="window.print();" data-toggle="tooltip" data-placement="top" title="Print"><i class="fas fa-print"></i></a> -->
                        </div>
             <span class="pull-right hidden-print">
                <a href="javascript:;" id="downViewCart" onclick="getPDF()" class="btn btn-sm btn-white m-b-10"><i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
                <!-- <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>  -->
            </span>
            {{$customer_name}}
        </div>
        <!-- end invoice-company -->
        <!-- begin invoice-header -->
        <div class="invoice-header">
            
            <div class="invoice-to">
                {{-- <small>to</small> --}}
                <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Customer name: {{@$customer_name}}</strong><br />
                    Street Address: {{@$customerdetail->business_street_address}}<br />
                    Country: {{@$country->name}}, 
                    State: {{@$state->name}}, 
                    City: {{@$city->name}}<br/> 
                    Zip Code: {{@$customerdetail->business_postal_code}}<br />
                    Phone: {{@Auth::user()->mobile}}<br />
                    Emal id: {{@Auth::user()->email}}<br />
                    GST NO.: {{@$customerdetail->business_gst_number}}<br />
                    {{-- Fax: (123) 456-7890 --}}
                </address>
            </div>
            <div class="invoice-date">
                <!-- <small>Invoice / July period</small> -->
                <div class="date text-inverse m-t-5">{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</div>
                <div class="invoice-detail">
                Order no: {{$itemOrders[0]->order_id}}<br />
                Stage: @if($itemOrders[0]->stage == 1)
                                    <span class="badge badge-md badge-success">Proccessed</span>

                                @elseif($itemOrders[0]->stage == 0)
                                    <span class="badge badge-md badge-danger">New order</span>

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

                         
                         @endif<br />
                    
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
                           
                            
                            <th class="field">Item</th>
                            <th class="field">Item Name</th>
                            <th class="field">Quantity</th>
                            <th class="field">Unit</th>
                            
                            <th class="field">Item Rate</th>
                            <th class="field">Discount</th>
                            <th class="field">Net Rate</th>
                            <th class="field">Amount</th>
                            <?php
                           
                                if ($users == 10) {
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
                           
                            <td class="value"><img src="{{$itemImg}}" width="50px" height="50px"/></td>
                            
                            <td class="value">{{optional($item)->product_name }}</td>
                            <td class="value">{{optional($itemOrder)->quantity}}</td>
                            <td class="value">{{optional($itemOrder)->unit}}</td>
                            <td class="value">{{optional($itemOrder)->item_price}}</td>
                            <td class="value">{{optional($itemOrder)->discount}}</td>
                            <td class="value">{{optional($itemOrder)->net_rate}}</td>
                            <td class="value">{{optional($itemOrder)->total_price}}</td>
                            <?php
                               
                                if ($users == 10) {
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
                             <td class="value text-center">{{$itemOrder->total_amount}}</td>
                    
                   
                            
                    
                            
                        </tr>
                        
                        
                    <?php }?>

                    <!-- Start delivery and packing charges code -->
                    <tr>
                              <td class="cart-price"> Packaging Charges </td>


                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargDiscount}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargNetRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargBasic}}</td>

                                    <?php
                                    if ($users == 10) {
                                    ?>
                                        <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargCGST}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargSGST}}</td>
                                       
                                    <?php
                                    } else {
                                    ?>
                                       <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargIGST}}</td>
                                       
                                    <?php
                                    }

                                    ?>
                                    

                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargAmount}}</td>
                             </tr>
                             <tr>
                              <td class="cart-price"> Delivery Charge</td>

                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargDiscount}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargNetRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargBasic}}</td>

                                    <?php
                                    if ($users == 10) {
                                    ?>
                                       <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargCGST}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargSGST}}</td>
                                       
                                    <?php
                                    } else {
                                    ?>
                                       <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargIGST}}</td>
                                       
                                    <?php
                                    }

                                    ?>

                                   
                                   

                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargAmount}}</td>
                             </tr>
                    <!-- End delivery and packing charges code -->
                        
                    <tr>
                                <td class="cart-summary" colspan="12">
                                    <div class="summary-container">
                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <div class="value">{{optional($itemOrders[0])->subTotalAmt}}</div>
                                        </div>
                                        <?php
                                        if ($users == 10) {
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
                                            <div class="value">{{@$itemOrders[0]->grand_total}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr> 
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
           <!--  <div class="invoice-price">
               
                <div class="invoice-price-right">
                    <small>TOTAL</small> <span class="f-w-600">???{{@$itemOrders[0]->grand_total}}</span>
                </div>
            </div> -->
          
        </div>
        <!-- end invoice-content -->
        
    </div>
    <!-- end invoice -->
</div>