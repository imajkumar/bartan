<!-- begin #content -->

<div id="content" class="content">
  
    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Sales person</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('addSlaesPersionLayout')}}" style="border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a>
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 -->
                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        {{-- <th class="text-nowrap">Gender</th> --}}
                                        <th class="text-nowrap">Phone</th>
                                        {{-- <th class="text-nowrap">Password</th> --}}
                                        <th class="text-nowrap">Status</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($dataObjArr as $salesPersion){
                                       
                                        
                                        
                                    ?>
                                    <tr>
                                        <td>{{$salesPersion->id}}</td>
                                        <td>{{ucfirst($salesPersion->seller_name)}}</td>
                                        
                                        <td>{{$salesPersion->seller_email}}</td>
                                        {{-- <td>{{$customer->gender}}</td> --}}
                                        <td>{{$salesPersion->seller_phone}}</td>
                                        {{-- <td>{{$salesPersion->seller_password}}</td> --}}
                                        
                                        {{-- <td>
                                            @if($customer->status == 1)
                                                <span class="badge badge-md btn-success">Approved</span>

                                            @elseif($customer->status == 0)
                                                <span class="badge badge-md btn-danger">Pending</span>

                                            @elseif($customer->status == 2)
                                                <span class="badge badge-md btn-danger">Rejected</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Updated</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if($salesPersion->status == 1)
                                                <span class="badge badge-md btn-success">Active</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Deactive</span>

                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{route('editSalesPersionLayout', $salesPersion->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                        
                                            @if($salesPersion->status == 1)

                                                <a href="javascript:void();" id="{{$salesPersion->id}}" onclick="sellerDeactive(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i></a>
                                            
                                            @else
                                                
                                                <a href="javascript:void();" id="{{$salesPersion->id}}" onclick="sellerActive(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i></a>

                                            @endif

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

