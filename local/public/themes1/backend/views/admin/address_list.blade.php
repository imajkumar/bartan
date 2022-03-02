<!-- begin #content -->

<div id="content" class="content">
 

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ADDRESSES</h4>
                    <h4 class="panel-title"></h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-primary pull-right" href="{{route('addAddressLayout', $customer->id)}}" style="background-color:#0f0f0f;border: none;">Add Address</a>
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
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Name</th>
                                        {{-- <th class="text-nowrap">Company name</th> --}}
                                        {{-- <th class="text-nowrap">Phone</th> --}}
                                        <th class="text-nowrap">Street address</th>
                                        <th class="text-nowrap">Country</th>
                                        <th class="text-nowrap">State</th>
                                        <th class="text-nowrap">City</th>
                                        <th class="text-nowrap">Postal code</th>
                                        <th class="text-nowrap">Default address</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($addresses as $address)
                                    <tr>
                                        <td>{{$address->id}}</td>
                                        <td>{{ucfirst($address->f_name.' '.$address->l_name)}}</td>
                                        {{-- <td>{{$address->company_name}}</td> --}}
                                        {{-- <td>{{$address->phone}}</td> --}}
                                        <td>{{$address->street_address}}</td>
                                        <td>{{$address->country}}</td>
                                        <td>{{$address->state}}</td>
                                        <td>{{$address->city}}</td>
                                        <td>{{$address->postal_code}}</td>

                                        <td>
                                            @if($address->default_address == 1)
                                             <span class="badge badge-md badge-success">Yes</span>
                                             @else
                                             <span class="badge badge-md badge-danger">No</span>
                                             @endif
                                            
                                        </td>
                                        <td>
                                        <a href="{{route('editAddressLayout', $address->id)}}" class="btn btn-primary">Edit</a>
                                        {{-- <form method="post" action="{{route('deleteCustomer')}}" class="pull-right" id="deleteCustomer">
                                                @csrf()
                                               <input type="hidden" name="customer_id" value="{{$customer->id}}"/>
                                               <input class="btn btn-danger con" type="submit" value="Delete"/>
                                           </form> --}}
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                    </div>
                <!-- end col-8 -->

                
            </div>


        </div>
    </div>

</div>

