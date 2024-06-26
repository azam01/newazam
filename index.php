<?php

ob_start();
error_reporting(E_ALL);
require_once("_inc/_functions.php"); // header

/*
$request_url = $_SERVER['REQUEST_URI'];
$viewDir = 'views/';
$request = str_replace("/cimsv2/","",$request_url);
*/

$request_url = $_SERVER['REQUEST_URI'];
$viewDir = 'views/';
$request = str_replace("/".folder."/","",$request_url);
$requestArr = explode("/", $request,3);

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/


loginAuthenticate($request);

$include_script = [];

/*******  separate function file for all the developers  ******/
require_once("_inc/_functions-hasan.php");
require_once("_inc/_functions-anwar.php");
require_once("_inc/_functions-joydip.php");
/*******  separate function file for all the developers  ******/

switch ($request) {

    case $requestArr[0] === '':

    case $requestArr[0] === '/':

        $page_title_tag = "Welcome Home"; // page title tag

		$page_title = "Welcome to CIMS V1"; // page title above content

        $page_access = "dashboard";

        include_headers();

		require DOCUMENT_ROOT_PATH . $viewDir . 'dashboard.php';

        include_footers();

        break;



    case $requestArr[0] === 'login':

        $page_title_tag = "Login";

        $page_title = "Login";

        $page_access = "login";


        require(DOCUMENT_ROOT_PATH."_layout/_header.php"); // header

        require DOCUMENT_ROOT_PATH . $viewDir . 'login.php';

        require(DOCUMENT_ROOT_PATH."_layout/_footer.php"); // footer

    break;

    

    case $requestArr[0] === 'logout':

      
        $util = new Util();

        $util->clearAuthCookie();

        $timeout = 3600;

        setcookie(session_name(), '', time()-$timeout, '/');

        session_destroy();

        header('location:'.ROOT_PATH);

        die;

    break;



    case $requestArr[0] === 'orders':

        $page_title_tag = "Orders";

		$page_title = "Orders";

        $page_access = "orders";

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'orders.php';

        include_footers();

        break;



    case $requestArr[0] === 'order-details':

        $page_title_tag = "Order Details";

        $page_title = "Order Details";

        $page_access = "order-details";

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'order-details.php';

        include_footers();

        break;

    

    case $requestArr[0] === 'shipping':

        $page_title_tag = "Shipping";

        $page_title = "Shipping";

        $page_access = "shipping";

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'shipping.php';

        include_footers();

        break; 



    case $requestArr[0] === 'returns':

        $page_title_tag = "Returns";

        $page_title = "Returns";

        $page_access = "returns";

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'returns.php';

        include_footers();

        break;  

     case $requestArr[0] === 'products':

        $page_title_tag = "Products";

        $page_title = "Products";

        $page_access = "products";

        $include_script = ['product-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'products.php';

        include_footers();

        break;   

    case $requestArr[0] === 'product-add':

        $page_title_tag = "Add Product";

        $page_title = "Add New Product";

        $page_access = "product-add";

        $include_script = ['product-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-add.php';

        include_footers();

        break;



// new case added Nov 1, 2023 --------------------------------------------------

    case $requestArr[0] === 'product-details':

        $page_title_tag = "Product Details";

        $page_title = "Product Details";

        $page_access = "product-details";

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-details.php';

        include_footers();

        break;

// end add new case

     /*case $requestArr[0] === 'product-edit':

        $page_title_tag = "Add Product";

        $page_title = "Add New Product";

        $page_access = "product-edit";

        $include_script = ['product-edit-ajax'];

        $product_id = $_GET['id'];

        $getProductData = getProduct($product_id);

        $getProductTagsData=getProductTags($product_id);

        $getProductCategories= getProductCategories($product_id);

        $getProductCategoriesids=getProductCategoriesids($product_id);

        $getProductBrand=getProductBrand($product_id);

        $getProductBrandid=getProductBrandid($product_id);

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-edit.php';

        include_footers();

    break;*/

  case $requestArr[0] === 'product-edit':
        $page_title_tag = "Edit Product";
        $page_title = "Edit Product";
        $page_access = "product-edit";
        $include_script = ['product-edit-ajax','select2.min', 'bootbox.all.min'];
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'product-edit.php';
        include_footers();
    break;
    
  case $requestArr[0] === 'product-categories':

        $page_title_tag = "Product Categories";

        $page_title = "Product Categories";

        $page_access = "product-categories";

        $include_script = ['categories-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-categories.php';

        include_footers();

        break;       

  case $requestArr[0] === 'product-tag':

        $page_title_tag = "Product Tag";

        $page_title = "Product Tag";

        $page_access = "product-tag";

        $include_script = ['tags-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-tags.php';

        include_footers();

        break;   

     case $requestArr[0] === 'product-brand':

        $page_title_tag = "Product Brand";

        $page_title = "Product Brand";

        $page_access = "product-brand";

        $include_script = ['brands-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'product-brand.php';

        include_footers();

        break;   

    case $requestArr[0] === 'inventory':
        $page_title_tag = "Inventory";
        $page_title = "Inventory";
        $include_script = ['inventory-ajax'];
        $page_access = "inventory";
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory.php';
        include_footers();
        break;  
    case $requestArr[0] === 'inventory-transfer':
        $page_title_tag = "Inventory Transfer";
        $page_title = "Inventory Transfer";
        $page_access = "inventory-transfer";
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory-transfer.php';
        include_footers();
        break;  
    case $requestArr[0] === 'inventory-po':
        
        $page_title_tag = "Purchase Orders";
        $page_title = "Purchase Orders";
        $include_script = ['flatpickr.min','purchase-orders-ajax','alertify.min'];
        $page_access = "inventory-po";
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory-po.php';
        include_footers();
    break;
    case $requestArr[0] === 'inventory-po-create':
        $page_title_tag = "Create Purchase Order";
        $page_title = "Create Purchase Order";
        $page_access = "inventory-po-create";
        $include_script = ['flatpickr.min','purchase-orders-ajax'];
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory-po-create.php';
        include_footers();
        break;    
    case $requestArr[0] === 'inventory-po-line-items':
        $page_title_tag = "PO Line Items";
        $page_title = "PO Line Items";
        $include_script = ['flatpickr.min', 'purchase-orders-ajax'];
        $page_access = "inventory-po-line-items";
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory-po-line-items.php';
        include_footers();
        break; 

    case $requestArr[0] === 'inventory-vendors':

        $page_title_tag = "Vendors";

        $page_title = "Vendors";

        $page_access = "inventory-vendors";

        $include_script = ['vendor-ajax'];
        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'inventory-vendors.php';

        include_footers();

        break;   

    case $requestArr[0] === 'manage-users':

        $page_title_tag = "Users";

        $page_title = "Users";

        $page_access = "manage-users";

        $include_script = ['users-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-users.php';

        include_footers();

        break;       

    case $requestArr[0] === 'manage-customers':

        $page_title_tag = "Customers"; 

        $page_title = "Customers";

        $page_access = "manage-customers";

        $include_script = ['customers-ajax'];

        include_headers();

        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-customers.php';

        include_footers();

        break;  
    
    /*Edit my account by Anwar*/
    case $requestArr[0] === 'my-account': 
        $page_title_tag = "My Account"; 
        $page_title = "My Account";
        $page_access = "my-account";
        $include_script = ['account-ajax'];
        $getUser= getUserAdmin();
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'my-account.php';
        include_footers();
    break; 

    /*support by Anwar*/
    case $requestArr[0] === 'support': 
        $page_title_tag = "Support"; 
        $page_title = "Support";
        $page_access = "suppot";        
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'support.php';
        include_footers();
    break; 

     /*faq by Anwar*/
    case $requestArr[0] === 'faq': 
        $page_title_tag = "FAQ"; 
        $page_title = "FAQ";
        $page_access = "faq";        
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'faq.php';
        include_footers();
    break; 

     /*stores by Anwar*/
     case $requestArr[0] === 'manage-stores': 
        $page_title_tag = "Manage Stores"; 
        $page_title = "Manage Stores";
        $page_access = "manage-stores";   
        $include_script = ['stores-ajax'];     
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-stores.php';
        include_footers();
    break; 

     /*Customer Details by Anwar*/
     case $requestArr[0] === 'customer-details': 
        $page_title_tag = "Customer Details"; 
        $page_title = "Customer Details";
        $page_access = "mcustomer-details";   
        $include_script = ['customer-details-ajax'];    
        $customer_id = $_GET['id'];
        $getCustomerData = getCustomerDetails($customer_id);
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'customer-details.php';
        include_footers();
    break; 

    /*Customer Tag by Anwar*/
    case $requestArr[0] === 'manage-customer-tags': 
        $page_title_tag = "Manage Customer Tags"; 
        $page_title = "Manage Customer Tags";
        $page_access = "manage-customer-tags";   
        $include_script = ['customer-tags-ajax'];    
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-customer-tags.php';
        include_footers();
    break; 

    /*Manage permission names by Anwar*/
    case $requestArr[0] === 'manage-permission-names': 
        $page_title_tag = "Manage Permission Names"; 
        $page_title = "Manage Permission Names";
        $page_access = "manage-permission-names";   
        $include_script = ['manage-permission-names-ajax'];    
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-permission-names.php';
        include_footers();
    break; 

    /*Manage permission roles by Anwar*/
    case $requestArr[0] === 'manage-permission-roles': 
        $page_title_tag = "Manage Permission Roles"; 
        $page_title = "Manage Permission Roles";
        $page_access = "manage-permission-roles";   
        $include_script = ['permission-roles-ajax'];    
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'manage-permission-roles.php';
        include_footers();
    break; 

    /*Manage media by Anwar*/
    case $requestArr[0] === 'manage-media': 
        $page_title_tag = "Manage Media"; 
        $page_title = "Manage Media";
        $page_access = "manage-media";   
        $include_script = ['media-ajax'];    
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'media.php';
        include_footers();
    break; 

     /*Manage navigation by Anwar*/
     case $requestArr[0] === 'manage-navigation': 
        $page_title_tag = "Manage Navigation"; 
        $page_title = "Manage Navigation";
        $page_access = "manage-navigation";   
        $include_script = ['navigation-ajax'];    
        include_headers();
        require DOCUMENT_ROOT_PATH . $viewDir . 'navigation.php';
        include_footers();
    break; 

    default:

        http_response_code(404);

        $page_title_tag = "Page Not Found (404)";

        $page_title = "Page Not Found (404 Error)";

        $page_access = "404-error";

        require(DOCUMENT_ROOT_PATH."_layout/_header.php"); // header

        require DOCUMENT_ROOT_PATH . $viewDir . '404.php';

        require(DOCUMENT_ROOT_PATH."_layout/_footer.php"); // footer

}





?>

