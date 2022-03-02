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

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>


                <div class="panel-body">
                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('saveItemCategory')}}" id="saveItemCategory" name="saveItemCategory">
                    @csrf

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Category Name * :</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" type="text" id="item_category_name" name="item_category_name" placeholder="Please enter category name" data-parsley-required="true">

                            </div>
                        </div>
                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="email">Group * :</label>
                            <div class="col-md-8 col-sm-8">
                                <select class="form-control mb-3" id="UnderGroup" name="UnderGroup">
                                    @foreach ($dataObjArr as $rowData)
                                    <option value="{{$rowData->g_id}}">{{$rowData->g_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="message">Description (20 chars min, 200 max) :</label>
                            <div class="col-md-8 col-sm-8">
                                <textarea class="form-control" id="message" name="message" rows="4"  placeholder="Description"></textarea>
                            </div>
                        </div>
                        <hr>




                        <div class="input_fields_wrap">
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

                                                <option value="{{$attribute['id']}}">{{$attribute['admin_name_lable']}}</option>

                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is required</label>
                                        <select class="form-control" id="is_required" name="is_required[]">
                                            <option value="">-SELECT-</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is unique</label>
                                        <select class="form-control" id="is_unique" name="is_unique[]">
                                            <option value="">-SELECT-</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Is comparable</label>
                                        <select class="form-control" id="is_comparable" name="is_comparable[]">
                                            <option value="">-SELECT-</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        
                                        <button type="button" style="margin-top: 27px;" id="addCustomerBtn" class="btn btn-sm btn-danger m-r-5 remove_field_icat">X </button>

                                    </div>
                                </div>




                            </div>
                        </div>
                        <button class="btn btn-primary add_field_button">Add More</button>
                         <hr>                       
                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                            <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                        </fieldset>


                    </form>
                </div>

            </div>

        </div>
    </div>

</div>