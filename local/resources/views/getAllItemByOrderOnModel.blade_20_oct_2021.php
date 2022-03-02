
<?php
                                    
//pr($itemOrders);
foreach($itemOrders as $itemOrder){
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

    if(@$itemOrder->is_Inprocess == 0){
        $status = 'Pending';
    }
    if(@$itemOrder->is_Inprocess == 1){
        $status = 'Inproces';
    }
    if(@$itemOrder->is_Inprocess == 2){
        $status = 'Partial';
    }
?>
    <tr>
                            
        <td class="value">
        <?php
           
        if(@$itemOrder->is_Inprocess != 1){
            
        ?>  
          
        <!-- <input type="checkbox" id="{{optional($item)->item_id}}" value="{{optional($item)->item_id}}" class="checkedGetBarcodeByItemId" name="checkedGetBarcodeByItemId"/> -->
        <input type="radio" id="{{optional($item)->item_id}}" onclick="checkedGetBarcodeByItemId({{optional($item)->item_id}})" value="{{optional($item)->item_id}}" class="checkedGetBarcodeByItemId" name="checkedGetBarcodeByItemId"/>
        
        <?php }?> 

        <img src="{{$itemImg}}" width="50px" height="50px">
        </td>
        <td class="value">{{optional($item)->product_name }}</td>
        <td class="value">{{optional($item)->set_of }}</td>
        <td class="value">{{optional($itemOrder)->quantity}}</td>
        <td class="value">{{optional($itemOrder)->unit}}</td>
        <td class="value">{{@$status}}</td>
        
    </tr>

<?php }?>


