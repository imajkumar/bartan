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
                    <h4 class="panel-title">New Product </h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <!-- begin col-12 -->
                        <div class="col-12">
                            <!-- begin panel -->
                            <?php
                            //$dataObjArr = getItemCategory();
                            $dataObjArr = getAllItemCategory();

                            ?>

                            <div class="panel-body">
                                <form method="post" action="{{route('saveItemSales')}}" class="form-horizontal" id="saveItemMasterSales" data-parsley-validate="true" name="saveItemMasterSales">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="name">Name <span class="required-star">* </span>:</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input class="form-control" type="text" id="name" name="item_name" placeholder="Enter product name" data-parsley-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="name">Category <span class="required-star">* </span>:</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3" id="itemCategory" name="itemCategory">
                                                        @foreach ($dataObjArr as $rowData)
                                                        <option value="{{$rowData->id}}">{{$rowData->item_name}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8">
                                            <fieldset style="margin-top:35px;">
                                                <input type="submit" id="submitItemBtn" value="SAVE" class="btn btn-sm btn-primary m-r-5 " />
                                                <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                                            </fieldset>

                                        </div>

                                    </div>
                                </form>

                                <!-- end row -->

                            </div>

                        </div>
                        <!-- end tab-pane -->



                    </div>

                </div>

                <!-- end row -->
                {{-- </div> --}}
                <!-- end #content -->