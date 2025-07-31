<?php
require_once './models/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    // Phương thức kiểm tra quyền admin
    private function checkAdminPermission() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    /**
     * Hiển thị trang đăng nhập
     */
    public function Login() {
        $title = "Đăng nhập - Shop Điện Tử";
        $error = "";
        $username = "";
        
        // Xử lý đăng nhập khi form được gửi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            // Validate dữ liệu
            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin";
            } else {
                // Thực hiện đăng nhập
                $user = $this->userModel->login($username, $password);
                
                if ($user) {
                    // Đăng nhập thành công, lưu thông tin vào session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Nếu chọn "Ghi nhớ đăng nhập", lưu cookie
                    if ($remember) {
                        $token = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên
                        setcookie('remember_token', $token, time() + 30 * 24 * 60 * 60, '/'); // Cookie hết hạn sau 30 ngày
                        
                        // Lưu token vào database (trong thực tế nên có bảng riêng để lưu token)
                        // $this->userModel->saveRememberToken($user['id'], $token);
                    }
                    
                    // Chuyển hướng đến trang chủ
                    header("Location: " . BASE_URL);
                    exit;
                } else {
                    $error = "Tên đăng nhập hoặc mật khẩu không đúng";
                }
            }
        }
        
        // Hiển thị trang đăng nhập
        require_once './views/login.php';
    }
    
    /**
     * Hiển thị trang đăng ký
     */
    public function Register() {
        $title = "Đăng ký tài khoản - Shop Điện Tử";
        $error = "";
        $success = "";
        
        // Khởi tạo biến để giữ giá trị form
        $formData = [
            'fullname' => '',
            'email' => '',
            'phone' => '',
            'username' => '',
            'address' => ''
        ];
        
        // Xử lý đăng ký khi form được gửi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $formData = [
                'fullname' => $_POST['fullname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'username' => $_POST['username'] ?? '',
                'address' => $_POST['address'] ?? ''
            ];
            
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $terms = isset($_POST['terms']);
            
            // Validate dữ liệu
            if (empty($formData['fullname']) || empty($formData['email']) || empty($formData['phone']) || 
                empty($formData['username']) || empty($password) || empty($confirm_password)) {
                $error = "Vui lòng nhập đầy đủ thông tin bắt buộc";
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ";
            } elseif (strlen($password) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự";
            } elseif ($password !== $confirm_password) {
                $error = "Xác nhận mật khẩu không khớp";
            } elseif (!$terms) {
                $error = "Bạn phải đồng ý với điều khoản sử dụng";
            } else {
                // Thực hiện đăng ký
                $result = $this->userModel->register(
                    $formData['username'],
                    $password,
                    $formData['email'],
                    $formData['fullname'],
                    $formData['phone'],
                    $formData['address']
                );
                
                if ($result === true) {
                    // Đăng ký thành công
                    $success = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
                    // Reset form data
                    $formData = [
                        'fullname' => '',
                        'email' => '',
                        'phone' => '',
                        'username' => '',
                        'address' => ''
                    ];
                } else {
                    // Đăng ký thất bại
                    $error = $result; // Hiển thị lỗi từ model
                }
            }
        }
        
        // Hiển thị trang đăng ký
        require_once './views/register.php';
    }
    
    /**
     * Đăng xuất người dùng
     */
    public function Logout() {
        // Xóa session
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['fullname']);
        unset($_SESSION['role']);
        
        // Xóa cookie ghi nhớ đăng nhập nếu có
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/'); // Xóa cookie
        }
        
        // Chuyển hướng về trang chủ
        header("Location: " . BASE_URL);
        exit;
    }
    
    // Phương thức quản lý người dùng cho admin
    public function AdminUsers() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Xử lý các hành động
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    $this->addUser();
                    break;
                case 'edit':
                    $this->editUser();
                    break;
                case 'delete':
                    $this->deleteUser();
                    break;
            }
        }
        
        // Lấy danh sách người dùng
        $users = $this->userModel->getAllUsers();
        
        // Hiển thị trang quản lý người dùng
        require_once './views/admin/users.php';
    }
    
    // Thêm người dùng mới (từ trang admin)
    private function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'user';
            
            // Kiểm tra dữ liệu
            $errors = [];
            
            if (empty($username)) {
                $errors[] = 'Tên đăng nhập không được để trống';
            }
            
            if (empty($fullname)) {
                $errors[] = 'Họ tên không được để trống';
            }
            
            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            if (empty($password)) {
                $errors[] = 'Mật khẩu không được để trống';
            }
            
            // Nếu không có lỗi, thêm người dùng mới
            if (empty($errors)) {
                $result = $this->userModel->register(
                    $username,
                    $password,
                    $email,
                    $fullname,
                    $phone,
                    $address,
                    $role
                );
                
                if ($result === true) {
                    $_SESSION['success_message'] = 'Thêm người dùng thành công';
                } else {
                    $_SESSION['error_message'] = $result; // Hiển thị lỗi từ model
                }
            } else {
                $_SESSION['error_message'] = implode('<br>', $errors);
            }
            
            // Chuyển hướng về trang quản lý người dùng
            header('Location: ' . BASE_URL . '?act=admin&section=users');
            exit;
        }
    }
    
    // Sửa thông tin người dùng (từ trang admin)
    private function editUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $id = $_POST['id'] ?? 0;
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $password = $_POST['password'] ?? '';
            
            // Kiểm tra dữ liệu
            $errors = [];
            
            if (empty($fullname)) {
                $errors[] = 'Họ tên không được để trống';
            }
            
            if (empty($email)) {
                $errors[] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            // Nếu không có lỗi, cập nhật thông tin người dùng
            if (empty($errors)) {
                $userData = [
                    'id' => $id,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'role' => $role
                ];
                
                // Nếu có mật khẩu mới, thêm vào dữ liệu cập nhật
                if (!empty($password)) {
                    $userData['password'] = $password;
                }
                
                $result = $this->userModel->updateUser($userData);
                
                if ($result === true) {
                    $_SESSION['success_message'] = 'Cập nhật thông tin người dùng thành công';
                } else {
                    $_SESSION['error_message'] = $result; // Hiển thị lỗi từ model
                }
            } else {
                $_SESSION['error_message'] = implode('<br>', $errors);
            }
            
            // Chuyển hướng về trang quản lý người dùng
            header('Location: ' . BASE_URL . '?act=admin&section=users');
            exit;
        }
    }
    
    // Xóa người dùng (từ trang admin)
    private function deleteUser() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            
            // Không cho phép xóa chính mình
            if ($id == $_SESSION['user_id']) {
                $_SESSION['error_message'] = 'Bạn không thể xóa tài khoản của chính mình';
            } else {
                $result = $this->userModel->deleteUser($id);
                
                if ($result === true) {
                    $_SESSION['success_message'] = 'Xóa người dùng thành công';
                } else {
                    $_SESSION['error_message'] = $result; // Hiển thị lỗi từ model
                }
            }
            
            // Chuyển hướng về trang quản lý người dùng
            header('Location: ' . BASE_URL . '?act=admin&section=users');
            exit;
        }
    }
}