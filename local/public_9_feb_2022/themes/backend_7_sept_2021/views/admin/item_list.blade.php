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
<!-- begin #content -->

<div id="content" class="content">
   
    <!-- begin row -->
    
    <div class="row">
        <!-- begin col-4 -->
        {{-- <div class="col-xl-4">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Group Tree</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    
                   
                </div>
            </div>
            <!-- end panel -->
        </div> --}}
        <!-- end col-4 -->
        <!-- begin col-8 -->
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ITEMS</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('itemMasterLayout')}}"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Add New</a>
                        <a class="btn btn-success pull-right" href="{{route('exportItem')}}"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Export Item</a>
                 <!--        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        

                        <!--     {{-- <table id="grid1"></table> --}} -->
                        <div class="table-responsive">
                            <table id="datatable_example" class="table table-striped table-bordered table-td-valign-middle display">
                            <!-- <table id="datatable_example" class="display" width="100%" cellspacing="0"> -->
                                <thead>
                                    <tr>
                                        <th width="1%"></th>

                                        <th class="text-nowrap">Image</th>
                                        <th class="text-nowrap">Item name</th>
                                        
                                        <th class="text-nowrap">Item category</th>
                                        
                                        <th class="text-nowrap">Brand name</th>

                                         <th class="text-nowrap">Regular price</th>
                                         <th class="text-nowrap">Open quantity</th>
                                        <th class="text-nowrap">Min quantity</th>
                                        <th class="text-nowrap">Status</th>  
                                        <th class="text-nowrap">Action</th>
                                       
                                    </tr>
                                </thead>
                            </table>

                           
                        </div>

                        

                </div>
                <!-- end col-8 -->

                
            </div>


        </div>
    </div>

</div>


<!-- end row -->

<!-- end #content -->




<div class="modal fade" id="modal-alert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alert Header</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert m-b-0">
                    <h5><i class="fa fa-info-circle"></i> Item image</h5>
                    <div id="dropzone">
                        <form action="http://localhost/ecom_v1/api/add-new-img/13" class="dropzone needsclick" id="dropZoneForm">
                            @csrf
                            <div class="dz-message needsclick">
                                Drop files <b>here</b> or <b>click</b> to upload.<br />
                                <span class="dz-note needsclick">
                                    (This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a>
            </div>
        </div>
    </div>
</div>
