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
                    <h4 class="panel-title">ADD USER</h4>
                    <div class="panel-heading-btn">
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                   
                   
                    
                    <div id="errorMsg" class="alert alert-block" style="display:none"></div>
                   
                    <div class="tab-content">

                    <form id="saveUser" action="{{route('saveUser')}}" method="post">
                       @csrf
                       <div class="row">
                            <div class="col-sm-4">


                                <label class="col-form-label">Name</label>

                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">

                            </div>

                            
                            <!-- <div class="col-sm-12"></div> -->

                            <div class="col-sm-4">


                                <label class="col-form-label">Email</label>

                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">

                            </div>

                            <div class="col-sm-4">


                                <label class="col-form-label">Mobile Number</label>

                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" maxlength="10">

                            </div>
                        
                            <div class="col-sm-4">


                                <label class="col-form-label">Password</label>

                                <input type="text" class="form-control" name="password" id="password" placeholder="Password">

                            </div>
                            
                            <div class="mt-3 ml-3">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            <!---->
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

<!-- end #content -->
