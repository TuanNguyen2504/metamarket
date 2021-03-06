<?php

class Admin extends Controller
{
    public function index()
    {
        self::redirect('kenh-quan-ly/shipper/tat-ca');
    }
    public function shipperList()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $keyword = empty($_GET['keyword']) ? '' : (int)$_GET['keyword'];
        $query = http_build_query([
            'keyword' => $keyword,
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE
        ]);
        $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . "/get-all-shipper?$query");

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('shipperData', $apiRes['data']);
        }
        $this->setPageTitle('Quản lý shipper');
        $this->appendCssLink(['home.css', 'admin/shipper.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shop/order-list.js', 'search.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('admin/shipper-list');
        $this->render('layouts/admin', $this->data);
    }
    public function viewAddShipper()
    {
        $this->renderViewAddShipper();
    }
    public function addShipper()
    {
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        $hashPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);
        $data = [
            'username' => empty($_POST['username']) ? '' : $_POST['username'],
            'password' => $hashPwd,
            'peopleId' => empty($_POST['peopleId']) ? '' : $_POST['peopleId'],
            'address' => empty($_POST['address']) ? '' : $_POST['address'],
            'driverLicense' => empty($_POST['driverLicense']) ? '' : $_POST['driverLicense'],
        ];
        $apiRes = ApiCaller::post(INTERNAL_SERVICE_API_URL . '/shipper/add', $data);
        if ($apiRes['statusCode'] === 200 || $apiRes['statusCode'] === 201) {
            $this->setViewContent('isError', false);
        } else {
            $this->setViewContent('isError', true);
        }
        $this->renderViewAddShipper();
    }
    public function shopList()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $pageSize = DEFAULT_PAGE_SIZE;
        $status = isset($_GET['status']) ? (int)$_GET['status'] : NULL;

        $total = ShopModel::countAllShop();
        $shops = ShopModel::findAll($page, $pageSize, $status);

        $this->renderShopList($shops, $page, $total, $pageSize);
        $this->render('layouts/admin');
    }
    public function waitingApprovalShopList()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $pageSize = DEFAULT_PAGE_SIZE;

        $total = ShopModel::countAllShop(ACCOUNT_STATUS['WAITING_APPROVAL']);
        $shops = ShopModel::findAll($page, $pageSize, ACCOUNT_STATUS['WAITING_APPROVAL']);

        $this->renderShopList($shops, $page, $total, $pageSize);
        $this->render('layouts/admin');
    }

    private function renderShopList($shops, $page, $total, $pageSize)
    {
        $this->setViewContent('shops', $shops);
        $this->setViewContent('totalPage', ceil($total / $pageSize));
        $this->setViewContent('page', $page);

        $this->appendCssLink(['pagination.css']);
        $this->appendJSLink(['pagination.js', 'admin/shop-list.js']);
        $this->setPassedVariables(['USER_SERVICE_API_URL' => USER_SERVICE_API_URL]);
        $this->setPageTitle('Quản lý cửa hàng');
        $this->setContentViewPath('admin/shop-list');
        $this->render('layouts/admin');
    }
    private function renderViewAddShipper()
    {
        $this->setPageTitle('Quản lý shipper');
        $this->setPassedVariables(['STATIC_FILE_URL' => STATIC_FILE_URL]);
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js']);
        $this->appendCssLink(['home.css', 'admin/shipper.css',]);
        $this->appendJSLink(['utils/format.js', 'admin/shipper.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('admin/add-shipper');
        $this->render('layouts/admin');
    }
}
