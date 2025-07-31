<?php
// Sử dụng layout admin
require_once './views/admin/layout/header.php';
?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-muted">Tổng sản phẩm</h6>
                            <h2 class="card-title mb-0"><?php echo $totalProducts; ?></h2>
                        </div>
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="<?php echo BASE_URL; ?>?act=admin&section=products" class="btn btn-sm btn-outline-primary mt-3">Xem chi tiết</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-muted">Tổng danh mục</h6>
                            <h2 class="card-title mb-0"><?php echo $totalCategories; ?></h2>
                        </div>
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="<?php echo BASE_URL; ?>?act=admin&section=categories" class="btn btn-sm btn-outline-primary mt-3">Xem chi tiết</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card card-stat h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-muted">Tổng người dùng</h6>
                            <h2 class="card-title mb-0"><?php echo $totalUsers; ?></h2>
                        </div>
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?php echo BASE_URL; ?>?act=admin&section=users" class="btn btn-sm btn-outline-primary mt-3">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Thống kê doanh số theo tháng</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Phân bố sản phẩm theo danh mục</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Latest Products -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Sản phẩm mới nhất</h5>
                    <a href="<?php echo BASE_URL; ?>?act=admin&section=products" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Nổi bật</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($latestProducts) && count($latestProducts) > 0): ?>
                                    <?php foreach ($latestProducts as $product): ?>
                                        <tr>
                                            <td><?php echo $product['id']; ?></td>
                                            <td>
                                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" width="50">
                                            </td>
                                            <td><?php echo $product['name']; ?></td>
                                            <td><?php echo $product['category_name']; ?></td>
                                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</td>
                                            <td>
                                                <?php if ($product['featured'] == 1): ?>
                                                    <span class="badge bg-success">Có</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Không</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>?act=admin&section=products&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>?act=admin&section=products&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Không có sản phẩm nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './views/admin/layout/footer.php'; ?>