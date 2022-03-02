<div id="content" class="content">

    <div class="row">

        <div class="col-xl-12">

            <ul class="nav nav-tabs m-b-10">
                <li class="nav-item m-r-10">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Class discounts</span>
                        <span class="d-sm-block d-none">Class discounts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Category discounts</span>
                        <span class="d-sm-block d-none">Category discounts</span>
                    </a>
                </li>
                
            </ul>
            <div class="tab-content">

                <div class="tab-pane fade active show" id="default-tab-1">

                    <div id="disountClassHtmlEditForm"> </div>
                    <form action="{{route('saveClassDiscount')}}" method="post" class="" id="saveClassDiscount">
                       
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Customer type</label>
                                   <select  name="customer_type" id="customer_type" class="form-control">
                                   <option value="">Select customer type</option>
                                   <option value="1">Dealer</option>
                                   <option value="2">Wholesaller</option>
                                   <option value="3">Distibuter</option>
                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Customer class</label>
                                    <select  name="customer_class" id="customer_class" class="form-control">
                                    <option value="">Select Customer class</option>
                                       <?php
                                       $customerClasss = get_customer_classes();
                                       foreach($customerClasss as $customerClass){
                                       ?>
                                        <option value="{{ $customerClass->id }}">{{ $customerClass->cust_class_name }}</option>

                                       <?php }?>
                                   
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Item category</label>
                                   <select  name="item_cat" id="item_cat" class="form-control">
                                        <option value="">Select item category</option>
                                    <?php 
                                        $itemCategories = DB::table('tbl_item_category')->get();
                                        foreach($itemCategories as $itemCategorie){
                                    ?>
                                    <option value="{{$itemCategorie->id}}"> {{ get_group_category_cat_id($itemCategorie->id)}}</option>
                                     <!-- <option value="{{$itemCategorie->id}}">{{$itemCategorie->item_name}}</option> -->

                                    <?php }?>

                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Discount(%)</label>
                                    <input type="text" value="" class="form-control" name="discount_percentage" id="discount_percentage">
                                
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Applicable from</label>
                                    <input type="date" value="" class="form-control" name="applicable_from" id="applicable_from">
                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Expired on</label>
                                    <input type="date" value="" class="form-control" name="expired_on" id="expired_on">
                                
                                </div>
                            </div>
                            
                            
                        </div>


                        <fieldset>
                            <input type="submit" value="Save" class="btn btn-success m-b-10" />

                        </fieldset>
                        

                        <!-- volume settings  -->
                    </form>
                    <div class="table-responsive">
                    <table id="" class="table table-striped table-bordered table-td-valign-middle">
                    <!-- <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle"> -->
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Customer Type</th>
                                        <th class="text-nowrap">Customer Class</th>
                                        <th class="text-nowrap">Item Category</th>
                                        <th class="text-nowrap">Discount(%)</th>
                                        <th class="text-nowrap">Applicable from</th>
                                        <th class="text-nowrap">Expired on</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="appendClassDiscount">
                                    
                                <?php
                                    
                                    foreach($discountClassDatas as $discountClassData){
                                        $category = get_group_category_cat_id($discountClassData->item_cat);
                                        $customer_class = get_customer_class_by_id($discountClassData->customer_class);
                                        
                                        if ($discountClassData->customer_type == 1) {
                                            $customerType = 'Dealer';
                        
                                        }else if ($discountClassData->customer_type == 2) {
                                            $customerType = 'Wholesaller';
                        
                                        }else{
                                            $customerType = 'Distibuter';
                                        }
                                ?>
                                    <tr>
                                        
                                        <td>{{$discountClassData->id}}</td>
                                        <td>{{$customerType}}</td>
                                        <td>{{@$customer_class->cust_class_name}}</td>
                                            
                                        <td>{{@$category}}</td>
                                        <td>{{$discountClassData->discount_percentage}}</td>
                                        <td>{{date("d-m-Y", strtotime($discountClassData->applicable_from))}}</td>
                                        <td>{{date("d-m-Y", strtotime($discountClassData->expired_on))}}</td>
                                       
                                       
                                        <td>
                                            <a class="btn btn-default" id="{{$discountClassData->id}}" onclick="editClassDiscount(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <!-- <a class="btn btn-danger hellodel" id="{{$discountClassData->id}}" href="javascript:void();">Delete</a> -->
                                        </td>
                                       
                                    </tr>

                                <?php }?>

                                </tbody>
                            </table>
                            </div>

               </div>

                 <div class="tab-pane fade" id="default-tab-2">
                 <div id="disountCategoryHtmlEditForm"> </div>
                    <form action="{{route('saveCategoryDiscount')}}" method="post" class="" id="saveCategoryDiscount">
                       
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Customer category</label>
                                   <select  name="cat_class" id="cat_class" class="form-control">
                                         <option value="">Select customer category</option>
                                         <?php 
                                            $customerCategoryLists =  getCustomerCategoryList();
                                            foreach($customerCategoryLists as $customerCategoryList){
                                           
                                         ?>
                                         <option value="{{$customerCategoryList->id}}">{{$customerCategoryList->cust_category_name}}</option>
                                        
                                        <?php }?>
                                   </select>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Item category</label>
                                    <select  name="item_cat" id="item_cat" class="form-control">
                                        <option value="">Select item category</option>
                                    <?php 
                                        $itemCategories = DB::table('tbl_item_category')->get();
                                        foreach($itemCategories as $itemCategorie){
                                           
                                    ?>
                                     <option value="{{$itemCategorie->id}}"> {{ get_group_category_cat_id($itemCategorie->id)}}</option>
                                     <!-- <option value="{{$itemCategorie->id}}">{{$itemCategorie->item_name}}</option> -->

                                    <?php }?>

                                   </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Discount(%)</label>
                                    <input type="text" value="" class="form-control" name="discount_percentage" id="discount_percentage">
                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Applicable from</label>
                                    <input type="date" value="" class="form-control" name="applicable_from" id="applicable_from">
                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                            
                                    <label for="formGroupExampleInput2">Expired on</label>
                                    <input type="date" value="" class="form-control" name="expired_on" id="expired_on">
                                
                                </div>
                            </div>
                            
                            
                        </div>


                   
                        <fieldset>
                            <input type="submit" value="Save" class="btn btn-success m-b-10" />

                        </fieldset>

                        <!-- volume settings  -->
                    </form>

                    <table id="" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Customer Category</th>
                                        <th class="text-nowrap">Item category</th>
                                        <th class="text-nowrap">Discount(%)</th>
                                        <th class="text-nowrap">Applicable from</th>
                                        <th class="text-nowrap">Expired on</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="appendCategoryDiscount">
                                    <?php
                                    
                                        foreach($discountCategoryDatas as $discountCategoryData){
                                            $category = get_group_category_cat_id($discountCategoryData->item_cat);
                                            $customerCategory = getCustomerCategoryById(@$discountCategoryData->cat_class);
                                    ?>
                                        <tr>
                                            
                                            
                                            <td>{{$discountCategoryData->id}}</td>
                                            <td>{{@$customerCategory->cust_category_name}}</td>
                                            
                                            <td>{{$category}}</td>
                                            <td>{{$discountCategoryData->discount_percentage}}</td>
                                            <td>{{date("d-m-Y", strtotime($discountCategoryData->applicable_from))}}</td>
                                            <td>{{date("d-m-Y", strtotime($discountCategoryData->expired_on))}}</td>
                                            <td>
                                                <a class="btn btn-default" id="{{$discountCategoryData->id}}" onclick="editCategoryDiscount(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                                <!-- <a class="btn btn-danger" id="{{$discountCategoryData->id}}" onclick="deleteCategoryDiscount(this.id);" href="javascript:void(0);">Delete</a> -->
                                            </td>
                                           
                                            
                                        
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>

                </div>
               

            </div>


         </div>

    </div>

</div>


