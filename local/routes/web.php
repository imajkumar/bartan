<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['register' => false]);
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::post('/customerLogout', 'auth\LoginController@customerLogout')->name('customerLogout');
Route::post('/salesLogout', 'auth\LoginController@salesLogout')->name('salesLogout');
// Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard')->middleware('logoutAfterSomeDays');


Route::get('/logout', function(){
    Auth::logout();
    session()->forget('customer');
    session()->forget('sales');
    \Cache::forget('salesLogoutAfterSomeDays');
    \Cache::forget('logoutSomeDays');
    \Cache::forget('AdminLogoutAfterSomeDays');
    return redirect('/');
});

// ->middleware('IsAdminLogin');
Route::group(['middleware' => ['auth','IsAdminLogin']], function() {
  Route::resource('roles','RoleController');
  Route::resource('users','UserController');
  

  Route::post('/saveUserPermission', 'UserController@saveUserPermission')->name('saveUserPermission');
  Route::post('/setMinimumOrderForAllCustomer', 'UserController@setMinimumOrderForAllCustomer')->name('setMinimumOrderForAllCustomer');

  
Route::resource('permissions', 'PermissionController');
  //Route::resource('products','ProductController');
});


Route::get('/clearme', 'HomeController@clearMe')->name('clearme');

Route::post('/itemImportForUpdateAttr', 'UserController@itemImportForUpdateAttr')->name('itemImportForUpdateAttr');
Route::get('/exportAttrForColumn', 'UserController@exportAttrForColumn')->name('exportAttrForColumn');

Route::get('/createUser', 'UserController@createUser')->name('createUser');
Route::post('/saveUser', 'UserController@saveUser')->name('saveUser');

Route::get('testOr', 'PaymentController@testOrder')->name('testOrder');

Route::get('/export', 'UserController@export')->name('export');
Route::get('/exportItem', 'UserController@exportItem')->name('exportItem');

Route::get('/exportItemOrder', 'UserController@exportItemOrder')->name('exportItemOrder');



Route::get('/exportCustomer', 'UserController@exportCustomer')->name('exportCustomer');

Route::post('/exportItemBycolumn', 'UserController@exportItemBycolumn')->name('exportItemBycolumn');
Route::post('/itemImportForUpdate', 'UserController@itemImportForUpdate')->name('itemImportForUpdate');
Route::post('/newItemImport', 'UserController@newItemImport')->name('newItemImport');

Route::get('/createAdminTast', 'UserController@createAdminTast')->name('createAdminTast');
Route::get('/customer-wise-brand', 'UserController@customerWiseBrand')->name('customerWiseBrand');

/*
  |--------------------------------------------------------------------------
  |         *************  START CART SYSTEM ****************
  |--------------------------------------------------------------------------
*/

Route::post('/setAddToCart', 'CartController@setAddToCart')->name('setAddToCart');
Route::post('/setIncreseQTY', 'CartController@setIncreseQTY')->name('setIncreseQTY');
Route::post('/increseQTYOnKeyPress', 'CartController@increseQTYOnKeyPress')->name('increseQTYOnKeyPress');
Route::post('/setDecreaseQTY', 'CartController@setDecreaseQTY')->name('setDecreaseQTY');

Route::group(['middleware' => 'prevent-back-history'],function(){
  Route::get('/view-cart', 'CartController@view_cart')->name('view_cart');
});

Route::get('/view-cart/{customer_id}', 'CartController@view_cart_customer')->name('view_cart_customer');

Route::post('/removeItemFromCart', 'CartController@removeItemFromCart')->name('removeItemFromCart');
Route::post('/removeItemFromCartSales', 'CartController@removeItemFromCartSales')->name('removeItemFromCartSales');



/*
  |--------------------------------------------------------------------------
  |         *************  START ADMIN ****************
  |--------------------------------------------------------------------------
*/


//Sales item start 
Route::get('/item-master-sales', 'SalesPersionController@itemMasterLayoutSales')->name('itemMasterLayoutSales');
Route::get('/items-sales', 'SalesPersionController@itemListLayoutSales')->name('itemListLayoutSales');
Route::get('/item-edit-sales/{item_id}', 'SalesPersionController@itemEditLayoutSales')->name('itemEditLayoutSales');

Route::post('/update-item-sales/{item_id}', 'SalesPersionController@updateItemSales')->name('updateItemSales');

Route::post('deleteItemImgByAjaxSales', 'SalesPersionController@deleteItemImgByAjaxSales')->name('deleteItemImgByAjaxSales');
Route::post('addPrimaryImgByAjaxSales', 'SalesPersionController@addPrimaryImgByAjaxSales')->name('addPrimaryImgByAjaxSales');
Route::get('/get_attributesSales', 'SalesPersionController@get_attributesSales')->name('get_attributesSales');
Route::post('/getAttributeOptionsSales', 'SalesPersionController@getAttributeOptionsSales')->name('getAttributeOptionsSales');

Route::post('/saveItemSales', 'SalesPersionController@saveItemSales')->name('saveItemSales');
Route::get('/getItembyAjaxSales', 'SalesPersionController@getItembyAjaxSales')->name('getItembyAjaxSales');

Route::post('/saveChangesProductDetailsSales', 'SalesPersionController@saveChangesProductDetailsSales')->name('saveChangesProductDetailsSales');
Route::post('/saveChangesProductAttribueSales', 'SalesPersionController@saveChangesProductAttribueSales')->name('saveChangesProductAttribueSales');

Route::post('/getAjaxAttriubeByCatIDSales', 'SalesPersionController@getAjaxAttriubeByCatIDSales')->name('getAjaxAttriubeByCatIDSales');
Route::post('/getAjaxSelectedAttributeValueSales', 'SalesPersionController@getAjaxSelectedAttributeValueSales')->name('getAjaxSelectedAttributeValueSales');

Route::post('/saveChangesProductRelationSales', 'SalesPersionController@saveChangesProductRelationSales')->name('saveChangesProductRelationSales');
Route::post('/saveChangesProductTaxationSales', 'SalesPersionController@saveChangesProductTaxationSales')->name('saveChangesProductTaxationSales');
Route::post('/deleteItemAttrOptionSales', 'SalesPersionController@deleteItemAttrOptionSales')->name('deleteItemAttrOptionSales');

Route::post('/itemActiveSales', 'SalesPersionController@itemActiveSales')->name('itemActiveSales');
Route::post('/itemDeactiveSales', 'SalesPersionController@itemDeactiveSales')->name('itemDeactiveSales');

//End Sales Item

Route::get('/master-settings', 'UserController@masterSettingsLayout')->name('masterSettingsLayout');
Route::get('/editMasterGroup', 'UserController@editMasterGroup')->name('editMasterGroup');
Route::get('/item-master', 'UserController@itemMasterLayout')->name('itemMasterLayout');
Route::get('/items', 'UserController@itemListLayout')->name('itemListLayout');
Route::get('/item-edit/{item_id}', 'UserController@itemEditLayout')->name('itemEditLayout');
Route::post('/update-item/{item_id}', 'UserController@updateItem')->name('updateItem');
Route::post('deleteItemImgByAjax', 'UserController@deleteItemImgByAjax')->name('deleteItemImgByAjax');
Route::post('addPrimaryImgByAjax', 'UserController@addPrimaryImgByAjax')->name('addPrimaryImgByAjax');
Route::get('/get_attributes', 'UserController@get_attributes')->name('get_attributes');
Route::post('/getAttributeOptions', 'UserController@getAttributeOptions')->name('getAttributeOptions');

Route::post('/saveItem', 'UserController@saveItem')->name('saveItem');
Route::get('/getItembyAjax', 'UserController@getItembyAjax')->name('getItembyAjax');

Route::Post('/deleteMasterGroup', 'UserController@deleteMasterGroup')->name('deleteMasterGroup'); 

Route::Post('/updateMasterGroup', 'UserController@updateMasterGroup')->name('updateMasterGroup'); 
Route::Post('/saveMasterGroup', 'UserController@saveMasterGroup')->name('saveMasterGroup'); 

Route::Post('/saveGroupAttribute', 'UserController@saveGroupAttribute')->name('saveGroupAttribute'); 
Route::Post('/saveAttributeValue', 'UserController@saveAttributeValue')->name('saveAttributeValue'); 
Route::get('/addGalleryImage/{item_id}', 'UserController@addGalleryImage')->name('addGalleryImage'); 



Route::post('/checkUniBarcode', 'UserController@checkUniBarcode')->name('checkUniBarcode');
Route::post('/uploadGalleryImage', 'UserController@uploadGalleryImage')->name('uploadGalleryImage');

Route::Post('/getTreeView', 'UserController@getTreeView')->name('getTreeView'); 
Route::Post('/getTreeViewFrEdit', 'UserController@getTreeViewFrEdit')->name('getTreeViewFrEdit'); 
Route::Post('/saveAttribute', 'UserController@saveAttribute')->name('saveAttribute'); 
Route::get('/customers', 'UserController@customerListLayout')->name('customerListLayout')->middleware('IsAdminLogin'); 

Route::get('/customers/{id}/addresses', 'UserController@addressListLayout')->name('addressListLayout');
Route::get('/customers/{id}/addresses/create', 'UserController@addAddressLayout')->name('addAddressLayout');
Route::get('/customers/addresses/edit/{id}', 'UserController@editAddressLayout')->name('editAddressLayout');
Route::post('/updateAddress', 'UserController@updateAddress')->name('updateAddress');
Route::post('/addAddress', 'UserController@addAddress')->name('addAddress');
Route::post('/itemActive', 'UserController@itemActive')->name('itemActive');
Route::post('/itemDeactive', 'UserController@itemDeactive')->name('itemDeactive');

Route::get('/itemCategories', 'UserController@itemCategories')->name('itemCategories')->middleware('IsAdminLogin');
Route::get('/itemCategories-edit/{itemCateID}', 'UserController@itemCategoriesEdit')->name('itemCategoriesEdit');

Route::get('/add-categoryLayout', 'UserController@addCategoryLayout')->name('addCategoryLayout');
Route::post('/addCategoryLayout', 'UserController@addCategory')->name('addCategory');

Route::get('/add-new-customer', 'UserController@addNewCustomerLayout')->name('addNewCustomerLayout'); 
Route::get('/attributesLayout', 'UserController@attributesLayout')->name('attributesLayout'); 
Route::get('/addAttributeLayout', 'UserController@addAttributeLayout')->name('addAttributeLayout'); 
Route::post('/addAttribute', 'UserController@addAttribute')->name('addAttribute'); 
Route::get('/editAttributeLayout/{id}', 'UserController@editAttributeLayout')->name('editAttributeLayout'); 
Route::post('/updateAttribute', 'UserController@updateAttribute')->name('updateAttribute');

Route::get('/attributeFamiliesLayout', 'UserController@attributeFamiliesLayout')->name('attributeFamiliesLayout'); 
Route::get('/addAttrFamilyLayout', 'UserController@addAttrFamilyLayout')->name('addAttrFamilyLayout'); 
Route::get('/editAttributeFamilyLayout/{id}', 'UserController@editAttributeFamilyLayout')->name('editAttributeFamilyLayout'); 
Route::post('/addAttributeFamily', 'UserController@addAttributeFamily')->name('addAttributeFamily'); 
Route::post('/updateAttributeFamily', 'UserController@updateAttributeFamily')->name('updateAttributeFamily'); 

Route::post('/add-new-customer', 'UserController@addNewCustomer')->name('addNewCustomer'); 
Route::get('/edit-customer/{id}', 'UserController@editCustomerLayout')->name('editCustomerLayout'); 
Route::post('/update-customer', 'UserController@updateCustomer')->name('updateCustomer'); 
Route::post('/saveCustomerApproval', 'UserController@saveCustomerApproval')->name('saveCustomerApproval'); 
Route::post('/delete-customer', 'UserController@deleteCustomer')->name('deleteCustomer'); 

Route::get('/banners', 'UserController@bannerListLayout')->name('bannerListLayout'); 
Route::get('/add-banner', 'UserController@addBannerLayout')->name('addBannerLayout');
Route::post('/save-banner', 'UserController@saveBanner')->name('saveBanner');
Route::get('/edit-banner/{id}', 'UserController@editBannerLayout')->name('editBannerLayout');
Route::post('/update-banner/{id}', 'UserController@updateBanner')->name('updateBanner');
Route::get('/delete-banner/{id}', 'UserController@deleteBanner')->name('deleteBanner');

Route::get('/brands', 'UserController@brandListLayout')->name('brandListLayout'); 
Route::get('/add-brand', 'UserController@addBrandLayout')->name('addBrandLayout');
Route::post('/save-brand', 'UserController@saveBrand')->name('saveBrand');
Route::get('/edit-brand/{id}', 'UserController@editBrandLayout')->name('editBrandLayout');
Route::post('/update-brand/{id}', 'UserController@updateBrand')->name('updateBrand');
Route::get('/delete-brand/{id}', 'UserController@deleteBrand')->name('deleteBrand');

Route::post('/customerDeactive', 'UserController@customerDeactive')->name('customerDeactive');
Route::post('/userManagerDeactive', 'UserController@userManagerDeactive')->name('userManagerDeactive');

Route::post('/bannerActive', 'UserController@bannerActive')->name('bannerActive');
Route::post('/bannerDeactive', 'UserController@bannerDeactive')->name('bannerDeactive');
Route::post('/customerActive', 'UserController@customerActive')->name('customerActive');

Route::post('/userManagerActive', 'UserController@userManagerActive')->name('userManagerActive');

Route::post('/statesByCountry', 'UserController@statesByCountry')->name('statesByCountry');
Route::post('/cityByState', 'UserController@cityByState')->name('cityByState');
Route::post('/getCountryStateCityByPinCode', 'UserController@getCountryStateCityByPinCode')->name('getCountryStateCityByPinCode');
Route::post('/ajaxGetCountryIdByName', 'UserController@ajaxGetCountryIdByName')->name('ajaxGetCountryIdByName');

// Route::post('/cityByState', 'UserController@cityByState')->name('cityByState')->withoutMiddleware('adminLogoutAfterSomeDays');;

//ajax
Route::post('/getAjaxAttributes', 'UserController@getAjaxAttributes')->name('getAjaxAttributes');
Route::post('/saveItemCategory', 'UserController@saveItemCategory')->name('saveItemCategory');
Route::post('/updateItemCategory', 'UserController@updateItemCategory')->name('updateItemCategory');
Route::post('/getAjaxAttriubeByCatID', 'UserController@getAjaxAttriubeByCatID')->name('getAjaxAttriubeByCatID');
Route::post('/saveChangesProductAttribue', 'UserController@saveChangesProductAttribue')->name('saveChangesProductAttribue');
Route::post('/saveChangesProductDetails', 'UserController@saveChangesProductDetails')->name('saveChangesProductDetails');
Route::post('/saveChangesProductRelation', 'UserController@saveChangesProductRelation')->name('saveChangesProductRelation');
Route::post('/saveChangesProductTaxation', 'UserController@saveChangesProductTaxation')->name('saveChangesProductTaxation');

Route::post('/getAjaxSelectedAttributeValue', 'UserController@getAjaxSelectedAttributeValue')->name('getAjaxSelectedAttributeValue');



Route::post('/filterByAjax', 'FrontController@filterByAjax')->name('filterByAjax');
Route::post('/filterByAjaxBrand', 'FrontController@filterByAjaxBrand')->name('filterByAjaxBrand');
Route::post('/filterLeftSideSearchPageAjax', 'FrontController@filterLeftSideSearchPageAjax')->name('filterLeftSideSearchPageAjax');
Route::post('/filterLeftSideCategoryPageAjax', 'FrontController@filterLeftSideCategoryPageAjax')->name('filterLeftSideCategoryPageAjax');
Route::post('/filterLeftSideBrandPageAjax', 'FrontController@filterLeftSideBrandPageAjax')->name('filterLeftSideBrandPageAjax');

Route::get('/thanks', 'FrontController@thanks')->name('thanks');
Route::get('/search', 'FrontController@searchKeyword')->name('searchKeyword');
Route::get('/search-filter', 'FrontController@searchKeywordFilter')->name('searchKeywordFilter');
Route::get('/category-filter', 'FrontController@searchKeywordCategoryFilter')->name('searchKeywordCategoryFilter');
Route::get('/brand-filter', 'FrontController@searchKeywordBrandFilter')->name('searchKeywordBrandFilter');
Route::post('/getItemsByCatOrBrandIdByAjax', 'FrontController@getItemsByCatOrBrandIdByAjax')->name('getItemsByCatOrBrandIdByAjax');
Route::get('/items-by-category/{id}', 'FrontController@getItemsByCatId')->name('getItemsByCatId');
Route::get('/items-by-brand/{id}', 'FrontController@getItemsByBrandId')->name('getItemsByBrandId');

Route::get('/customerCartList', 'UserController@customerCartList')->name('customerCartList');
Route::get('/Customer-Cart-List', 'UserController@customerCartListForAdmin')->name('customerCartListForAdmin');

Route::get('/getItemsByCatOrBrandIdByAjaxForPagination', 'FrontController@getItemsByCatOrBrandIdByAjaxForPagination')->name('getItemsByCatOrBrandIdByAjaxForPagination');
Route::get('/getItemsByCatOrBrandIdByAjaxForPaginationOnClickCat', 'FrontController@getItemsByCatOrBrandIdByAjaxForPaginationOnClickCat')->name('getItemsByCatOrBrandIdByAjaxForPaginationOnClickCat');

Route::get('/product_detail/{item_id}', 'FrontController@productDetail')->name('productDetail');
Route::post('/deleteItemAttrOption', 'UserController@deleteItemAttrOption')->name('deleteItemAttrOption');
Route::post('/itemRating', 'UserController@itemRating')->name('itemRating');

Route::get('/orders', 'UserController@orderAdmin')->name('orderAdmin')->middleware('IsAdminLogin');
Route::get('/pending-order', 'UserController@pendingOrderAdmin')->name('pendingOrderAdmin')->middleware('IsAdminLogin');
Route::get('/approved-order', 'UserController@approvedOrderAdmin')->name('approvedOrderAdmin');
Route::get('/to-be-packed', 'UserController@toBePackedAdminOrder')->name('toBePackedAdminOrder');
Route::get('/toBePackedDetail/{order_id}', 'UserController@toBePackedDetail')->name('toBePackedDetail');
Route::post('/getAllItemByOrderOnModel', 'UserController@getAllItemByOrderOnModel')->name('getAllItemByOrderOnModel');
Route::post('/allItemByOrderProccessModel', 'UserController@allItemByOrderProccessModel')->name('allItemByOrderProccessModel');



Route::post('/getAllItemByCustomerCart', 'UserController@getAllItemByCustomerCart')->name('getAllItemByCustomerCart');

Route::post('/deleteScandItem', 'UserController@deleteScandItem')->name('deleteScandItem');
Route::post('/toBePackedClickBtnProcess', 'UserController@toBePackedClickBtnProcess')->name('toBePackedClickBtnProcess');

Route::post('/barcodeScanItemSave', 'UserController@barcodeScanItemSave')->name('barcodeScanItemSave');
Route::post('/barcodeScanItemUpdate', 'UserController@barcodeScanItemUpdate')->name('barcodeScanItemUpdate');

Route::post('/getItemByBarcode', 'UserController@getItemByBarcode')->name('getItemByBarcode');
Route::post('/checkedGetBarcodeByItemId', 'UserController@checkedGetBarcodeByItemId')->name('checkedGetBarcodeByItemId');

Route::post('/saveShippedOrderWithTransport', 'UserController@saveShippedOrderWithTransport')->name('saveShippedOrderWithTransport');

Route::get('/toBePackedProcess/{order_id}', 'UserController@toBePackedProcess')->name('toBePackedProcess');
Route::post('/printLableAndSaveBox', 'UserController@printLableAndSaveBox')->name('printLableAndSaveBox');
Route::post('/moveToshipingBtn', 'UserController@moveToshipingBtn')->name('moveToshipingBtn');
Route::get('/tobeShipedOrder/{packing_no}', 'UserController@tobeShipedOrder')->name('tobeShipedOrder');
Route::get('/transportMasters', 'UserController@transportMasters')->name('transportMasters');
Route::post('/transportSaveForm', 'UserController@transportSaveForm')->name('transportSaveForm');
Route::post('/editTransport', 'UserController@editTransport')->name('editTransport');
Route::post('/transportUpdateForm', 'UserController@transportUpdateForm')->name('transportUpdateForm');

Route::get('order-cancel-by-custumer/{order_id}/{customer_id}', 'CustomerController@orderCancelByCustumer')->name('orderCancelByCustumer');
Route::get('order-cancel-by-admin/{order_id}/{customer_id}', 'UserController@orderCancelByAdmin')->name('orderCancelByAdmin');
Route::post('orderCancelByAdminAjax', 'UserController@orderCancelByAdminAjax')->name('orderCancelByAdminAjax');
Route::post('orderCancelByCustomerAjax', 'CustomerController@orderCancelByCustomerAjax')->name('orderCancelByCustomerAjax');


Route::get('/packed-order', 'UserController@packagingOrderAdmin')->name('packagingOrderAdmin');
Route::get('/shipping-order', 'UserController@shippingOrderAdmin')->name('shippingOrderAdmin');
Route::get('/delivered-order', 'UserController@deliveredOrderAdmin')->name('deliveredOrderAdmin');
Route::get('/return-order', 'UserController@returnOrderAdmin')->name('returnOrderAdmin');
Route::get('/cancelled-order', 'UserController@cancelOrderAdmin')->name('cancelOrderAdmin');
Route::get('/hold-order', 'UserController@holdOrderAdmin')->name('holdOrderAdmin');

Route::get('/my-packed-order', 'CustomerController@myPacked')->name('myPacked');
Route::get('/my-shipping-order', 'CustomerController@myShipping')->name('myShipping');

Route::get('/editOrderStageAdmin/{order_id}', 'UserController@editOrderStageAdmin')->name('editOrderStageAdmin');
Route::post('/updateOrderStageFromShiped', 'UserController@updateOrderStageFromShiped')->name('updateOrderStageFromShiped');
Route::post('/updateOrderStageAdmin', 'UserController@updateOrderStageAdmin')->name('updateOrderStageAdmin');
Route::post('/updateDeliveredOrderPaymentStatusAdmin', 'UserController@updateDeliveredOrderPaymentStatusAdmin')->name('updateDeliveredOrderPaymentStatusAdmin');

Route::post('/updateOrderStageAdminByItem', 'UserController@updateOrderStageAdminByItem')->name('updateOrderStageAdminByItem');
Route::post('/updateCustomerDiscount', 'UserController@updateCustomerDiscount')->name('updateCustomerDiscount');

Route::get('/discountLayout', 'UserController@discountLayout')->name('discountLayout');
Route::post('/saveClassDiscount', 'UserController@saveClassDiscount')->name('saveClassDiscount');
Route::post('/editClassDiscount', 'UserController@editClassDiscount')->name('editClassDiscount');
Route::post('/updateClassDiscount', 'UserController@updateClassDiscount')->name('updateClassDiscount');

Route::get('/sales-customer-tag', 'UserController@salesCustomerTag')->name('salesCustomerTag');
Route::post('/saveCustomerSales', 'UserController@saveCustomerSales')->name('saveCustomerSales');
Route::post('/editCustomerSalesTaging', 'UserController@editCustomerSalesTaging')->name('editCustomerSalesTaging');
Route::post('/updateCustomerSalesTaging', 'UserController@updateCustomerSalesTaging')->name('updateCustomerSalesTaging');



Route::post('/editCategoryDiscount', 'UserController@editCategoryDiscount')->name('editCategoryDiscount');
Route::post('/updateCategoryDiscount', 'UserController@updateCategoryDiscount')->name('updateCategoryDiscount');

Route::post('/saveCategoryDiscount', 'UserController@saveCategoryDiscount')->name('saveCategoryDiscount');

Route::get('/hsnMaster', 'UserController@hsnMaster')->name('hsnMaster');

Route::post('/saveHSN', 'UserController@saveHSN')->name('saveHSN');
Route::post('/updateHsn', 'UserController@updateHsn')->name('updateHsn');

Route::post('/saveCustomerClass', 'UserController@saveCustomerClass')->name('saveCustomerClass');
Route::post('/saveCustomerCategory', 'UserController@saveCustomerCategory')->name('saveCustomerCategory');
Route::post('/updateCustomerClass', 'UserController@updateCustomerClass')->name('updateCustomerClass');
Route::post('/updateCustomerCategory', 'UserController@updateCustomerCategory')->name('updateCustomerCategory');

Route::post('/deactiveHsn', 'UserController@deactiveHsn')->name('deactiveHsn');
Route::post('/activeHsn', 'UserController@activeHsn')->name('activeHsn');

Route::post('/deactiveClass', 'UserController@deactiveClass')->name('deactiveClass');
Route::post('/activeClass', 'UserController@activeClass')->name('activeClass');

Route::post('/deactiveCustomerCategory', 'UserController@deactiveCustomerCategory')->name('deactiveCustomerCategory');
Route::post('/activeCustomerCategory', 'UserController@activeCustomerCategory')->name('activeCustomerCategory');

Route::get('/customerClass', 'UserController@customerClass')->name('customerClass');
Route::get('/customerCategories', 'UserController@customerCategories')->name('customerCategories');

Route::get('/admin-orders/{orderId?}', 'UserController@adminOrderBackend')->name('adminOrderBackend');
Route::post('/getAdminOrder', 'UserController@getAdminOrder')->name('getAdminOrder');

Route::post('payment', 'PaymentController@payment')->name('payment');
Route::post('codOrCreditOrderByCustomer', 'PaymentController@codOrCreditOrderByCustomer')->name('codOrCreditOrderByCustomer');
Route::post('codOrCreditOrderBySales', 'PaymentController@codOrCreditOrderBySales')->name('codOrCreditOrderBySales');
Route::post('paymentBySales', 'PaymentController@paymentBySales')->name('paymentBySales');
//Route::get('afterPaymentByLinkCron', 'PaymentController@afterPaymentByLinkCron')->name('afterPaymentByLinkCron');

Route::post('defaultPaymentOption', 'PaymentController@defaultPaymentOption')->name('defaultPaymentOption');
/*
  |--------------------------------------------------------------------------
  |         *************  START SALES ****************
  |--------------------------------------------------------------------------
*/

Route::get('/sales-person', 'UserController@salesPersions')->name('salesPersions');
Route::get('/new-sales-person', 'UserController@addSlaesPersionLayout')->name('addSlaesPersionLayout');
Route::post('/new-sales-person', 'UserController@addSlaesPersion')->name('addSlaesPersion');
Route::get('/edit-sales-person/{seller_id}', 'UserController@editSalesPersionLayout')->name('editSalesPersionLayout');
Route::post('/update-sales-person', 'UserController@UpdateSalesPersion')->name('UpdateSalesPersion');
Route::post('/sellerDeactive', 'UserController@sellerDeactive')->name('sellerDeactive');
Route::post('/sellerActive', 'UserController@sellerActive')->name('sellerActive');
Route::get('/contactus', 'UserController@getContactList')->name('getContactList');

Route::get('/SalesDashboard', 'SalesPersionController@SalesDashboard')->name('SalesDashboard');
// Route::get('/SalesDashboard', 'HomeController@SalesDashboard')->name('SalesDashboard');
// Route::get('/sales-login', 'SalesPersionController@salesLoginLayout')->name('salesLoginLayout');
Route::get('/sales-login', 'HomeController@salesLoginLayout')->name('salesLoginLayout');
Route::post('/salesLogin', 'Auth\LoginController@salesLogin')->name('salesLogin');

Route::get('/salesPersonItems', 'SalesPersionController@salesPersonItems')->name('salesPersonItems');

Route::post('/getItemsWithCustomerBySeller', 'SalesPersionController@getItemsWithCustomerBySeller')->name('getItemsWithCustomerBySeller');
Route::get('/salesItemSearch', 'SalesPersionController@salesItemSearch')->name('salesItemSearch');

Route::post('/salesItemByBrand', 'SalesPersionController@salesItemByBrand')->name('salesItemByBrand');

Route::post('/salesItemByCategory', 'SalesPersionController@salesItemByCategory')->name('salesItemByCategory');
Route::post('/salesItemSeach', 'SalesPersionController@salesItemSeach')->name('salesItemSeach');


// Route::post('/removeSalesItemFromCart', 'CartController@removeSalesItemFromCart')->name('removeSalesItemFromCart');
Route::post('/setSalesAddToCart', 'CartController@setSalesAddToCart')->name('setSalesAddToCart');

Route::get('/sales-product-detail/{item_id}', 'SalesPersionController@salesProductDetail')->name('salesProductDetail');
Route::get('/sales-view-cart', 'CartController@salse_view_cart')->name('salse_view_cart');

/*
  |--------------------------------------------------------------------------
  |         *************  START CUSTOMER ****************
  |--------------------------------------------------------------------------
*/

// Route::group(['prefix'=>'customer', 'middleware' =>'logoutAfterSomeDays'], function(){
Route::group(['prefix'=>'customer'], function(){

  // Route::get('login', 'HomeController@showCustomerLoginForm')->name('showCustomerLoginForm')->withoutMiddleware('logoutAfterSomeDays');
  Route::get('login', 'HomeController@showCustomerLoginForm')->name('showCustomerLoginForm');
    Route::post('/sendOtp', 'Auth\RegisterController@sendOtp')->name('sendOtp');
    Route::post('/resendOtp', 'Auth\RegisterController@resendOtp')->name('resendOtp');
    Route::post('/verifyOtp', 'Auth\RegisterController@verifyOtp')->name('verifyOtp');
    
    Route::post('/sendOtpForSales', 'Auth\LoginController@sendOtpForSales')->name('sendOtpForSales');
    Route::post('/resendOtpForSales', 'Auth\LoginController@resendOtpForSales')->name('resendOtpForSales');
    Route::post('/verifyOtpForSales', 'Auth\LoginController@verifyOtpForSales')->name('verifyOtpForSales');
    
  });
  
  Route::post('/updateCustomerProfileDetails', 'CustomerController@updateCustomerProfileDetails')->name('updateCustomerProfileDetails');
  Route::get('/customer-profile', 'CustomerController@customerProfile')->name('customerProfile');
  Route::post('/saveCustomerProfileDetails', 'CustomerController@saveCustomerProfileDetails')->name('saveCustomerProfileDetails');
Route::get('/addresses', 'CustomerController@addresses')->name('addresses');

Route::post('/saveProfilePic', 'CustomerController@saveProfilePic')->name('saveProfilePic');



Route::get('/customer-profiles', 'CustomerController@customerProfileWizard')->name('customerProfileWizard');

Route::get('/customer-orders/{orderId?}', 'FrontController@customerOrderFront')->name('customerOrderFront');
Route::post('/getCustomerOrder', 'FrontController@getCustomerOrder')->name('getCustomerOrder');

Route::post('/checksms', 'CustomerController@checksms');

Route::get('/my-orders', 'SalesPersionController@myOrderListBySales')->name('myOrderListBySales');
Route::get('/viewOrderSales/{order_id}', 'SalesPersionController@viewOrderSales')->name('viewOrderSales');

Route::get('/my-order', 'CustomerController@myOrderList')->name('myOrderList');
Route::get('/my-pending-order', 'CustomerController@myPendingOrder')->name('myPendingOrder');
Route::get('/my-confirm-order', 'CustomerController@myConfirmOrder')->name('myConfirmOrder');
Route::get('/my-cancel-order', 'CustomerController@myCancelOrder')->name('myCancelOrder');
Route::get('/my-return-order', 'CustomerController@myReturnOrder')->name('myReturnOrder');
Route::get('/my-delivered-order', 'CustomerController@myDeliveredOrder')->name('myDeliveredOrder');
Route::get('/my-hold-order', 'CustomerController@myHoldOrder')->name('myHoldOrder');

Route::get('/view-order/{order_id}', 'CustomerController@viewOrderCustumer')->name('viewOrderCustumer');
// Route::get('/viewOrderAdmin/{order_id}', 'CustomerController@viewOrderAdmin')->name('viewOrderAdmin');
Route::get('/viewOrderAdmin/{order_id}', 'UserController@viewOrderAdmin')->name('viewOrderAdmin');

Route::get('/viewToBeProccessTabOrderAdmin/{order_id}', 'UserController@viewToBeProccessTabOrderAdmin')->name('viewToBeProccessTabOrderAdmin');
Route::get('/viewPackedOrderAdmin/{order_id}', 'UserController@viewPackedOrderAdmin')->name('viewPackedOrderAdmin');
Route::get('/viewShipedOrderAdmin/{order_id}', 'UserController@viewShipedOrderAdmin')->name('viewShipedOrderAdmin');
Route::get('/viewDeliveredOrderAdmin/{order_id}', 'UserController@viewDeliveredOrderAdmin')->name('viewDeliveredOrderAdmin');
Route::get('/viewDeliveredOrderAdminPoint/{order_id}', 'UserController@viewDeliveredOrderAdminPoint')->name('viewDeliveredOrderAdminPoint');





Route::get('/payment-success/{order?}', 'FrontController@paymentSuccess')->name('paymentSuccess');
Route::get('/genrateItemOrderPdf/{order?}', 'FrontController@genrateItemOrderPdf')->name('genrateItemOrderPdf');
Route::get('/show-my-order/{order?}', 'FrontController@viewOrderCustumerFront')->name('viewOrderCustumerFront');


Route::get('/contact-us', 'FrontController@contactUs')->name('contactUs');
Route::post('/contact_us', 'FrontController@saveContactUs')->name('saveContactUs');
Route::get('/refund-policy', 'FrontController@refundPolicy')->name('refundPolicy');
Route::get('/privacy-policy', 'FrontController@privacyPolicy')->name('privacyPolicy');
Route::get('/terms-of-use', 'FrontController@termsOfUse')->name('termsOfUse');
Route::get('/Careers', 'FrontController@careers')->name('careers');
Route::get('/about-us', 'FrontController@aboutUs')->name('aboutUs');
Route::get('/information', 'FrontController@information')->name('information');
Route::get('/support', 'FrontController@support')->name('support');
Route::get('/faq', 'FrontController@faq')->name('faq');

Route::get('/sales-refund', 'FrontController@salesRefund')->name('salesRefund');

Route::post('/itemByBrandfillter', 'FrontController@itemByBrandfillter')->name('itemByBrandfillter');
Route::post('/itemByCategoryfillter', 'FrontController@itemByCategoryfillter')->name('itemByCategoryfillter');

Route::get('/getItemOnClickCarausel', 'FrontController@getItemOnClickCarausel')->name('getItemOnClickCarausel');



Route::get('/paynow', 'PaymentController@paynow')->name('paynow');

Route::get('/test_notification', 'UserController@test_not')->name('test_not');

// Route::get('protected', ['middleware' => ['auth'], function() {
//     // this page requires that you be logged in AND be an Admin
 // }]);

// Route::get('protected', ['middleware' => ['auth'], ['prefix'=>'customer'],function() {
//     this page requires that you be logged inbut you don't need to be an admin
    
    
// }]);
//End customer
//this is 
Route::get('/pages', 'UserController@pages')->name('pages'); 
Route::get('/add-page', 'UserController@addPage')->name('addPage');
Route::post('/save-page', 'UserController@savePage')->name('savePage');
Route::get('/edit-page/{id}', 'UserController@editPage')->name('editPage');
Route::post('/update-page/{id}', 'UserController@updatePage')->name('updatePage');
Route::get('/delete-page/{id}', 'UserController@deletePage')->name('deletePage');


Route::get('/pincode', 'UserController@pincode')->name('pincode'); 
Route::get('/masterpoints', 'UserController@masterpoints')->name('masterpoints'); 



Route::get('/orderWisepoints', 'UserController@orderWisepoints')->name('orderWisepoints'); 
Route::get('/myOrderPointList', 'UserController@myOrderPointList')->name('myOrderPointList'); 


Route::get('/add-pincode', 'UserController@addPincode')->name('addPincode');
Route::post('/save-pincode', 'UserController@savePincode')->name('savePincode');
Route::get('/edit-pincode/{id}', 'UserController@editPincode')->name('editPincode');
Route::post('/update-pincode/{id}', 'UserController@updatePincode')->name('updatePincode');
Route::get('/delete-pincode/{id}', 'UserController@deletePincode')->name('deletePincode');
Route::get('/exportPincode', 'UserController@exportPincode')->name('exportPincode');
Route::get('/exportPointMaster', 'UserController@exportPointMaster')->name('exportPointMaster');

Route::post('/pincodeImport', 'UserController@pincodeImport')->name('pincodeImport');
Route::post('/pointMasterImport', 'UserController@pointMasterImport')->name('pointMasterImport');