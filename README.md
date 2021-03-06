<h1 align="center">MetaMarket Project</h1>

<div  align="center">
  <img src="https://res.cloudinary.com/dynonary/image/upload/v1649991439/metamarket/logo.svg" alt="Logo" />
</div>

> Ứng dụng đi chợ Online - Đồ án môn Ứng dụng phân tán - Microservice Architecture

# Giới thiệu dự án

> **Mục tiêu**

Một công ty đầu tư thương mại ABC muốn xây dựng hệ thống kết nối giữa bên mua và bên bán các mặt hàng thiết yếu. Trong bối cảnh dịch bệnh diễn biến phức tạp, người dùng có nhu cầu mua các mặt hàng sản phẩm thiết yếu như thịt, cá, rau, củ,…. Những thực phẩm này được cung cấp bởi các nhà cung cấp uy tín trên thị trường.

Công ty ABC là bên đầu tư hệ thống phần mềm để quản lý các dịch vụ này, mục tiêu là cung cấp dịch vụ tốt nhất cho người mua và người bán, công ty muốn xây dựng và quản lý hệ thống cung cấp các dịch vụ như đăng kí bán hàng, đăng ký mua hàng, giao hàng, và các dịch vụ khác. Công ty sẽ thu phí dựa trên số lượng hóa đơn phát sinh, doanh thu chủ yếu công ty sẽ đến từ hoạt động chính này. Phấn tiếp theo sẽ mô tả các quy trình trong dự án.

> **Yêu cầu công nghệ**

PHP, HTML, JS, CSS dùng để xây dựng trang web với các chức năng cơ bản như: login, logout, thông tin liên hệ,…

Java framework (NodeJS ...) dùng để xây dựng API, trả dữ liệu về bên website, giao tiếp với API theo hướng đồng bộ. Các API cũng trao đổi message với nhau theo hướng bất đồng bộ phụ thuộc vào chức năng. Cần có API gateway để quản lý nhiều API khác trong trường hợp một chức năng gọi trên 3 API

# Thông tin nhóm

> **MetaMarket Team**

- 18120580 - Đinh Quang Thọ
- 18120606 - Trần Thị Trang
- 18120609 - Hồ Khắc Minh Trí
- 18120634 - Nguyễn Lê Anh Tuấn (Nhóm trưởng)

# Công nghệ phát triển

> **Static File Server**

- Nginx

> **Client Side**

- HTML, CSS, JS
- JQuery v3.6.0
- Bootstrap 5

> **Backend Server**

- PHP thuần
- Apache Server
- MVC Model

> **API Server**

- Kiến trúc Microservices
- [Moleculer Framework](https://moleculer.services/docs/0.14/index.html) v0.14.16 (NodeJS)
- MongoDB v5.0.6, MongooseJS
- MySQL v8.0, Sequelize
- Socket.io

> **Development Tools**

- VSCode Editor
- Git, Github
- Slack

> **Deyloying**

- Docker
- Transporter - NATS Server

# Kiến trúc hệ thống

### **Use Case Diagram**

<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1652197093/metamarket/UC-Diagram.png" /></div>

### **Microservices Architecture**

<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1652197017/metamarket/Microservice_Architecture.jpg" /></div>

### **Database Diagram**

<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1652197204/metamarket/DB-Diagram.jpg" /></div>

# Hướng dẫn chạy

> **Static file server (Nginx)**

- Không bắt buộc, nhưng có thể dùng Nginx để serve static file server để giảm tải cho client
- _public_host_path_ là đường dẫn đến thư mục _public_ chứa resource của client
- Thay đổi .env bên client **STATIC_FILE_URL="http://localhost:4000"**

```sh
  docker pull nginx:latest
  docker run --name nginx -d -p 4000:80 -v {public_host_path}:/usr/share/nginx/html:ro nginx:latest
```

> **Client**

- Đã cài PHP (version >= 8), bật các extensions sau trong file `php.ini` hoặc `php-development.ini` [Tham khảo](https://www.php.net/manual/en/install.pecl.windows.php):

  - curl
  - mysqli
  - pdo_mysql
  - gd
  - openssl
  - Thay đổi giá trị sau:
    - upload_max_filesize = 25M

- Cài php [Composer](https://getcomposer.org/download/)

```sh
  cd client/src
  composer install

  # Tạo file .env từ file .local.env
  # Chỉnh sửa giá trị phù hợp
  cp .local.env .env

  php -S localhost:8080
```

> **Server**

- B1: Cài đặt các cơ sở dữ liệu (có thể cài bên ngoài máy host thay vì dùng docker)
- **{host_path}** Nơi lưu trữ DB bền vững ngoài host.

```sh
  # Mongodb (Thay {host_path} thành nơi lưu dữ liệu cho MongoDB)
  docker run --name mongodb -h mongodb -p 27017:27017 -v {host_path}:/data/db -d mongo:5.0.6

  # MySQL v8.0 (Thay {host_path} thành nơi lưu dữ liệu cho MySQL # MongoDB)
  docker network create mysql_network
  docker run --name mysql -h mysql -p 3306:3306 -v {host_path}:/var/lib/mysql -e MYSQL_ROOT_PASSWORD={MY_PASSWORD} --network mysql_network -d mysql:8.0.28

  # PHP Myadmin nếu cần, truy cập tại port 9999
  docker run --name pma -p 9999:80 -e PMA_ARBITRARY=1 --network mysql_network -d phpmyadmin:5.1.3
  # Truy cập http://localhost:9999 > server = mysql, username = root, password = {MY_PASSWORD}
```

- B2: Tạo các CSDL, thêm dữ liệu mẫu (nếu có)

- Chạy các services (Nên dùng yarn thay cho npm)

```sh
  cd server

  npm install
  # hoặc yarn install

  # Tạo file .env từ file .local.env
  # Chỉnh sửa giá trị phù hợp
  cp .local.env .env

  # Khởi chạy
  npm run dev
  # yarn dev
```

> **Thông tin dùng kiểm thử**

- Test thanh toán bằng MoMo ATM, [xem tại đây](https://developers.momo.vn/v3/vi/docs/payment/onboarding/test-instructions/)

<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1652176343/metamarket/momo-test.jpg" /></div>

# Kết quả sau khi chạy

<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture5.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture6.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture7.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture8.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture9.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture10.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture11.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture11.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture13.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture14.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture15.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture16.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture17.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture18.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture19.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture20.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture21.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture22.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture23.png" /></div>
<div align="center"><img src="https://res.cloudinary.com/dynonary/image/upload/v1656727391/metamarket/result/Picture24.png" /></div>
