<?php
require_once _DIR_ROOT . '/utils/Format.php';
$staticUrl = STATIC_FILE_URL;
$productAvt = $productDetailDocs->product->avt;
// global $shop;
?>

<div class='container pt-4 mb-4'>
    <div class='bg-white p-4'>
        <h1 class='shop-title'>Cập nhật sản phẩm</h1>

        <form action='/kenh-ban-hang/san-pham/cap-nhat/post' id='updateProductForm' method='POST' enctype='multipart/form-data'>
            <h2 class='sub-title'>Cập nhật thông tin cơ bản</h2>
            <div class='row g-4'>
                <!-- Name -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='name' class='form-label'>Tên <span class='required'>(*)</span></label>
                    <?php echo "<input type='text' name='name' class='form-control' id='name' value='" . $productDetailDocs->product->name . "'>"; ?>
                </div>
                <!-- Catalog, category -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='catalog' class='form-label'>Danh mục <span class='required'>(*)</span></label>
                    <select class='form-select' name='catalog'>
                        <option disabled selected>Chọn danh mục</option>
                        <?php
                        foreach ($catalogs as $catalog) {
                            $categories = $catalog->categories;
                            $catalogId = $catalog->_id;
                            $catalogName = $catalog->name;

                            echo "<optgroup label='$catalogName'>";
                            foreach ($categories as $cate) {
                                $cateId = $cate->id;
                                $cateName = $cate->name;
                                if ($productDetailDocs->product->catalogId->name == $catalogName && $productDetailDocs->product->categoryId) {
                                    echo "<option value='$catalogId/$cateId' selected>$cateName</option>";
                                } else {
                                    echo "<option value='$catalogId/$cateId'>$cateName</option>";
                                }
                            }
                            echo "</optgroup>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Price -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='price' class='form-label'>Giá <span class='required'>(*)</span></label>
                    <?php echo "<input type='number' name='price' min='0' class='form-control' id='price' value='" . $productDetailDocs->product->price . "'>"; ?>
                </div>
                <!-- Stock -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='stock' class='form-label'>SL tồn kho <span class='required'>(*)</span></label>
                    <?php echo "<input type='number' name='stock' min='0' class='form-control' id='stock' value='" . $productDetailDocs->product->stock . "'>"; ?>
                </div>
                <!-- Discount -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='discount' class='form-label'>Khuyến mại (%)</label>
                    <?php echo "<input type='number' name='discount' min='0' max='100' class='form-control' id='discount' value='" . $productDetailDocs->product->discount . "'>"; ?>
                </div>
                <!-- Unit -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='unit' class='form-label'>Đơn vị <span class='required'>(*)</span></label>
                    <?php echo "<input type='text' name='unit' class='form-control' id='unit' placeholder='VD: Cái' value='" . $productDetailDocs->product->discount . "'>"; ?>
                </div>
                <!-- MFG -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='mfg' class='form-label'>Ngày sản xuất <span class='required'>(*)</span></label>
                    <?php echo "<input type='date' name='mfg' class='form-control' id='mfg' value='" . FormatUtil::ISOChangeTimeZone($productDetailDocs->product->mfg, 'Y-m-d') . "'>"; ?>
                </div>
                <!-- EXP -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='exp' class='form-label'>Ngày hết hạn <span class='required'>(*)</span></label>
                    <?php echo "<input type='date' name='exp' class='form-control' id='exp' value='" . FormatUtil::ISOChangeTimeZone($productDetailDocs->product->exp, 'Y-m-d') . "'>"; ?>
                </div>
                <!-- Avt -->
                <div class='flex-center mb-4 mt-5'>
                    <?php
                    $productAvt = empty($productDetailDocs->product->avt) ? DEFAULT_PRODUCT_AVT : STATIC_FILE_URL . '/' . $productDetailDocs->product->avt;
                    echo "<img src='$productAvt' id='avtImg' alt='Logo' class='rounded-circle' style='width: 15rem; height: 15rem;'>";
                    ?>
                </div>

                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='avt' class='form-label'>Đổi ảnh đại diện <span class='required'>(*)</span></label>
                    <input name='avt' class='form-control' type='file' id='avt' accept='image/*'>
                </div>
            </div>

            <h2 class='sub-title mt-5'>Thông tin chi tiết</h2>
            <div class='row g-4'>
                <!-- Origin -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='origin' class='form-label'>Xuất xứ <span class='required'>(*)</span></label>
                    <?php echo "<input type='text' name='origin' class='form-control' id='origin' placeholder='VD: Việt Nam' value='" . $productDetailDocs->productDetail->origin . "'>"; ?>
                </div>

                <!-- Branch -->
                <div class='col col-12 col-md-4 col-lg-3'>
                    <label for='brand' class='form-label'>Thương hiệu <span class='required'>(*)</span></label>
                    <?php echo "<input type='text' name='brand' class='form-control' id='brand' value='" . $productDetailDocs->productDetail->brand . "'>"; ?>
                </div>

                <!-- Infos -->
                <!-- <div class='col col-12 col-md-4 col-lg-3 d-flex align-items-end' id='addInfoWrap'>
                    <button id='addInfoInputBtn' class='btn btn-outline-accent w-100' type='button' style='border-style: dashed;'>
                        Thêm thông tin <i class='bi bi-plus'></i>
                    </button>
                </div> -->
            </div>

            <!-- Photos -->
            <div class='col col-12 col-md-6 col-lg-5 product-photo'>
                <div class='avt p-4'>
                    <?php echo "<img id='photoAvt' src='$staticUrl/$productAvt' alt=''>"; ?>
                </div>

                <?php if (!empty($productDetailDocs->productDetail->photos)) {
                    $photos = $productDetailDocs->productDetail->photos;
                ?>
                    <div class='photos'>
                        <?php
                        $avtThumb = ImageUtil::toThumbnail("$staticUrl/$productAvt");
                        echo "<div class='photo-item active'>
                                <img src='$avtThumb'>
                            </div>";

                        foreach ($photos as $photoSrc) {
                            $photoThumb = ImageUtil::toThumbnail("$staticUrl/$photoSrc");
                            echo "<div class='photo-item'>
                                    <img src='$photoThumb'>
                                </div>";
                        }

                        ?>
                    </div>
                <?php } ?>
            </div>
            <h2 class='sub-title mt-5'>Thêm hình ảnh sản phẩm</h2>
            <input name='photos[]' class='form-control' multiple type='file' id='photos' accept='image/*'>

            <h2 class='sub-title mt-5'>Mô tả sản phẩm</h2>
            <textarea class='validate-ignore' cols='20' id='desc'><?php echo $productDetailDocs->productDetail->desc ?></textarea>
            <input name="desc" id='descInput' type="text" class='d-none' />

            <!-- submit button -->
            <div class='text-end mt-4'>
                <button class='btn btn-danger btn-lg me-3' type='button' type='button' id='resetBtn'>
                    Nhập lại
                </button>
                <button class='btn btn-primary btn-lg' type='submit' type='button' id='submitBtn'>
                    Thêm sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($isError)) {
    require_once _DIR_ROOT . '/app/views/mixins/toast.php';
    if ($isError) {
        renderToast('Thêm sản phẩm thất bại', true, true, true);
    } else {
        renderToast('Thêm sản phẩm thành công', true, true, false);
    }

    echo "<script>setTimeout(() => { window.location.href = '/kenh-ban-hang/san-pham/them' }, 2000)</script>";
}
?>