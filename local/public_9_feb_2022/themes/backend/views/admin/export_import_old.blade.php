

<div id="content" class="content">

@if(Session::has('message-type'))
    
    <div class="alert alert-{{ Session::get('message-type') }}"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    {{ Session::get('message') }}
    </div>
@endif
    <div class="row">

        <div class="col-xl-12">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Export</span>
                        <span class="d-sm-block d-none">Export</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Import</span>
                        <span class="d-sm-block d-none">Import</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Import</span>
                        <span class="d-sm-block d-none">Import New Item</span>
                    </a>
                </li>
                


            </ul>
            <div class="tab-content">

                <div class="tab-pane fade active show" id="default-tab-1">
                <a class="btn btn-success pull-right" href="{{route('exportItem')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export All</a>
                    <form action="{{route('exportItemBycolumn')}}" method="post" id="exportItemBycolumn">
                        
                        @csrf

                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item fields</label>
                                    <select class="form-control select2" id="itemcolum" name="itemcolum[]" multiple required>
                                    <?php 
                                     $table='tbl_items';
                                     $dbcArr= DB::getSchemaBuilder()->getColumnListing($table);
                                     $i=0;
                                     foreach ($dbcArr as $key => $row) {
                                         $i++;
                                         if($i==1){
                                            ?>
                                            <option selected value="{{$row}}">{{ucwords($row)}}</option>
                                          <?php
                                         }else{
                                            ?>
                                            <option value="{{$row}}">{{ucwords($row)}}</option>
                                          <?php
                                         }

                                     
                                     }
                                    ?>
                                    </select>

                                </div>

                            </div>
                             
                        </div>


                        
                        
                        
                          
                        
                        <!-- Stock and Selling -->
                        <!-- volume settings  -->
                       
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Export" id="Export" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        <!-- volume settings  -->
                    </form>

                </div>
                

                

                <div class="tab-pane fade" id="default-tab-3">
               

                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('itemImportForUpdate')}}" id="itemImport" name="itemImport" enctype="multipart/form-data">


                       
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item Import For Update</label>
                                   
                                    <input type="file" class="form-control" name="m_csvfile"/>
                                   
                                </div>

                            </div>

                        </div>

                        <!-- produt relation  -->

                        
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Import" id="itemImportUpdateBtn" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        

                        
                    </form>

                   

                    <!-- produt relation  -->

                </div>
              
                <div class="tab-pane fade" id="default-tab-4">
                <a class="btn btn-success pull-right" href="{{asset('/gallery/ItemImportTemplate.csv')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export Sample For Import</a>

                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('newItemImport')}}" id="newItemImport" name="newItemImport" enctype="multipart/form-data">


                       
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item Import</label>
                                   
                                    <input type="file" class="form-control" name="m_csvfile" id="m_csvfile"/>
                                    <!-- <input type="checkbox" class="form-control" name="importUpdate" id="importUpdate"/> -->
                                </div>

                            </div>

                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label >Update existing item</label>
                                   
                                   
                                    <input type="checkbox" class="form-control" name="importUpdate" value="1" id="importUpdate"/>
                                </div>

                            </div> -->

                            

                            
                             
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Category</label>
                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                       <?php 
                                       $dataObjArr = getAllItemCategory();
                                        ?>
                                       @foreach ($dataObjArr as $rowData)
                                       <option value="{{$rowData->id}}">{{$rowData->item_name}}</option>
                                       @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id" required>
                                       <?php 
                                       $brands = DB::table('tbl_brands')->get();
                                        
                                       ?>
                                       @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" >{{ucwords($brand->name)}}</option>
                                        @endforeach
                                      
                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Product is visible</label>
                                    <select class="form-control" id="is_visible" name="is_visible" data-parsley-required="true">

                                        <option value="1">YES</option>
                                        <option value="2">NO</option>

                                    </select>

                                </div>

                            </div>

                        </div>
                        <!-- produt relation  -->

                        
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Import" id="itemImportBtn" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        

                        
                    </form>

                   

                    <!-- produt relation  -->

                </div>
                
               





            </div>










        </div>




    </div>

</div>