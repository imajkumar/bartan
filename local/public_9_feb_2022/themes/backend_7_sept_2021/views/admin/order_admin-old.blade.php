<!-- begin #content -->
<style>
    .modal-backdrop {
    position: inherit;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
    </style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        {{-- <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li> --}}
        <li class="breadcrumb-item active">Orders</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    
    <h1 class="page-header">ORDER <small>LIST</small></h1>

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ORDERS</h4>
                    <div class="panel-heading-btn">
                        {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}}
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Order Id</th>

                                        <th class="text-nowrap">Item Image</th>
                                        <th class="text-nowrap">Item Name</th>
                                        <th class="text-nowrap">Quantity</th>
                                       
                                        <th class="text-nowrap">Item Price</th>
                                        <th class="text-nowrap">Total Item Price</th>
                                        <th class="text-nowrap">Total Price</th>
                                        
                                        <th class="text-nowrap">Stage</th>
                                        {{-- <th class="text-nowrap">Status</th> --}}
                                        <th class="text-nowrap">Payment</th>
                                        <th class="text-nowrap">Date</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    foreach($itemOrders as $itemOrder){
                                     
                                        $item = get_item_detail($itemOrder->item_id);
                                        //pr($item);
                                            $itemImages = get_item_default_img_item_id($itemOrder->item_id);

                                            if($itemImages)
                                            {

                                                $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                                
                                            } else {

                                                $itemImg = FRONT.'img/product/product-iphone.png';
                                            }
                                      
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_id}}</td>
                                        <td><img src="{{$itemImg}}" width="50px" height="50px"/></td>
                                        
                                        <td>{{optional($item)->product_name }}</td>
                                        <td>{{optional($itemOrder)->quantity}}</td>
                                        <td>{{optional($itemOrder)->item_price}}</td>
                                        <td>{{$itemOrder->total_price}}</td>
                                        <td>{{$itemOrder->total_amount}}</td>
                                   
                                       
                                        <td>
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md badge-success">Processed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md badge-danger">New order</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md badge-danger">Packaging</span>

                                           
                                            @elseif($itemOrder->stage == 3)
                                                <span class="badge badge-md badge-danger">Shipping</span>

                                           
                                          
                                               
                                            @elseif($itemOrder->stage == 4)
                                            <span class="badge badge-md badge-danger">Delivered</span>
                                            
                                            @elseif($itemOrder->stage == 5)
                                            <span class="badge badge-md badge-danger">Hold</span>
                                            
                                            @elseif($itemOrder->stage == 6)
                                            <span class="badge badge-md badge-danger">Cancel</span>

                                            @else
                                            <span class="badge badge-md badge-danger">Return</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($itemOrder->status == 0)
                                                <span class="badge badge-md badge-danger">Hold</span>

                                            @elseif($itemOrder->status == 1)
                                                <span class="badge badge-md badge-danger">Cancel</span>

                                            @elseif($itemOrder->status == 2)
                                                <span class="badge badge-md badge-danger">Return</span>

                                           
                                            @else
                                                <span class="badge badge-md badge-success">Updated</span>
                                            @endif
                                        </td> --}}
                                        
                                        <td>
                                            <?php
                                             $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                            ?>
 
                                            @if($paymntStaus->status == 1)
                                                 <span class="badge badge-md badge-success">Success</span>
 
                                             @elseif($paymntStaus->status == 0)
                                                 <span class="badge badge-md badge-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        <td>
                                            {{date("d-m-Y", strtoTime($paymntStaus->created_at))}}
                                        </td>

                                        <td>
                                            {{-- <a href="{{route('editOrderStageAdmin', $itemOrder->order_id)}}" class="btn btn-primary"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> --}}
                                            <a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-primary" data-toggle="modal">Edit</a>
                                            {{-- @if($customer->deleted_at == 1)

                                                <a href="javascript:void();" id="{{$customer->id}}" onclick="customerDeactive(this.id);" class="btn btn-danger"><i class="far fa-lg fa-fw m-r-10 icon-user-unfollow"></i>Deactive</a>
                                            
                                            @else
                                                
                                                <a href="javascript:void();" id="{{$customer->id}}" onclick="customerActive(this.id);" class="btn btn-success"><i class="far fa-lg fa-fw m-r-10 icon-user-following"></i>Active</a>

                                            @endif --}}

                                            {{-- <a href="{{route('addressListLayout', $customer->id)}}" class="btn btn-primary"><i class="fas fa-lg fa-fw m-r-10 fa-address-book"></i>Address</a> --}}

                                            {{-- <form method="post" action="{{route('addAddress')}}" class="pull-right" id="addAddress">
                                                @csrf()
                                               <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                                               <input class="btn btn-info con" type="submit" value="Add address"/>
                                           </form> --}}
                                            {{-- <form method="post" action="{{route('deleteCustomer')}}" class="pull-right" id="deleteCustomer">
                                                @csrf()
                                               <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                                               <input class="btn btn-danger con" type="submit" value="Delete"/>
                                           </form> --}}
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

{{-- start model update stage--}}
<div class="modal fade" id="updateOrderStage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateOrderStageAdmin')}}" id="updateOrderStageAdmin" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        <input type="hidden" name="itemOrderId" id="itemOrderId"/>
                        <select name="stage" class="form-control" id="stage">
                            <option value="0">New order<option>
                            <option value="1">Processed<option>
                            <option value="2">Packaging<option>
                            <option value="3">Shipping<option>
                            <option value="4">Delivered<option>
                            <option value="5">Hold<option>
                            <option value="6">Cancel<option>
                            <option value="7">Return<option>
                        </select>
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update stage --}} 