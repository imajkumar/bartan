<!-- begin #content -->

<div id="content" class="content">
   
    @if(Session::has('message-type'))
    
        <div class="alert alert-{{ Session::get('message-type') }}"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        {{ Session::get('message') }}
        </div>
    @endif

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">BANNERS</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('addBannerLayout')}}" style="border: none;"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Add New</a>
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        
                                        <th class="text-nowrap">Banner</th>
                                        <th class="text-nowrap">Banner title</th>
                                        <th class="text-nowrap">Banner description</th>
                                        <th class="text-nowrap">Button name</th>
                                        <th class="text-nowrap">Button link</th>
                                        <th class="text-nowrap">Size</th>
                                        
                                        {{-- <th class="text-nowrap">Item name</th> --}}
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        $bannerLists = get_bannerLists();
                                    foreach($bannerLists as $bannerList)
                                    {
                                        //echo $bannerList->item_id;
                                        
                                                //  echo "<pre>";print_r($item);
                                    ?>
                                    <tr>
                                        <td>{{$i++}}</td>
                                        
                                        <td> <img id="output" src="{{($bannerList->banner)? BASE_URL.ITEM_IMG_PATH.'/'.$bannerList->banner : BACKEND.'img/product/default.jpg'}}"
                                            width="60px" height="40px"/>
                                        </td>
                                        <td>{{$bannerList->banner_title}}</td>
                                        <td>{{\Str::limit(strip_tags($bannerList->banner_desc),100,'...')}}</td>
                                        <td>{{$bannerList->btn_name}}</td>
                                        <td>{{$bannerList->btn_link}}</td>
                                        <td>{{$bannerList->banner_size}}</td>
                                        {{-- <td>
                                           <?php
                                            $item = get_item_by_item_id(trim($bannerList->item_id)); 
                                                $items = json_decode(json_encode($item), true);
                                                
                                           ?>
                                             
                                               {{ucfirst($bannerList->item_name)}}

                                        </td> --}}
                                        <td>{{date('d-m-Y', strtotime($bannerList->created_at))}}</td>
                                        <td>
                                            @if($bannerList->status == 1)
                                            <span class="badge badge-md btn-success">Active</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Deactive</span>

                                            @endif
                                        </td>
                                        <td>
                                            @if($bannerList->status == 1)

                                                <a href="javascript:void();" id="{{$bannerList->id}}" onclick="bannerDeactive(this.id);" class="btn btn-danger m-b-10" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i></a>
                                            
                                            @else
                                                
                                                <a href="javascript:void();" id="{{$bannerList->id}}" onclick="bannerActive(this.id);" class="btn btn-success m-b-10" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw  icon-user-following"></i></a>

                                            @endif
                                            <a href="{{route('editBannerLayout', $bannerList->id)}}" class="btn btn-default m-b-10" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw  fa-edit"></i></a>
                                            {{-- <a href="{{route('deleteBanner', $bannerList->id)}}" class="btn btn-danger">Delete</a> --}}
                                            <a href="{{route('deleteBanner', $bannerList->id)}}" onclick="return confirm('Are you sure you want to remove this?');" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> </a>
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

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
