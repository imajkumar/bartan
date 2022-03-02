<div id="content" class="content">

    <?php
    $dataObjArr = getUnderGroup();

    ?>


    <div class="row">

        <div class="col-xl-12">

            <div class="panel panel-inverse" data-sortable-id="form-validation-1">

                <div class="panel-heading">
                    <h4 class="panel-title">ITEM CATEGORY</h4>
                    <div class="panel-heading-btn">

                      

                    </div>
                </div>


                <div class="panel-body">
                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('updateItemCategory')}}" id="saveItemCategory" name="saveItemCategory">
                    @csrf
                    <input type="hidden" name="item_cat_id" value="{{$category->id}}" />
                        <div class="row">
                              <div class="col-md-3 col-sm-6">
                            <label for="fullname">Category Name</label>
                          
                            <input class="form-control" type="text" id="item_category_name" name="item_category_name" value="{{$category->item_name}}" placeholder="Please enter category name" data-parsley-required="true">

                            </div>
                         <div class="col-md-3 col-sm-6">
                            <label for="email">Group</label>
                          
                                <select class="form-control mb-3" id="UnderGroup" name="UnderGroup">
                                    @foreach ($dataObjArr as $rowData)
                                    <option value="{{$rowData->g_id}}" {{($category->item_under_group_id == $rowData->g_id) ? 'selected':''}}>{{$rowData->g_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row">
                              <div class="col-md-8 col-sm-8">
                            <label for="message">Description (20 chars min, 200 max) :</label>
                          
                                <textarea class="form-control" id="message" name="message" rows="4">{{$category->item_description}}</textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="input_fields_wrap">

                        <?php
                       
                        //$attrArr = DB::table('tbl_item_category_child')->where('item_category_id', 1)->get();

                        foreach ($categoryAttributes as $key => $rowData) {
                        ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Attribute</label>
                                        <select class="form-control" id="attribute" name="attribute[]" placeholder="Please select attribute">
                                            <option value="">-SELECT-</option>
                                            <?php
                                            $attributes = get_attributes();
                                            foreach ($attributes as $attribute) {
                                            ?>

                                                <option <?php echo ($attribute['id'] == $rowData->item_attr_id ? 'selected' : ''); ?> value="{{$attribute['id']}}">{{$attribute['admin_name_lable']}}</option>

                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is required</label>
                                        <select class="form-control" id="is_required" name="is_required[]">
                                            <option value="">-SELECT-</option>
                                            <option <?php echo $rowData->is_required == "1" ? 'selected' : '' ?> value="1">Yes</option>
                                            <option <?php echo $rowData->is_required == "2" ? 'selected' : '' ?> value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is unique</label>
                                        <select class="form-control" id="is_unique" name="is_unique[]">
                                            <option value="">-SELECT-</option>
                                            <option <?php echo $rowData->is_unique == "1" ? 'selected' : '' ?> value="1">Yes</option>
                                            <option <?php echo $rowData->is_unique == "2" ? 'selected' : '' ?> value="2">No</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is comparable</label>
                                        <select class="form-control" id="is_comparable" name="is_comparable[]">
                                            <option value="">-SELECT-</option>
                                            <option <?php echo $rowData->is_compareable == "1" ? 'selected' : '' ?> value="1">Yes</option>
                                            <option <?php echo $rowData->is_compareable == "2" ? 'selected' : '' ?> value="2">No</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        
                                        <button  type="button" style="margin-top: 27px;" id="addCustomerBtn" class="btn btn-sm btn-danger m-r-5 remove_field_icat">X </button>

                                    </div>
                                </div>

                           

                            </div>
                        <?php
                        }
                        ?>

                         
                        </div>
                       <button class="btn btn-primary add_field_button pull-right mb-10">Add More</button>
                          <hr>            
                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        </fieldset>


                    </form>
                </div>

            </div>

        </div>
    </div>

</div>