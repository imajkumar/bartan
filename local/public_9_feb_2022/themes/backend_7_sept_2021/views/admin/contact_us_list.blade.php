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
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Contact us</h4>
                    <div class="panel-heading-btn">
                        {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}}
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        <th class="text-nowrap">Mobile No.</th>

                                        <th class="text-nowrap">Subject</th>
                                        <th class="text-nowrap">Message</th>
                                      
                                        <th class="text-nowrap">Date</th>
                                        <!-- <th class="text-nowrap">Action</th> -->
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   
                                     foreach($contacts as $contact){
                                     
                                        $contact = (object) $contact;
                                       
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrders);
                                            
                                        //if(count($itemOrders)>0){
                                    ?>
                                    <tr>
                                        <td>{{ucfirst($contact->name)}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->mobile_no}}</td>
                                        <td>{{$contact->subject}}</td>
                                        <td>{{$contact->message}}</td>
                                        <td>
                                            {{date("d-m-Y", strtoTime($contact->created_at))}}
                                        </td>
                                        
                                      
                                   
                                       
                                       
                                        
                                        
                                       
                                        

                                        <!-- <td> -->
                                           
                                            <!-- <a href="#updateOrderStage" id="{{$contact->id}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                                            <a href="{{route('viewOrderAdmin', $contact->id)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a> -->
                                        <!-- </td> -->
                                       
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

