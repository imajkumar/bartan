<!-- begin #content -->
<!-- <style>
.modal-backdrop {
    position: inherit;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
</style> -->
<div id="content" class="content">


    <!-- begin row -->

    <div class="row">

        <div class="col-xl-12">

            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Transportation Master</h4>
                    <div class="panel-heading-btn">
                        {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}"
                        style="background-color:#0f0f0f;border: none;"><i
                            class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}}

                        <a href="#transportAddModel" data-toggle="modal" class="btn btn-success"><i
                                class="fa fa-plus" aria-hidden="true"></i> Add</a>

                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                            data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">

                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}



                        <table id="data-table-default"
                            class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>
                                    <th width="1%">ID</th>
                                    <th width="text-nowrap">Transporter Name</th>
                                    <th class="text-nowrap">Address</th>
                                    <th class="text-nowrap">Contact Person Name</th>

                                    <th class="text-nowrap">Phone Number</th>


                                    <th class="text-nowrap">Created date</th>
                                    <th class="text-nowrap">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                   
                                     foreach($transportMasters as $transportMaster){
                                     
                                        $transportMaster = (object) $transportMaster;
                                       
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrders);
                                            
                                        //if(count($itemOrders)>0){
                                    ?>
                                <tr>
                                    <td>{{$transportMaster->id}}</td>
                                    <td>{{ucfirst($transportMaster->transporter_name)}}</td>
                                    <td>{{$transportMaster->transporter_address}}</td>
                                    <td>{{$transportMaster->contact_person_name}}</td>
                                    <td>{{$transportMaster->phone_no}}</td>

                                    <td>
                                        {{date("d-m-Y", strtoTime($transportMaster->created_at))}}
                                    </td>





                                    <td>
                                        <!-- <a href="#transportAddModel" data-toggle="modal" class="btn btn-sm btn-primary m-r-5 m-b-5"><i class="fa fa-plus" aria-hidden="true"></i> Add</a> -->
                                        <a href="#transportEditModel"
                                            onclick="updateTransport({{$transportMaster->id}});" class="btn btn-default"
                                            data-toggle="modal" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                        <!-- <a href="{{route('viewOrderAdmin', $transportMaster->id)}}"
                                            class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>Delete</a> -->
                                    </td>
                                    <!-- <td> -->

                                    <!-- <a href="#updateOrderStage" id="{{$transportMaster->id}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                                            <a href="{{route('viewOrderAdmin', $transportMaster->id)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a> -->
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




    <!-- Start Add transpot model -->
    <div class="modal  popdgn" id="transportAddModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Transportation Master</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <form id="transportSaveForm" action="{{route('transportSaveForm')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">


                                <label class="col-form-label">Transporter Name</label>

                                <input type="text" class="form-control" name="transporter_name" id="transporter_name"
                                    placeholder="Transporter Name">

                            </div>

                            <div class="col-sm-12">

                                <label class="col-form-label">Address </label>

                                <!--   <input type="email" class="form-control m-b-5" placeholder="Docket Name"> -->

                                <textarea class="form-control" name="transporter_address" id="transporter_address"
                                    placeholder="Address"></textarea>


                            </div>
                            <div class="col-sm-12"></div>

                            <div class="col-sm-6">


                                <label class="col-form-label">Contact Person Name</label>

                                <input type="text" class="form-control" name="contact_person_name"
                                    id="contact_person_name" placeholder="Contact Person Name">

                            </div>

                            <div class="col-sm-6">


                                <label class="col-form-label">Phone Number</label>

                                <input type="text" class="form-control" name="phone_no" id="phone_no"
                                    placeholder="Phone Number" maxlength="10">

                            </div>

                            <div class="mt-3 ml-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            <!---->

                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End add transport model -->


    <!-- Start Edit transpot model -->
    <div class="modal  popdgn" id="transportEditModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Transportation Master</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <form id="transportUpdateForm" action="{{route('transportUpdateForm')}}" method="post">
                        @csrf
                        <input type="hidden" name="transport_id" id="transport_id" />

                        <div class="row">
                            <div class="col-sm-6">


                                <label class="col-form-label">Transporter Name</label>

                                <input type="text" class="form-control" name="transporter_name"
                                    id="edit_transporter_name" placeholder="Transporter Name">

                            </div>

                            <div class="col-sm-12">

                                <label class="col-form-label">Address </label>

                                <!--   <input type="email" class="form-control m-b-5" placeholder="Docket Name"> -->

                                <textarea class="form-control" name="transporter_address" id="edit_transporter_address"
                                    placeholder="Address"></textarea>


                            </div>
                            <div class="col-sm-12"></div>

                            <div class="col-sm-6">


                                <label class="col-form-label">Contact Person Name</label>

                                <input type="text" class="form-control" name="contact_person_name"
                                    id="edit_contact_person_name" placeholder="Contact Person Name">

                            </div>

                            <div class="col-sm-6">


                                <label class="col-form-label">Phone Number</label>

                                <input type="text" class="form-control" name="phone_no" id="edit_phone_no"
                                    placeholder="Phone Number" maxlength="10">

                            </div>

                            <div class="mt-3 ml-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            <!---->

                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End edit transport model -->