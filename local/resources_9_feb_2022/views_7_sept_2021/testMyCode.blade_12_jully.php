<?php
if(count($itemOrders)>0){
            $html = '';
            
                $i=0;
                foreach($itemOrders as $itemOrder){
                    
                    $itemOrder = (object) $itemOrder;
                    $item = get_item_detail($itemOrder->item_id);
                    $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)->first();
                    $itemImages = get_item_default_img_item_id($itemOrder->item_id);

					if($itemImages)
					{

						$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
					} else {

						$itemImg = FRONT.'img/product/product-iphone.png';
                    }

                    if(@$paymntStaus->status == 1)
                    {
                        $paymntStausVal ='<span class="badge badge-md badge-success">Success</span>';

                    }elseif(@$paymntStaus->status == 0){

                        $paymntStausVal ='<span class="badge badge-md badge-danger">Pending</span>';

                                    
                    }

                    if($itemOrder->stage == 1)
                    {
                        $stage = '<span class="badge badge-md badge-success">Processed</span>';

                    }elseif($itemOrder->stage == 0){

                        $stage = '<span class="badge badge-md badge-danger">Pending</span>';

                    }elseif($itemOrder->stage == 2){


                        $stage = '<span class="badge badge-md badge-danger">Packaging</span>';

                
                    }elseif($itemOrder->stage == 3){

                        $stage = '<span class="badge badge-md badge-danger">Shipping</span>';

                    
                    } elseif($itemOrder->stage == 4){

                    
                        $stage = '<span class="badge badge-md badge-danger">Delivered</span>';
                    
                    }elseif($itemOrder->stage == 5){

                        $stage = '<span class="badge badge-md badge-danger">Hold</span>';
                    
                    }elseif($itemOrder->stage == 6){

                        $stage = '<span class="badge badge-md badge-danger">Cancel</span>';

                    }else{
                        $stage = '<span class="badge badge-md badge-danger">Return</span>';
                
                    }

                    $itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();
                ?>  

                        <tr>
                            <td class="value">{{$itemOrder->order_id}}</td>
                            <td class="value">{{date("d-m-Y", strtoTime(@$paymntStaus->created_at))}}</td>
                          
                            <td class="value">{{$itemOrdersCount}}</td>
                            <!-- <td class="value">{{$itemOrder->total_amount}}</td> -->
                            <td class="value">{{$itemOrder->grand_total}}</td>
                            <td class="value">{!! $stage !!}</td>
                            
                            <td class="value">{!! $paymntStausVal !!}</td>
                            <td>
                                <?php 
                                    if(!empty(@$paymntStaus->saler_id)){
                                        echo "By sales person";
                                    }else{
                                        echo "By Customer";
                                    }
                                    
                                ?>
                            </td>

                            <td>
                            <?php 
                                if(!empty(@$paymntStaus->saler_id)){
                                    @$customer = DB::table('users')->where('id', @$paymntStaus->saler_id)->first();
                                    echo ucfirst(@$customer->name);
                                }else{
                                    @$customer = DB::table('users')->where('id', @$itemOrder->customer_id)->first();
                                    echo ucfirst(@$customer->name);
                                }
                            ?>
                            </td>
                            <td>
                            <a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-info" data-toggle="modal" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
								<a href="{{route('viewOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>
							</td>
                        </tr>

                <?php        
                $i++;   
                }
                
            }else{ ?>
             Recourd not found.
            <?php }?>