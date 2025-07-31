<?php
require_once './controllers/UserController.php';

class AdminController {
    private $userModel;
    private $productModel;
    private $categoryModel;
    private $userController;
    
    public function __construct() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Khởi tạo các model
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        
        // Khởi tạo các controller
        $this->userController = new UserController();
    }
    
    /**
     * Kiểm tra quyền admin
     */
    private function checkAdminPermission() {
        // Nếu chưa đăng nhập hoặc không phải admin, chuyển hướng về trang chủ
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    
    /**
     * Hiển thị trang dashboard
     */
    public function Dashboard() {
        $page_title = "Dashboard - Quản lý Shop Điện Tử";
        
        // Lấy thông tin thống kê
        $totalProducts = $this->productModel->countProducts();
        $totalCategories = $this->categoryModel->countCategories();
        $totalUsers = $this->userModel->countUsers();
        
        // Lấy danh sách sản phẩm mới nhất
        $latestProducts = $this->productModel->getLatestProducts(5);
        
        // Hiển thị trang dashboard
        require_once './views/admin/dashboard.php';
    }
    
    /**
     * Quản lý sản phẩm
     */
    public function Products() {
        $page_title = "Quản lý sản phẩm - Shop Điện Tử";
        
        // Lấy danh sách sản phẩm
        $products = $this->productModel->getAllProducts();
        
        // Hiển thị trang quản lý sản phẩm
        require_once './views/admin/products.php';
    }
    
    /**
     * Quản lý danh mục
     */
    public function Categories() {
        $page_title = "Quản lý danh mục - Shop Điện Tử";
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAllCategories();
        
        // Hiển thị trang quản lý danh mục
        require_once './views/admin/categories.php';
    }
    
    /**
     * Quản lý người dùng
     */
    public function Users() {
        $page_title = "Quản lý người dùng - Shop Điện Tử";
        
        // Lấy danh sách người dùng
        $users = $this->userModel->getAllUsers();
        
        // Xử lý các hành động
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    $this->userController->AdminUsers();
                    return;
                case 'edit':
                    $this->userController->AdminUsers();
                    return;
                case 'delete':
                    $this->userController->AdminUsers();
                    return;
            }
        }
        
        // Hiển thị trang quản lý người dùng
        require_once './views/admin/users.php';
    }
}