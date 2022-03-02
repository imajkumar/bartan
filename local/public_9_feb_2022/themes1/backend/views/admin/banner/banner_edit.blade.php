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
        
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">EDIT BANNER</h4>
                    <div class="panel-heading-btn">
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                   
                    <!-- end nav-tabs -->
                    <!-- begin tab-content -->
                    {{-- <div class="panel panel-inverse" data-sortable-id="form-stuff-12"> --}}
                    <div id="errorMsg" class="alert alert-block" style="display:none"></div>
                    <!-- begin panel-heading -->
                    
                    <div class="tab-content">

                    <form class="form-horizontal" id="updateBanner" method="post" action="{{route('updateBanner', $banner->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-sm-8">

                                    <div class="form-group row m-b-15">
                                        <img id="output" src="{{($banner->banner)? BASE_URL.ITEM_IMG_PATH.'/'.$banner->banner : BACKEND.'img/product/default.jpg'}}" width="100%" height="25%"/>
                                    </div>

                                </div>

                                <div class="col-md-3 col-sm-8">

                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="banner">Banner* :</label>
                                        
                                        <div class="col-md-12 col-sm-8">
                                            <input type="file" class="form-control" accept="image/*" onchange="loadFile(event)" id="banner" accept="image/*" name="banner" placeholder="Required" data-parsley-required="true">
                                            <input type="hidden" name="old_banner" value="{{$banner->banner}}">
                                            
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>

                                <div class="col-md-3 col-sm-8">

                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="mobile_view_banner">Mobile View Banner :</label>
                                        
                                        <div class="col-md-12 col-sm-8">
                                            <input type="file" class="form-control" id="mobile_view_banner" accept="image/*" name="mobile_view_banner" placeholder="Required" data-parsley-required="true">
                                            <input type="hidden" name="old_mobile_view_banner" value="{{$banner->mobile_view_banner}}">
                                            
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>
                                
                                
                                <div class="col-md-3 col-sm-8">
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Size :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <select class="form-control @error('size') is-invalid @enderror" type="text" id="size" name="size" placeholder="Size">
                                                <option value="">Select Banner Size</option>

                                                @foreach($bannerSizes as $bannerSize)

                                                    <option value="{{$bannerSize->id}}" {{($banner->size == $bannerSize->id)? 'selected':''}}>{{$bannerSize->banner_size}}</option>
                                                @endforeach

                                            </select>
                                            
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="size">Banner Title :</label>
                                    <div class="col-md-12 col-sm-8">
                                    <input class="form-control" type="text" id="banner_title" value="{{$banner->banner_title}}" name="banner_title"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="size">Banner Description :</label>
                                    <div class="col-md-12 col-sm-8">
                                        <textarea class="ckeditor" id="editor1" name="banner_desc" rows="20">
                                            {!!$banner->banner_desc !!}
        
                                            </textarea>
                                        {{-- <input class="ckeditor" type="textarea" id="banner_desc" name="banner_desc" rows="20"/> --}}
                                    </div>
                                </div>
                               
                                    {{-- <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Banner Item :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <select class="form-control @error('item_id') is-invalid @enderror" type="text" id="item_id" name="item_id">
                                                <option value="">Select Banner Item</option>
                                                <?php
                                                
                                                    $items = get_items();
                                                ?>
                                                @foreach($items as $item)

                                                    <option value="{{$item->item_id}}" {{($item->item_id == $banner->item_id)? 'selected':''}}>{{$item->product_name}}</option>
                                                @endforeach

                                            </select>
                                            
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Button name :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <input class="form-control" type="text" id="btn_name" name="btn_name" value="{{$banner->btn_name}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Button link :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <input class="form-control" type="text" id="btn_link" name="btn_link" value="{{$banner->btn_link}}"/>
                                        </div>
                                    </div>
                                    
                                <div class="col-md-3 col-sm-8">
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Banner Status :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <select class="form-control @error('status') is-invalid @enderror" type="text" id="status" name="status">
                                                <option value="">Select Banner Status</option>
                                              
                                               
                                                    <option value="1" {{($banner->status=='1')? 'selected':''}}>Active</option>
                                                    <option value="0" {{($banner->status=='0')? 'selected':''}}>Deactive</option>
                                               

                                            </select>
                                            
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-3 col-sm-8">
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label">&nbsp;</label>
                                        <div class="col-md-12 col-sm-8">
                                            <fieldset>
                                                <button type="submit" id="updateBannerBtn" class="btn btn-success m-r-5 ">Save Changes</button>
                                                <button type="reset" class="btn btn-default">Cancel</button>
                                            </fieldset>
                                        </div>
                                    </div>
                                    
                                    
                                </div>


                        
                                
                            </form>

                       
                        
                    </div>
                    <!-- end tab-pane -->

                    

                </div>
                <!-- end col-8 -->
               
                
            </div>
            

        </div>
    </div>

</div>

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
        var output = document.getElementById('output');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };
    </script>