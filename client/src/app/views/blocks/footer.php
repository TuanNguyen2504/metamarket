<?php $staticUrl = STATIC_FILE_URL; ?>
<footer id="footer" class="bg-secondary pt-4 w-100">
    <div class="container pb-4">
        <div class="row gx-5 gy-3 gy-md-0">
            <div class="col col-12 col-sm-6 col-md-3">
                <div class="mb-3">
                    <?php echo "<img class='logo' src='$staticUrl/assets/images/logo.svg' alt='MM Logo'>"; ?>
                    <strong class="logo-name">
                        Meta<span class="orange-color">Market</span>
                    </strong>
                </div>
                <p>Công Ty Cổ Phần Dịch Vụ Thương Mại <b>MetaMarket</b></p>
                <p>Mã số doanh nghiệp: 0204518412 Đăng ký lần đầu ngày 30 tháng 02 năm 2021, đăng ký thay đổi lần thứ 24, ngày 31 tháng 02 năm 2022</p>
                <a href="http://online.gov.vn/" target="_blank">
                    <?php echo "<img src='$staticUrl/assets/images/bo-cong-thuong.png' alt='Check' class='check'>"; ?>
                </a>
            </div>
            <div class="col col-12 col-sm-6 col-md-3 pt-4">
                <div class="footer-label">Về chúng tôi</div>
                <ul>
                    <li><a href="/gioi-thieu">Giới thiệu về MetaMarket</a></li>
                    <li><a href="/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                    <li><a href="/dieu-khoan-dich-vu">Điều khoản và dịch vụ</a></li>
                </ul>
            </div>
            <div class="col col-12 col-sm-6 col-md-3 pt-4">
                <div class="footer-label">Chăm sóc khách hàng</div>
                <ul>
                    <li><a href="/ho-tro-khach-hang">Trung tâm hỗ trợ khách hàng</a></li>
                    <li><a href="/chinh-sach-giao-hang">Chính sách giao hàng</a></li>
                    <li><a href="/chinh-sach-thanh-toan">Chính sách thanh toán</a></li>
                    <li><a href="/chinh-sach-doi-tra">Chính sách đổi trả</a></li>
                    <li><a href="/chinh-sach-uu-dai">Chính sách ưu đãi</a></li>
                </ul>
            </div>
            <div class="col col-12 col-sm-6 col-md-3 pt-4">
                <div class="footer-label">Hỗ trợ</div>
                <ul>
                    <li><b><a href="/dang-ky-ban-hang" style="color: var(--bs-orange) !important;">Đăng ký bán hàng cùng MetaMarket</a></b></li>
                    <?php echo "<li>Tổng đài: <b><a href='tel:" . CONTACT_PHONE . "'>" . CONTACT_PHONE . "</a></b> (7:00 - 21:00)</li>"; ?>
                    <li>Email: cskh@metamarket.com</li>
                </ul>
            </div>
        </div>
    </div>
    <p class="text-center py-3 mb-0 text-gray" style="border-top: solid 1px #666;">Copyright ©2021, MetaMarket Inc. All rights reserved.</p>
</footer>