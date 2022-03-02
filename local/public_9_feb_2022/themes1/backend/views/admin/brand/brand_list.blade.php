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
                    <h4 class="panel-title">BRANDS</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('addBrandLayout')}}"><i class="fas fa-lg fa-fw fa-plus-circle"></i>  Add New</a>
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
                                        <th class="text-nowrap">Image</th>
                                        <th class="text-nowrap">Brand</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @foreach($brandLists as $brandList)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td> <img id="output" src="{{($brandList->brand_img)? BASE_URL.ITEM_IMG_PATH.'/'.$brandList->brand_img : BACKEND.'img/product/default.jpg'}}"
                                            width="60px" height="40px"/></td>
                                        <td>{{$brandList->name}}</td>
                                        <td>{{$brandList->description}}</td>
                                        <td>{{date('d-m-Y', strtotime($brandList->created_at))}}</td>
                                        <td>
                                            <a href="{{route('editBrandLayout', $brandList->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            {{-- <a href="{{route('deleteBrand', $brandList->id)}}" class="btn btn-danger">Delete</a> --}}
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

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
