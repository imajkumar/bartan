<?php 
function getDateFormat()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getDateFormat(); 
}

function getUnderGroup()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getUnderGroup(); 
}


function getItemAttributes()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getItemAttributes(); 
}

function pr($arr)
{
    echo "<pre>";print_r($arr);exit;
    
}



function get_attribute_by_id($id)
{
    $attribute = DB::table('tbl_attributes')->where('id', $id)->first();
    
    return json_decode(json_encode($attribute), true);
}

function get_attributes()
{
    $attribute = DB::table('tbl_attributes')->get();
    
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_attributes_option_by_attr_id($attr_id)
{
    $attribute = DB::table('tbl_attribute_options')->where('attribute_id', $attr_id)->get();
    
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_itemAtributeOptions_by_option_id($option_id)
{
    
   $attribute = DB::table('tbl_item_attributes')->where('attr_option', $option_id)->first();
   //pr(json_decode(json_encode($attribute), true));
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_attribute_options_by_attribute_id($id)
{
    $attributeOptions = DB::table('tbl_attribute_options')->where('attribute_id', $id)->get();
    
    return $attributeOptions;
}

function get_categorys_by_item_id($item_id)
{
    $categories = DB::table('tbl_item_groups')->where('item_id', $item_id)->get();
    
    return $categories;
}

function get_categorys_by_g_id($g_id)
{
    $groups = DB::table('tbl_group')->where('g_id', $g_id)->first();
    
    return $groups;
}

function get_customer_and_address_by__user_id($user_id)
{
    
    $customerProfile = DB::table('tbl_customers')->where('user_id', $user_id)
    ->leftjoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')

    ->leftjoin('tbl_addresses','tbl_addresses.customer_id','=','tbl_customers.id')
    ->leftjoin('tbl_customer_documents','tbl_customer_documents.customer_id','=','tbl_customers.id')
    ->select('tbl_customers.id as cust_id','tbl_customers.*', 
    'tbl_addresses.id as address_id', 'tbl_addresses.*', 'tbl_businesses.*', 'tbl_customer_documents.id as docs_id', 'tbl_customer_documents.*')
    ->first();
    
    return $customerProfile;
}

function get_addresses_by_user_id($user_id)
{
    $customerAddresses = DB::table('tbl_addresses')->where('address_user_id', $user_id)->get();
    
    return $customerAddresses;
}

function get_businesses_by_user_id($user_id, $customer_id)
{
    $customerAddresses = DB::table('tbl_businesses')->where('address_user_id', $user_id)->get();
    
    return $customerAddresses;
}

function get_teams_by_customer_id($customer_id)
{
    $customerTeams = DB::table('tbl_teams')->where('customer_id', $customer_id)->get();
    
    return $customerTeams;
}

function get_custumer_by_user_id($user_id)
{
    $customerAddresses = DB::table('tbl_customers')->where('user_id', $user_id)->first();
    
    return $customerAddresses;
}

function get_user_by_user_id($user_id)
{
    $user = DB::table('users')->where('id', $user_id)->first();
    //pr(json_decode(json_encode($user), true));
    return json_decode(json_encode($user), true);
}

function get_unique_code()
{
    $today = date("Ymd");
    $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
     $unique = $today . $rand;
     return $unique;
}

