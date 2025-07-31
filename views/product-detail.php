<?php
$page_title = isset($product) ? $product['name'] . " - Shop Điện Tử" : "Chi tiết sản phẩm - Shop Điện Tử";
require_once './views/layout/header.php';
?>

<div class="container py-4">
    <?php if (isset($product) && $product): ?>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=products">Sản phẩm</a></li>
            <?php if (isset($category) && $category): ?>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['name']; ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $product['image']; ?>" class="d-block w-100" alt="<?php echo $product['name']; ?>" style="height: 400px; object-fit: contain;">
                            </div>
                            <!-- Có thể thêm nhiều hình ảnh khác nếu có -->
                        </div>
                        <?php if (false): /* Chỉ hiển thị nút điều hướng khi có nhiều hình ảnh */ ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (false): /* Chỉ hiển thị thumbnails khi có nhiều hình ảnh */ ?>
                    <div class="row mt-3">
                        <div class="col-4">
                            <img src="<?php echo $product['image']; ?>" class="img-thumbnail" alt="Thumbnail 1" data-bs-target="#productCarousel" data-bs-slide-to="0">
                        </div>
                        <!-- Có thể thêm nhiều thumbnails khác nếu có -->
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3"><?php echo $product['name']; ?></h1>
                    <div class="mb-3">
                        <span class="badge bg-success me-2">Còn hàng</span>
                        <span class="text-muted">Mã sản phẩm: <?php echo $product['id']; ?></span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <span>(5 đánh giá)</span>
                    </div>
                    
                    <h2 class="text-primary mb-3"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</h2>
                    
                    <div class="mb-4">
                        <h5>Mô tả ngắn:</h5>
                        <p><?php echo substr($product['description'], 0, 200); ?>...</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Thông tin sản phẩm:</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Danh mục:</span>
                                <span><?php echo isset($category) ? $category['name'] : 'Chưa phân loại'; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Thương hiệu:</span>
                                <span><?php echo !empty($product['brand']) ? $product['brand'] : 'Không có thông tin'; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tình trạng:</span>
                                <span>Còn hàng</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" id="quantity" value="1" min="1">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                        <button class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-heart me-2"></i>Yêu thích
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Description Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Mô tả chi tiết</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Đánh giá (5)</button>
                        </li>
                    </ul>
                    <div class="tab-content p-3" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <h4><?php echo $product['name']; ?></h4>
                            <div>
                                <?php echo $product['description']; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <h4>Đánh giá từ khách hàng</h4>
                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                            
                            <div class="card mt-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Viết đánh giá của bạn</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="reviewName" class="form-label">Tên của bạn</label>
                                            <input type="text" class="form-control" id="reviewName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="reviewEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá</label>
                                            <div>
                                                <i class="far fa-star fs-4 me-1"></i>
                                                <i class="far fa-star fs-4 me-1"></i>
                                                <i class="far fa-star fs-4 me-1"></i>
                                                <i class="far fa-star fs-4 me-1"></i>
                                                <i class="far fa-star fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewText" class="form-label">Nội dung đánh giá</label>
                                            <textarea class="form-control" id="reviewText" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
     
     <!-- Related Products -->
     <?php if (isset($relatedProducts) && count($relatedProducts) > 0): ?>
     <div class="row mt-5">
         <div class="col-12">
             <h3 class="mb-4">Sản phẩm liên quan</h3>
             <div class="row">
                 <?php foreach ($relatedProducts as $relatedProduct): ?>
                 <div class="col-md-3 mb-4">
                     <div class="card h-100">

                         <img src="<?php echo $relatedProduct['image']; ?>" class="card-img-top" alt="<?php echo $relatedProduct['name']; ?>" style="height: 200px; object-fit: cover;">
                         <div class="card-body d-flex flex-column">
                             <h5 class="card-title"><?php echo $relatedProduct['name']; ?></h5>
                             <p class="card-text flex-grow-1"><?php echo substr($relatedProduct['description'], 0, 60); ?>...</p>
                             <p class="text-primary fw-bold"><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?> ₫</p>
                             <a href="<?php echo BASE_URL; ?>?act=product-detail&id=<?php echo $relatedProduct['id']; ?>" class="btn btn-primary w-100 mt-2">Xem chi tiết</a>
                         </div>
                     </div>
                 </div>
                 <?php endforeach; ?>
             </div>
         </div>
     </div>
     <?php endif; ?>
     <?php else: ?>
     <div class="alert alert-warning" role="alert">
         Không tìm thấy thông tin sản phẩm!
     </div>
     <?php endif; ?>
</div>

<?php
require_once './views/layout/footer.php';
?>