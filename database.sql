-- Tạo database
CREATE DATABASE IF NOT EXISTS `poly_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `poly_shop`;

-- Tạo bảng categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho bảng categories
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Laptop', 'Các loại máy tính xách tay'),
(2, 'Điện thoại', 'Các loại điện thoại di động'),
(3, 'Máy tính bảng', 'Các loại máy tính bảng'),
(4, 'Phụ kiện', 'Các loại phụ kiện điện tử'),
(5, 'TV & Màn hình', 'Các loại TV và màn hình máy tính'),
(6, 'Thiết bị thông minh', 'Các loại thiết bị điện tử thông minh');

-- Thêm dữ liệu mẫu cho bảng products
INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category_id`, `featured`) VALUES
(1, 'Laptop Pro 2023', 25990000, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1026&q=80', 'Laptop cao cấp với cấu hình mạnh mẽ, Core i7, 16GB RAM, 512GB SSD', 1, 1),
(2, 'Laptop 2-in-1', 19990000, 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1168&q=80', 'Laptop lai máy tính bảng, Core i5, 8GB RAM, 256GB SSD', 1, 1),
(3, 'Điện thoại X Pro', 32990000, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1160&q=80', 'Điện thoại cao cấp với camera 108MP, 8GB RAM, 256GB bộ nhớ', 2, 1),
(4, 'Tai nghe không dây', 3990000, 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80', 'Tai nghe không dây với công nghệ chống ồn chủ động, Bluetooth 5.2', 4, 1),
(5, 'Máy tính bảng Pro', 16990000, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80', 'Máy tính bảng màn hình 11 inch, chip mạnh mẽ, 8GB RAM, 256GB bộ nhớ', 3, 0),
(6, 'Smart TV 4K 55"', 13990000, 'https://images.unsplash.com/photo-1593784991095-a205069470b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80', 'Smart TV 4K 55 inch với hệ điều hành thông minh, âm thanh vòm', 5, 0),
(7, 'Đồng hồ thông minh', 4990000, 'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1172&q=80', 'Đồng hồ thông minh với màn hình AMOLED, đo SpO2, theo dõi sức khỏe 24/7', 6, 0),
(8, 'Điện thoại Y Lite', 3990000, 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2227&q=80', 'Điện thoại giá rẻ với hiệu năng ổn định, 4GB RAM, 64GB bộ nhớ', 2, 0);

-- Thêm dữ liệu mẫu cho bảng users
INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `phone`, `address`, `role`) VALUES
(1, 'admin', '$2y$10$dVMpvO1JBEXdVq5hWVRT1eRCvfEH.w2PVS.o/VMUxFLAkIz2mVET2', 'admin@example.com', 'Administrator', '0987654321', 'Hà Nội', 'admin');
-- Mật khẩu: admin123