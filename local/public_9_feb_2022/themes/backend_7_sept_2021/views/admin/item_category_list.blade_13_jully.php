<!-- begin #content -->

<div id="content" class="content">
   
    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">CATEGORIES</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('addCategoryLayout')}}" style="border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a>
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 -->
                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Category name</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">Group</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                     //$categories = getItemCategory();
                                    $categories = getItemCategoryes();
                                    ?>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{ucfirst($category->item_name)}}</td>
                                        <td>{{$category->item_description}}</td>
                                        <td>
                                            <?php
                                                $group = get_group_by_g_id($category->item_under_group_id);
                                            ?>
                                            {{@$group->g_name}}
                                        </td>
                                        
                                        <td>
                                        <a href="{{route('itemCategoriesEdit', $category->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                       

                                           
                                            {{-- <form method="post" action="{{route('deleteCustomer')}}" class="pull-right" id="deleteCustomer">
                                                @csrf()
                                               <input type="hidden" name="category_id" value="{{$category->id}}"/>
                                               <input class="btn btn-danger" type="submit" value="Delete"/>
                                           </form> --}}
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

