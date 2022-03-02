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
       
        <!-- begin col-8 -->
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">EDIT BRAND</h4>
                    <div class="panel-heading-btn">
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                   
                   
                    {{-- <div class="panel panel-inverse" data-sortable-id="form-stuff-12"> --}}
                    <div id="errorMsg" class="alert alert-block" style="display:none"></div>
                   
                    <div class="tab-content">

                    <form class="form-horizontal" id="updateBrand" method="post" action="{{route('updateBrand', $brand->id)}}" enctype="multipart/form-data">
                            @csrf
                    <input type="hidden" name="old_brand" value="{{$brand->brand_img}}">
                            <div class="row">
                                <div class="col-md-3 col-sm-8">

                                    <div class="form-group row m-b-15">
                                        <img id="output" src="{{($brand->brand_img)? BASE_URL.ITEM_IMG_PATH.'/'.$brand->brand_img : BACKEND.'img/product/default.jpg'}}" width="30%" height="25%"/>
                                    </div>

                                </div>
                                <div class="col-md-3 col-sm-8">

                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="brandImg">Brand image</label>
                                        
                                        <div class="col-md-12 col-sm-8">
                                            <input type="file" class="form-control @error('brand_img') is-invalid @enderror" accept="image/*" onchange="loadFile(event)" id="brandImg" accept="image/*" name="brand_img" data-parsley-required="true">
                                            
                                            
                                        </div>
                                        <div class="col-sm-12">
                                            <small class="impsize">File Size: Widht: 439px, Height: 299px</small>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-md-3 col-sm-8">


                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="barndNmae">Brand Name</label>
                                        
                                        <div class="col-md-12 col-sm-8">
                                        <input type="text" value="{{$brand->name}}" class="form-control @error('name') is-invalid @enderror" id="barndNmae" accept="image/*" name="name" placeholder="Required" data-parsley-required="true">
                                            
                                            
                                        </div>
                                        
                                        
                                    </div>

                                   
                                    
                                </div>
                                
                                <div class="col-md-3 col-sm-8">
                                    <div class="form-group row m-b-15">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="description">Brand Description</label>
                                        
                                        <div class="col-md-12 col-sm-8">
                                            <input type="textarea" class="form-control @error('description') is-invalid @enderror" id="description" value="{{$brand->description}}" name="description" placeholder="Description">
                                            
                                            
                                        </div>
                                        
                                        
                                    </div>

                                </div>

                                <div class="col-md-3 col-sm-8">
                                    <div class="row">
                                       
                                        <div class="col-md-12 col-sm-8">
                                            <fieldset>
                                                <button type="submit" id="submitBrandBtn" class="btn btn-success m-r-5 "><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
                                                <button type="reset" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
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