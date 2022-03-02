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
        <!-- begin col-4 -->
       
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">EDIT PAGE</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                   
                    <!-- end nav-tabs -->
                    <!-- begin tab-content -->
                    
                    <div id="errorMsg" class="alert alert-block" style="display:none"></div>
                    <!-- begin panel-heading -->
                   
                    <div class="tab-content">

                    <form class="form-horizontal" id="updatePage" method="post" action="{{route('updatePage', $page->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                
                                  <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Page Name<span class="required-star">* </span> :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <select disabled name="page_title1" id="page_title1"  class="form-control @error('page_title') is-invalid @enderror">

                                                <option value="">Select</option>
                                                <option value="faq" {{($page->page_title=='faq') ? "selected":""}}>FAQ</option>
                                                <option value="return_policy" {{($page->page_title=='return_policy') ? "selected":""}}>Return & Policy</option>
                                                <option value="privacy_policy" {{($page->page_title=='privacy_policy') ? "selected":""}}>Privacy & Policy</option>
                                                <option value="terms_of_use" {{($page->page_title=='terms_of_use') ? "selected":""}}>Terms Of Use</option>
                                        
                                            </select>
                                            <select hidden name="page_title" id="page_title"  class="form-control @error('page_title') is-invalid @enderror">

                                                <option value="">Select</option>
                                                <option value="faq" {{($page->page_title=='faq') ? "selected":""}}>FAQ</option>
                                                <option value="return_policy" {{($page->page_title=='return_policy') ? "selected":""}}>Return & Policy</option>
                                                <option value="privacy_policy" {{($page->page_title=='privacy_policy') ? "selected":""}}>Privacy & Policy</option>
                                                <option value="terms_of_use" {{($page->page_title=='terms_of_use') ? "selected":""}}>Terms Of Use</option>
                                        
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            
                           
                                
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Page Description :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <textarea class="ckeditor" id="page_desc" name="page_desc" rows="20">
                                               
                                            {{ $page->page_desc }}
                                                </textarea>
                                            
                                        </div>
                                    </div>

                                                                        <div class="row">
                            
                                
                                   
                                   
                                    
                                
                                    <!-- <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="size">Page Status :</label>
                                        <div class="col-md-12 col-sm-8">
                                            <select class="form-control @error('status') is-invalid @enderror" type="text" id="status" name="status">
                                                <option value="">Select Page Status</option>
                                              
                                               
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                               

                                            </select>
                                            
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                                <div class="col-md-3 col-sm-8">
                                    <div class="form-group">
                                        <label class="col-md-12 col-sm-4 col-form-label">&nbsp;</label>
                                        <div class="col-md-12 col-sm-8">
                                            <fieldset>
                                                <button type="submit" id="submitPageBtn" class="btn btn-sm btn-primary m-r-5 ">SAVE </button>
                                                <a href="{{route('pages')}}"><button type="button" class="btn btn-sm btn-default">Cancel</button></a>
                                            </fieldset>
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

<!-- end row -->
<script>
        CKEDITOR.replace('editor1');
</script>