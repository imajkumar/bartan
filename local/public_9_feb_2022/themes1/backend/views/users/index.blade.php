<!-- begin #content -->

<div id="content" class="content">

  <!-- begin row -->

  <div class="row">

    <div class="col-xl-12">

      <div class="panel panel-inverse" data-sortable-id="tree-view-1">
        <div class="panel-heading">
          <h4 class="panel-title">Users</h4>
          <div class="panel-heading-btn">
            
          
          </div>
        </div>
        <div class="panel-body">

          <div class="tab-content">

            <!-- begin tab-pane -->
        



            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
              <thead>
                <tr>
                  <th width="1%">Id</th>

                  <th class="text-nowrap">Name</th>
                  <th class="text-nowrap">Email</th>
                  <th class="text-nowrap">Phone</th>
                  <th class="text-nowrap">Status</th>
                  <th class="text-nowrap">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php
                //$categories = getItemCategory();
                
                $usersArr = DB::table('users')->whereNotNull('name')->orderBy('id','asc')->get();

                ?>
                @foreach($usersArr as $rowData)
                <tr>
                  <td>{{$rowData->id}}</td>
                  <td>{{ucfirst($rowData->name)}}</td>
                  <td>{{$rowData->email}}</td>
                  <td>
                   
                    {{$rowData->mobile}}
                  </td>
                  <td>
                      @if($rowData->deleted_at == 1)
                          <span class="badge badge-md btn-success">Active</span>

                      @else
                          <span class="badge badge-md btn-danger">Deactive</span>

                      @endif
                  </td>

                  <td>
                     
                  
                      @if($rowData->deleted_at == 1)

                          <a href="javascript:void();" id="{{$rowData->id}}" onclick="userManagerDeactive(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i></a>
                      
                      @else
                          
                          <a href="javascript:void();" id="{{$rowData->id}}" onclick="userManagerActive(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i></a>

                      @endif
                  
                    <a href="{{route('users.edit',$rowData->id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>



                    {{-- <form method="post" action="{{route('deleteCustomer')}}" class="pull-right" id="deleteCustomer">
                    @csrf()
                    <input type="hidden" name="category_id" value="{{$users->id}}" />
                    <input class="btn btn-danger" type="submit" value="Delete" />
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