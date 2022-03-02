<!-- begin #content -->

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <!-- <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
        <li class="breadcrumb-item active">Attributes</li>
    </ol>
  
    
    <h1 class="page-header">ATTRIBUTE<small>LIST</small></h1> -->

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">ATTRIBUTE</h4>
                    <div class="panel-heading-btn">
                        <a class="btn btn-success pull-right" href="{{route('addAttributeLayout')}}"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Add </a>
                      
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

                                        <th class="text-nowrap">Code</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Type</th>
                                        <!-- <th class="text-nowrap">Required</th>
                                        <th class="text-nowrap">Unique</th> -->
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attributes as $attribute)
                                    <tr>
                                        <td>{{$attribute->id}}</td>
                                       
                                        <td>{{$attribute->attribute_code}}</td>
                                        <td>{{$attribute->admin_name_lable}}</td>
                                        <td>{{$attribute->type}}</td>
                                        <!-- <td>{{($attribute->is_required == 1)? 'True':'False'}}</td>
                                        <td>{{($attribute->is_unique == 1)? 'True':'False'}}</td> -->
                                        <td>
                                        <a href="{{route('editAttributeLayout', $attribute->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            {{-- <form method="post" action="{{route('deleteAttribute')}}" class="pull-right" id="deleteCustomer">
                                                @csrf()
                                               <input type="hidden" name="customer_id" value="{{$attribute->id}}"/>
                                               <input class="btn btn-danger con" onclick="return confirm('Are you sure you want to remove this?');" type="submit" value="Delete"/>
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

