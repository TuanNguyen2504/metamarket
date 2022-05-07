<?php
class Cart extends Controller
{
    public function index()
    {
        $this->setPageTitle('Giỏ hàng');
        $this->setPassedVariables(['STATIC_FILE_URL' => STATIC_FILE_URL]);
        $this->appendJSLink(['utils/format.js', 'cart-detail.js']);
        $this->appendCssLink(['cart-detail.css']);
        $this->setPassedVariables(['PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL]);
        $this->setContentViewPath('cart');
        $this->render('layouts/general', $this->data);
    }
}
