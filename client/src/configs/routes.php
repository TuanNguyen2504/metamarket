<?php
$routes['default_controller'] = 'home';

// Virtual route -> real route
$routes['trang-chu'] = 'home';
$routes['cua-hang/(.+)'] = 'home/shopInfo/$1';

// Catalog
$routes['nhom-danh-muc/*'] = 'catalog/$1';
$routes['catalog/(.+)'] = 'catalog/index/$1';
$routes['category/(.+)/(.+)'] = 'catalog/category/$1/$2';
$routes['danh-muc/*'] = 'category/$1';

// Account
$routes['tai-khoan/dang-ky'] = 'account/signup';
$routes['tai-khoan/dang-nhap'] = 'account/login';
$routes['quen-mat-khau'] = 'account/forgotPassword';
$routes['thay-doi-mat-khau'] = 'account/changePassword';
$routes['thuc-hien-thay-doi-mat-khau'] = 'account/postChangePassword';
$routes['dang-ky-ban-hang'] = 'account/shopRegister';

// User
$routes['tai-khoan/thong-tin'] = 'user/index';
$routes['tai-khoan/cap-nhat-thong-tin'] = 'user/postUpdateInfo';
$routes['tai-khoan/don-hang'] = 'user/orders';

// Product
$routes['san-pham/(.+)'] = 'product/index/$1';
$routes['tim-kiem'] = 'product/search';

// Cart
$routes['gio-hang'] = 'cart/index';

// Shop
$routes['kenh-ban-hang/san-pham/them'] = 'shop/addProduct';
$routes['kenh-ban-hang/san-pham/them/post'] = 'shop/postAddProduct';
$routes['kenh-ban-hang/ho-tro/chat'] = 'shop/chat';
$routes['kenh-ban-hang/don-hang/tat-ca'] = 'shop/orderList';
$routes['kenh-ban-hang/don-hang/chua-xu-ly'] = 'shop/orderList/pending_shop';
$routes['kenh-ban-hang/san-pham/tat-ca'] = 'shop/productList';
$routes['kenh-ban-hang/san-pham/cap-nhat/post'] = 'shop/postUpdateProduct';
$routes['kenh-ban-hang/ho-tro/danh-gia'] = 'shop/review';
$routes['kenh-ban-hang/quan-ly/thong-tin'] = 'shop/information';
$routes['kenh-ban-hang/quan-ly/thiet-lap'] = 'shop/settings';
$routes['kenh-ban-hang/quan-ly/thiet-lap/post'] = 'shop/postSettings';
$routes['kenh-ban-hang/thong-ke/tong-quan'] = 'shop/overview';
$routes['kenh-ban-hang/thong-ke/doanh-thu'] = 'shop/revenue';

// Emp
$routes['nhan-vien/dang-nhap/(.+)'] = 'InternalAccount/login/$1';

// Introduction
$routes['gioi-thieu'] = 'AboutMe/index';
$routes['chinh-sach-bao-mat'] = 'AboutMe/securityPolicy';
$routes['dieu-khoan-dich-vu'] = 'AboutMe/service';
$routes['ho-tro-khach-hang'] = 'AboutMe/customerSupport';
$routes['chinh-sach-giao-hang'] = 'AboutMe/shippingPolicy';
$routes['chinh-sach-thanh-toan'] = 'AboutMe/paymentPolicy';
$routes['chinh-sach-doi-tra'] = 'AboutMe/refundPolicy';
$routes['chinh-sach-uu-dai'] = 'AboutMe/discountPolicy';

// Review
$routes['danh-gia-san-pham'] = 'review/postReviewProduct';

// Order
$routes['thong-tin-giao-hang'] = 'order/info';
$routes['thanh-toan-momo-qr-code'] = 'order/momoQRCode';
$routes['thanh-toan-momo-atm'] = 'order/momoATM';
$routes['ket-qua-thanh-toan'] = 'order/momoPaymentResult';

//Admin
$routes['kenh-quan-ly/shipper'] = 'admin/shipperList';
$routes['kenh-quan-ly/shipper/them-shipper'] = 'admin/viewAddShipper';
$routes['kenh-quan-ly/shipper/them-shipper/post'] = 'admin/addShipper';
$routes['kenh-quan-ly/cua-hang/tat-ca'] = 'admin/shopList';
$routes['kenh-quan-ly/cua-hang/cho-duyet'] = 'admin/waitingApprovalShopList';

// Shipper
$routes['kenh-van-chuyen/don-hang/tat-ca'] = 'shipper/orderList';
$routes['kenh-van-chuyen/don-hang/chua-xac-nhan'] = 'shipper/unconfirmedOrderList';
$routes['kenh-van-chuyen/don-hang/cap-nhat'] = 'shipper/updateOrderStatus';
