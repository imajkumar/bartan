
<?php
                                    
                                    //pr($itemOrders);
                                    foreach($customerCarts as $itemOrder){
                                           //echo $itemOrder->item_id."<pre>";print_r($itemOrder);                                      
                                        $item = get_item_detail($itemOrder->item_id);
                                       // pr($item);
                                        $itemImages = get_item_default_img_item_id($itemOrder->item_id);
                                        
                                        if($itemImages)
                                        {
                                            
                                            $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                            
                                        } else {
                                            
                                            $itemImg = FRONT.'img/product/product-iphone.png';
                                        }
                                    ?>
                                        <tr>
                                                                
                                            <td class="value"><img src="{{$itemImg}}" width="50px" height="50px"></td>
                                            <td class="value">{{optional($item)->product_name }}</td>
                                            <td class="value">{{optional($itemOrder)->qty}}</td>
                                            <!-- <td class="value">{{optional($itemOrder)->unit}}</td> -->
                                            <!-- <td class="value">Inproces</td> -->
                                            
                                        </tr>
                                    
                                    <?php }?>