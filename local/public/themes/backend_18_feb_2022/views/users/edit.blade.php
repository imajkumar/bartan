<!-- begin #content -->

<div id="content" class="content">

    <!-- begin row -->

    <div class="row">

        <div class="col-xl-12">

            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Users Edit</h4>
                    <div class="panel-heading-btn">


                    </div>
                </div>
                <div class="panel-body">

                    <div class="tab-content">

                        <!-- begin tab-pane -->

                        <!-- {{$users->name}}
                        <br>
                        {{$users->email}} -->
                        <?php 
                       // echo "<pre>";
                        
                        //  if (Auth::user()->hasPermissionTo('attributeView')) {
                        //     echo "Yes";
                        // } else {
                        //     echo "No";
                        // }

                        ?>

                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                        @endif

                        <form action="{{route('saveUserPermission')}}" method="post">
                            @csrf
                            <input type="hidden" name="userID" value="{{$users->id}}">
                            <?php
                            $permissions = DB::table('permissions')
                                ->get();
                            
                                
                            // echo $users->id;
                            // pr($permissions);

                            foreach ($permissions as $key => $rowData) {
                                if($rowData->id != 2 && $rowData->id != 21){
                                $hasPermission = DB::table('model_has_permissions')
                                ->where('permission_id', $rowData->id)
                                ->where('model_id', $users->id)
                                ->first();
                            ?>
                                <div class="checkbox checkbox-css">
                                    <input type="checkbox" {{(!empty($hasPermission)) ? 'checked':''}} value="{{$rowData->id}}" id="cssCheckbox{{$rowData->id}}" name="userPermisson[]" />
                                    <label for="cssCheckbox{{$rowData->id}}">{{$rowData->perm_name}}</label>
                                </div>
                            <?php
                            }}

                            ?>
                            <div class="form-group row">
                                <div class="col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
                                    <a href="{{route('users.index')}}" class="btn btn-sm btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>







                    </div>
                    <!-- end col-8 -->


                </div>


            </div>
        </div>

    </div>