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
   
    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">CUSTOMERS</h4>
                    <div class="panel-heading-btn">
                     <!--    {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}} -->
                     

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                     <!--    {{-- <div id="Grid"></div> --}} -->
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        {{-- <th class="text-nowrap">Gender</th> --}}
                                        <th class="text-nowrap">Phone</th>
                                        <th class="text-nowrap">Payment option</th>
                                        {{-- <th class="text-nowrap">Date of birth</th> --}}
                                        <th class="text-nowrap">Profile Status</th>
                                        <th class="text-nowrap">Customer status</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // pr($dataObjArr);
                                    foreach($dataObjArr as $customer){
                                        $users = get_user_by_user_id($customer->user_id);
                                        
                                        // echo $users['email'];
                                    ?>
                                    <tr>
                                        <td>{{$customer->id}}</td>
                                        <td>{{ucfirst($customer->cutomer_fname.' '.$customer->cutomer_lname)}}</td>
                                        
                                        <td>{{$customer->email}}</td>
                                        {{-- <td>{{$customer->gender}}</td> --}}
                                        <td>{{$customer->phone}}</td>

                                        <td>{{@$customer->payment_option}}</td>

                                        {{-- <td>{{$customer->dob}}</td> --}}
                                        <td>
                                            @if($customer->status == 1)
                                                <span class="badge badge-md btn-success">Approved</span>

                                            @elseif($customer->status == 0)
                                                <span class="badge badge-md btn-danger">Pending</span>

                                            @elseif($customer->status == 2)
                                                <span class="badge badge-md btn-danger">Rejected</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Updated</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($customer->deleted_at == 1)
                                                <span class="badge badge-md btn-success">Active</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Deactive</span>

                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{route('editCustomerLayout', $customer->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                        
                                            @if($customer->deleted_at == 1)

                                                <a href="javascript:void();" id="{{$customer->id}}" onclick="customerDeactive(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i></a>
                                            
                                            @else
                                                
                                                <a href="javascript:void();" id="{{$customer->id}}" onclick="customerActive(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i></a>

                                            @endif

                                            <!-- <a href="#updateCustomerDiscount" id="{{$customer->id}}" onclick="updateCustomerDiscount(this.id);" class="updateCustomerDiscount btn btn-success" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Discount</a> -->
                                            <a href="#updateCustomerDiscount" id="{{$customer->id.'_'.@$customer->customer_cat_discount.'_'.@$customer->customer_class_discount}}" onclick="updateCustomerDiscount(this.id);" class="updateCustomerDiscount btn btn-success" data-toggle="modal" data-toggle="tooltip" data-container="body" data-title="Category & Class"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                            
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





{{-- start model update Discount--}}
<div class="modal fade" id="updateCustomerDiscount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateCustomerDiscount')}}" id="updateCustomerDiscount" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Discount class and category</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        <input type="hidden" name="customerId" id="customerId"/>
                        <!-- <select name="customer_cat_discount" class="form-control" id="customer_cat_discount">
                            <option value="" disabled>Select customer category discount<option>
                            <?php
                                $customerCategoryDiscounts = DB::table('tbl_customer_category_discount')->get();  

                                foreach($customerCategoryDiscounts as $customerCategoryDiscount){
                                    
                            ?>
                                
                                <option value="{{$customerCategoryDiscount->id}}">{{$customerCategoryDiscount->cat_class}}<option>
                            
                            <?php }?>
                            
                        </select> -->
                        <select  name="customer_cat_discount" class="form-control" id="customer_cat_discount">
                                         <option value="">Select customer category</option>
                                         <?php 
                                            $customerCategoryLists =  getCustomerCategoryList();
                                            foreach($customerCategoryLists as $customerCategoryList){
                                           
                                         ?>
                                         <option value="{{$customerCategoryList->id}}">{{$customerCategoryList->cust_category_name}}</option>
                                        
                                        <?php }?>
                                   </select>

                        <select name="customer_class_discount" class="form-control" placeholder="Select customer class discount" id="customer_class_discount">
                            <option value="">Select customer class discount<option>
                            <?php
                                $customerClassDiscounts = get_customer_classes();  

                                foreach($customerClassDiscounts as $customerClassDiscount){

                            ?>
                                <option value="{{$customerClassDiscount->id}}">{{$customerClassDiscount->cust_class_name}}<option>
                            
                            <?php }?>
                        </select>
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-primary"> Update</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update discount --}} 

