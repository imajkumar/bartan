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

                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>

                                        <th class="text-nowrap">Image</th>
                                        <th class="text-nowrap">Item name</th>
                                        <!-- <th class="text-nowrap">Item description</th> -->
                                        <th class="text-nowrap">Item category</th>
                                        {{-- <th class="text-nowrap">Categorys name</th> --}}
                                        <th class="text-nowrap">Brand name</th>
                                        <th class="text-nowrap">Sale price</th>
                                        <th class="text-nowrap">Regular price</th>
                                        <th class="text-nowrap">Open quantity</th>
                                        <th class="text-nowrap">Min quantity</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>


                                    </tr>
                                </thead>
                                <tbody id="itemDataAppend">
                                    <?php $i = 1;
                                    foreach ($dataObjArr as $itemData) { ?>
                                        <tr class="odd gradeX">
                                            <td width="1%" class="f-s-600 text-inverse">{{$i++}}</td>

                                            <td>
                                                @if($itemData->img_name && $itemData->default==1)
                                                    <img src="{{BASE_URL.ITEM_IMG_PATH.'/'.$itemData->img_name}}" width="50px" height="50px"/>
                                                @else

                                                 <img src="{{BACKEND.'img/product/default.jpg'}}" width="50px" height="50px"/>
                                                @endif
                                            <a href="#modal-alert_{{$itemData->item_id}}" id="{{$itemData->item_id}}" class="addItemDropzoneImg" data-toggle="modal">Add image</a>
                                                {{-- <a href="{{route('addGalleryImage', $itemData->item_id)}}" id="addImageModelAjax" value="{{$itemData->item_id}}">Add image</a></td> --}}
                                            <td>{{$itemData->item_name}}</td>
                                            <!-- <td>{{\Str::limit(strip_tags($itemData->description),200,'...')}}</td> -->
                                            <td>{{get_group_category_cat_id($itemData->cat_id)}}</td>
                                            {{-- <?php
                                                // $categoryes = get_categorys_by_item_id($itemData->item_id);
                                                // foreach($categoryes as $categorye){
                                                //     $grouName = get_categorys_by_g_id($categorye->g_id);
                                                //     $categori = $grouName->
                                                // }
                                            ?> --}}
                                            {{-- <td>{{$itemData->g_name}}</td> --}}
                                            <td>{{$itemData->brandName}}</td>
                                            <td>{{$itemData->sale_price}}</td>
                                            <td>{{$itemData->regular_price}}</td>
                                            <td>{{$itemData->invt_unit}}</td>
                                            <td>{{$itemData->item_invt_min_order}}</td>
                                            <td>
                                                @if($itemData->is_visible == 1)
                                                    <span class="badge badge-md badge-success">Active</span>

                                                @else
                                                    <span class="badge badge-md badge-danger">Deactive</span>

                                                @endif
                                               
                                            </td>
                                            <td>
                                                @if($itemData->is_visible == 1)

                                                    <a href="javascript:void();" id="{{$itemData->item_id}}" onclick="itemDeactive(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i></a>
                                            
                                                @else
                                                
                                                    <a href="javascript:void();" id="{{$itemData->item_id}}" onclick="itemActive(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i></a>

                                                @endif

                                                <a class="btn btn-default" href="{{route('itemEditLayout',$itemData->item_id)}}" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            </td>
                                        </tr>



                                        <div class="modal fade" id="modal-alert_{{$itemData->item_id}}" style="display: none;" aria-hidden="true">
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
                                                                <form action="{{route('addGalleryImageA', $itemData->item_id)}}" class="dropzone needsclick">
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
                                                        {{-- <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Action</a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </tbody>
                            </table>

                         </div>

                        

                </div>
                <!-- end col-8 -->

                
            </div>


        </div>
    </div>

</div>


<!-- end row -->
{{-- </div> --}}
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
