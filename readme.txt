use master;
DROP DATABASE IF EXISTS dbms_mypham;

CREATE DATABASE dbms_mypham;
GO

USE dbms_mypham;
GO

CREATE TABLE Customers (
    CustomerID INT PRIMARY KEY IDENTITY,
    FullName NVARCHAR(255) NOT NULL,
    Email NVARCHAR(255) UNIQUE,
    Password NVARCHAR(255) NOT NULL,
    PhoneNumber NVARCHAR(20) UNIQUE,
    Address NVARCHAR(500) NULL,
    CreatedAt DATETIME DEFAULT GETDATE()
);
GO

CREATE TABLE Products (
    ProductID INT PRIMARY KEY IDENTITY,
    ProductName NVARCHAR(255) NOT NULL,
    Category NVARCHAR(100) NOT NULL,
    Price DECIMAL(18,2) NOT NULL,
    StockQuantity INT NOT NULL,
    ImageURL NVARCHAR(255) NULL,
    Description NVARCHAR(MAX) NULL
);
GO

CREATE TABLE Orders (
    OrderID INT PRIMARY KEY IDENTITY,
    CustomerID INT,
    OrderDate DATETIME DEFAULT GETDATE(),
    TotalAmount DECIMAL(18,2) NOT NULL,
    Status NVARCHAR(50) DEFAULT 'Pending',
	CONSTRAINT FK_Orders_Customers FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);
GO

CREATE TABLE OrderDetails (
    OrderDetailID INT PRIMARY KEY IDENTITY,
    OrderID INT,
    ProductID INT,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(18,2) NOT NULL,
	CONSTRAINT FK_OrderDetails_Orders FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    CONSTRAINT FK_OrderDetails_Products FOREIGN KEY (ProductID) REFERENCES Products(ProductID)
);
GO

INSERT INTO Customers (FullName, Email, Password, PhoneNumber, Address, CreatedAt) VALUES
(N'Nguyễn Hồng Tài', 'hongtai@gmail.com', 'c67a64a7ffbe35d52630241dc1d9e7868fac051bbf656a24ebfacc21c52848a9', '0192857462', N'147 Nguyễn Bỉnh Khiêm, Đa Kao, Quận 1', GETDATE()),
(N'Lê Minh Châu', 'chau.minh@gmail.com', '79cc1628945d51a31fa48dc9c491b2cff10ab91b592ed11dee12b5fcb66a585b', '0912345678', N'23 Lê Lợi, P. Bến Nghé, Quận 1', GETDATE()),
(N'Phạm Thị Hằng', 'hangpham@gmail.com', '2bba76f12818a1688bb295b01bc3267ab04b095fb3a16d959d2ef0d99c7728ad', '0934567890', N'56 Phan Xích Long, P.2, Phú Nhuận', GETDATE()),
(N'Trần Quốc Vinh', 'vinh.tran@gmail.com', '8a37f3bb8c6c26d2e97d19a9484b9537adda0d8287af0ad3bd6620a4ec391078', '0987654321', N'178 Cách Mạng Tháng 8, Quận 10', GETDATE()),
(N'Đỗ Thị Mai', 'maido@gmail.com', '3dbe0c24e30891456bf3a70e11bf3c23c0c4c79c95fd4db7c45f905351d3462c', '0909090909', N'88 Nguyễn Trãi, Quận 5', GETDATE()),
(N'Ngô Bảo Anh', 'anh.ngo@gmail.com', '38e1cb6983563274b94a1969c93b260c2f1a17eb14db1117a3ee4a63364a9507', '0888888888', N'12 Hoàng Sa, Quận 3', GETDATE()),
(N'Bùi Thanh Sơn', 'son.bui@gmail.com', '9e39856ef1c87292f409fb49d8fe1a2e72ef3a8aedab550e2fef05d62c9d6cdc', '0977777777', N'9A Trường Sa, Quận Bình Thạnh', GETDATE()),
(N'Vũ Thị Kim', 'kimvu@gmail.com', '993676af029d586c97602452480abc659ff7e98ae48309ccdae01467f10ea7b7', '0922222222', N'103 Võ Văn Tần, Quận 3', GETDATE()),
(N'Lý Hữu Phúc', 'phucly@gmail.com', '79f44d5a81d5a6ba612c56435ff580be56c0bc4bd87a4f6b023582eddd7abd41', '0966666666', N'15 Nguyễn Văn Cừ, Quận 5', GETDATE()),
(N'Tạ Quang Huy', 'huyta@gmail.com', '22f3da83634f3308c09aec58de5ff52f9abbb6bdee2b928b58a2eeee852d05b6', '0944444444', N'20 Nguyễn Thị Minh Khai, Quận 1', GETDATE()),
(N'Trịnh Gia Huy', 'gia.huy@gmail.com', '0ff2d35f9405eb2a2eec47702c6be383a7d24dce64059d20e9b8c095c7c8d39a', '0933001100', N'45 Nguyễn Thị Diệu, Quận 3', GETDATE()),
(N'Phan Nhật Linh', 'linhphan@gmail.com', '22cc05caf76b9cb716b459a17a7bd32b62a042ba1fae22b22b6cdf966c8c61b1', '0908123456', N'66 Đinh Tiên Hoàng, Quận 1', GETDATE()),
(N'Nguyễn Mỹ Duyên', 'duyen.my@gmail.com', '998536720f615986006c951092cc791411de23364271826f650df4a7375916a6', '0912333444', N'21 Nguyễn Văn Thủ, Quận 1', GETDATE()),
(N'Đặng Văn Cường', 'cuong.dang@gmail.com', 'a8887cd57d0f46e3c1393fab24bcef5098fc7efd3bd3edd0c6c000bff9a0471b', '0978123123', N'102 Bùi Viện, Quận 1', GETDATE()),
(N'Tống Thị Yến', 'yen.tong@gmail.com', 'bf84b4267de65af26e5a8ebcc34c0dd20f1267d1fde0ba14bb9c1c4f5638e4b9', '0944455566', N'72 Nguyễn Khoái, Quận 4', GETDATE()),
(N'Hoàng Ngọc Bích', 'bichhoang@gmail.com', '23e078260c2d8f46b7bbab6fa060fe471b25240228bd9e2859839136309603a0', '0922233445', N'9 Pasteur, Quận 1', GETDATE()),
(N'Võ Minh Tâm', 'tam.vo@gmail.com', '774ea7d16ccc9ff92cebf3fc528a72bc3e5689aa25dd81b0e4decd65f59b55f5', '0988111222', N'18A Nguyễn Huệ, Quận 1', GETDATE()),
(N'Lê Phước Long', 'long.le@gmail.com', 'fc55b2b99b2fb7d07608584ced908c367a98d3df64930287ae19a32242b4927a', '0966778899', N'33 Nguyễn Thái Học, Quận 1', GETDATE()),
(N'Bành Thanh Thảo', 'thao.banh@gmail.com', 'f813e270b526d6e08995545482e64e7aa8291ef6c0458ad479b12fad0b99a35a', '0911445566', N'19 Lý Tự Trọng, Quận 1', GETDATE()),
(N'Từ Quốc Dũng', 'dungquoc@gmail.com', 'ebf36e97738672826fee66dc24084221f6af0f27f980687d4262ddceada813ab', '0933667788', N'27 Nguyễn Đình Chiểu, Quận 3', GETDATE()),
(N'Ngô Thị Phượng', 'phuong.ngo@gmail.com', 'ee3910d6e126b2441368f8f602257ed2debef1f90825bb8d3bed68df8c00a3bd', '0909456123', N'88 Võ Thị Sáu, Quận 3', GETDATE()),
(N'Châu Minh Tuấn', 'tuan.chau@gmail.com', '601422fba074b521d683f821814c3996f6107591d961f7cd612f7157b43aa3a8', '0977889900', N'45 Điện Biên Phủ, Quận Bình Thạnh', GETDATE()),
(N'Mai Thanh Lan', 'lan.mai@gmail.com', 'b5abfc1711b87fba0fc7fc35c929dea60753c474d2843b499986e86190abfe61', '0955332211', N'60 Nguyễn Thái Bình, Quận 1', GETDATE()),
(N'Trần Văn An', 'an.tran@gmail.com', 'd3e525dc1ccc3fb70c496d615fd2191f4aa4c61e6ba909c70f9b6090336e4fd4', '0988111333', N'12B Nguyễn Trãi, Quận 5', GETDATE()),
(N'Đinh Quang Hải', 'hai.dinh@gmail.com', '8c4dc7ba8ae27651ddc9360984c7aae1ee8c2e09529b851c23e1815ff26afc1d', '0909988776', N'77 Trần Hưng Đạo, Quận 1', GETDATE());

INSERT INTO Products (ProductName, Category, Price, StockQuantity, ImageURL, Description) VALUES
(N'La Roche-Posay Effaclar Gel', N'Chống nắng', 891122.5, 93, 'https://bizweb.dktcdn.net/thumb/1024x1024/100/194/749/products/lrp-04-062.png?v=1615437096107', N'Sản phẩm La Roche-Posay Effaclar Gel thuộc danh mục Chống nắng'),
(N'Anessa Perfect UV Sunscreen', N'Dưỡng da', 296505.08, 91, 'https://product.hstatic.net/1000360941/product/chong-nang-anessa-da-dau_26471733e85c4b89a79a53b5b695f2d6_master.jpg', N'Sản phẩm Anessa Perfect UV Sunscreen thuộc danh mục Dưỡng da, phù hợp với mọi loại da.'),
(N'Some By Mi AHA-BHA-PHA 30 Days Miracle Cream', N'Dưỡng tóc', 440452.81, 84, 'https://images.soco.id/image-0-1600339404094', N'Sản phẩm Some By Mi AHA-BHA-PHA 30 Days Miracle Cream thuộc danh mục Dưỡng tóc.'),
(N'Maybelline Fit Me Matte+Poreless Foundation', N'Nước hoa', 744300.43, 31, 'https://images.soco.id/image-0-1600339404094', N'Sản phẩm Maybelline Fit Me Matte+Poreless Foundation thuộc danh mục Nước hoa, phù hợp với mọi loại da.'),
(N'Bioderma Sensibio H2O', N'Tẩy trang', 282356.62, 22, 'https://dep7ngay.vn/cdn/shop/files/6557039427793-39329502888145.jpg?v=1695385102', N'Sản phẩm Bioderma Sensibio H2O thuộc danh mục Tẩy trang, phù hợp với mọi loại da.'),
(N'Moroccanoil Treatment', N'Chống nắng', 674922.39, 62, 'https://vn.moroccanoil.com/cdn/shop/files/MO_Treatment_Light.jpg?v=1687867928&width=1946', N'Sản phẩm Moroccanoil Treatment thuộc danh mục Chống nắng, phù hợp với mọi loại da.'),
(N'Dior Sauvage Eau de Toilette', N'Trang điểm', 615922.13, 74, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5U1-H-Fa8RavWOWI8qgNEtshRctiqsZNcsw&s', N'Sản phẩm Dior Sauvage Eau de Toilette thuộc danh mục Trang điểm, phù hợp với mọi loại da.'),
(N'Innisfree Jeju Orchid Enriched Cream', N'Dưỡng da', 961344.18, 50, 'https://imua.com.vn/images/Product/Album/Kem-Duong-Da-Innisfree-Orchid-Enriched-Cream-2772.jpg', N'Sản phẩm Innisfree Jeju Orchid Enriched Cream thuộc danh mục Dưỡng da, phù hợp với mọi loại da.'),
(N'MAC Retro Matte Lipstick', N'Khác', 337895.16, 47, 'https://cdn.cosmostore.org/cache/front/shop/products/613/1890842/350x350.jpg', N'Sản phẩm MAC Retro Matte Lipstick thuộc danh mục Khác'),
(N'Simple Micellar Cleansing Water', N'Sửa rửa mặt', 437124.6, 87, 'https://dep7ngay.vn/cdn/shop/files/6573982154961-39431218856145.jpg?v=1697209459', N'Sản phẩm Simple Micellar Cleansing Water thuộc danh mục Sửa rửa mặt, phù hợp với mọi loại da.'),
(N'The Ordinary Niacinamide 10% + Zinc 1%', N'Dưỡng tóc', 302401.95, 56, 'https://ordinary.com.vn/wp-content/uploads/2020/09/The-Ordinary-Niacinamide10-Zinc-1-510x455.jpg', N'Sản phẩm The Ordinary Niacinamide 10% + Zinc 1% thuộc danh mục Dưỡng tóc.'),
(N'Neutrogena Hydro Boost Water Gel', N'Nước hoa', 271911.7, 51, 'https://product.hstatic.net/1000006063/product/dd_gel_b2879746c8d84a22856364fe9f6cbf1a_1024x1024_d012fe69b2ef4492b80518b6023b210f_1024x1024.jpg', N'Sản phẩm Neutrogena Hydro Boost Water Gel thuộc danh mục Nước hoa, phù hợp với mọi loại da.'),
(N'Estee Lauder Advanced Night Repair', N'Chống nắng', 987058.66, 19, 'https://cdn.beeonline.vn/media/2/estee_lauder/serum.jpg', N'Sản phẩm Estee Lauder Advanced Night Repair thuộc danh mục Chống nắng, phù hợp với mọi loại da.'),
(N'Laneige Lip Sleeping Mask', N'Dưỡng da', 1012931.02, 94, 'https://product.hstatic.net/1000360941/product/ngu-moi-laneige_23b55d900f51443ebe221861c0b440e7_master.jpg', N'Sản phẩm Laneige Lip Sleeping Mask thuộc danh mục Dưỡng da, phù hợp với mọi loại da.'),
(N'Clinique Dramatically Different Moisturizing Gel', N'Nước hoa', 749371.29, 45, 'https://hasaki.vn/_next/image?url=https%3A%2F%2Fmedia.hcdn.vn%2Fcatalog%2Fproduct%2Fg%2Fo%2Fgoogle-shopping-gel-duong-am-clinique-danh-cho-da-dau-hon-hop-dau-125ml-1690880580.jpg&w=3840&q=75', N'Sản phẩm Clinique Dramatically Different Moisturizing Gel thuộc danh mục Nước hoa, phù hợp với mọi loại da.'),
(N'Vichy Mineral 89', N'Dưỡng tóc', 940861.91, 61, 'https://medias.watsons.vn/publishing/WTCVN-200419-back-zoom.jpg?version=1740753693', N'Sản phẩm Vichy Mineral 89 thuộc danh mục Dưỡng tóc.'),
(N'Shiseido Ultimune Power Infusing Concentrate', N'Chống nắng', 1042077.41, 91, 'https://www.shiseido.com.vn/dw/image/v2/BCSK_PRD/on/demandware.static/-/Sites-itemmaster_shiseido/default/dwd9b6b41c/images/products/22390/22390_S_01.jpg?sw=1000&sh=1000&sm=fit', N'Sản phẩm Shiseido Ultimune Power Infusing Concentrate thuộc danh mục Chống nắng, phù hợp với mọi loại da.'),
(N'NARS Radiant Creamy Concealer', N'Tẩy trang', 390727.85, 85, 'https://bizweb.dktcdn.net/100/375/006/products/6f3bdc71-50c6-4232-87f9-dc64bb7e1a73.jpg?v=1737345965943', N'Sản phẩm NARS Radiant Creamy Concealer thuộc danh mục Tẩy trang, phù hợp với mọi loại da.'),
(N'The Body Shop Tea Tree Oil', N'Dưỡng da', 742665.75, 95, 'https://down-vn.img.susercontent.com/file/vn-11134207-7r98o-lzimd065dq5ded', N'Sản phẩm The Body Shop Tea Tree Oil thuộc danh mục Dưỡng da, phù hợp với mọi loại da.'),
(N'Kiehl''s Calendula Herbal-Extract Toner', N'Trang điểm', 477097.67, 57, 'https://product.hstatic.net/200000773671/product/thiet_ke_chua_co_ten-56_86d942f9df6b44dfaf02005bbbceb60b_master.png', N'Sản phẩm Kiehl''s Calendula Herbal-Extract Toner thuộc danh mục Trang điểm, phù hợp với mọi loại da.'),
(N'COSRX Advanced Snail 96 Mucin Power Essence', N'Dưỡng tóc', 684423.18, 65, 'https://cdn.thegioididong.com/Products/Images/6562/317531/serum-oc-sen-cosrx-advanced-snail-96-mucin-power-essence-tai-tao-duong-am-da-5.jpg', N'Sản phẩm COSRX Advanced Snail 96 Mucin Power Essence thuộc danh mục Dưỡng tóc.'),
(N'Hada Labo Gokujyun Lotion', N'Sửa rửa mặt', 1135923.11, 32, 'https://kokorojapanstore.com/cdn/shop/products/HAD7c.jpg?v=1747231280', N'Sản phẩm Hada Labo Gokujyun Lotion thuộc danh mục Sửa rửa mặt, phù hợp với mọi loại da.'),
(N'SK-II Facial Treatment Essence', N'Khác', 428532.97, 58, 'https://japana.vn/uploads/japana.vn/product/2021/08/20/1629455337-nuoc-than-sk-ii-facial-treatment-essence-75ml.jpg', N'Sản phẩm SK-II Facial Treatment Essence thuộc danh mục Khác.'),
(N'The Face Shop Rice Water Bright Foam Cleanser', N'Dưỡng da', 427265.4, 89, 'https://japana.vn/uploads/japana.vn/product/2021/08/20/1629455337-nuoc-than-sk-ii-facial-treatment-essence-75ml.jpg', N'Sản phẩm The Face Shop Rice Water Bright Foam Cleanser thuộc danh mục Dưỡng da, phù hợp với mọi loại da.'),
(N'YSL Rouge Pur Couture Lipstick', N'Khác', 534454.41, 84, 'https://kyo.vn/wp-content/uploads/2024/03/Son-YSL-Rouge-Pur-Couture-Caring-Satin-Lipstick-PM-Pink-Muse-1.jpg', N'Sản phẩm YSL Rouge Pur Couture Lipstick thuộc danh mục Khác.'),
(N'Romand Juicy Lasting Tint', N'Tẩy trang', 882304.2, 60, 'https://myphamhalo.vn/wp-content/uploads/2020/02/son-tint-li-romand-juicy-lasting-tint-8.jpg', N'Sản phẩm Romand Juicy Lasting Tint thuộc danh mục Tẩy trang, phù hợp với mọi loại da.'),
(N'Cetaphil Gentle Skin Cleanser', N'Khác', 970087.01, 32, 'https://dep7ngay.vn/cdn/shop/files/6610405621969-39589231067345.jpg?v=1692262958', N'Sản phẩm Cetaphil Gentle Skin Cleanser thuộc danh mục Khác, phù hợp với mọi loại da.'),
(N'Paula''s Choice BHA Liquid Exfoliant', N'Trang điểm', 561280.95, 18, 'https://paulaschoice.vn/wp-content/uploads/2025/03/2010-award-winners-2021.jpg', N'Sản phẩm Paula''s Choice BHA Liquid Exfoliant thuộc danh mục Trang điểm, phù hợp với mọi loại da.'),
(N'Etude House Drawing Eye Brow', N'Tẩy trang', 329760.65, 16, 'https://product.hstatic.net/1000006063/product/1030_ffce5edef9d9455ab711bfd6e660bd31_1024x1024.jpg', N'Sản phẩm Etude House Drawing Eye Brow thuộc danh mục Tẩy trang, phù hợp với mọi loại da.'),
(N'Eucerin ProACNE Solution Toner', N'Sửa rửa mặt', 557696.32, 48, 'https://hasaki.vn/_next/image?url=https%3A%2F%2Fmedia.hcdn.vn%2Fcatalog%2Fproduct%2Fg%2Fo%2Fgoogle-shopping-nuoc-can-bang-eucerin-danh-cho-da-nhon-mun-200ml.jpg&w=3840&q=75', N'Sản phẩm Eucerin ProACNE Solution Toner thuộc danh mục Sửa rửa mặt, phù hợp với mọi loại da.');

INSERT INTO Orders (CustomerID, OrderDate, TotalAmount, Status) VALUES
(5, '2025-04-27 15:25:23', 1489713.95, N'Pending'),
(3, '2025-05-14 15:25:23', 1676013.39, N'Cancelled'),
(5, '2025-05-03 15:25:23', 1038144.43, N'Pending'),
(17, '2025-05-09 15:25:23', 1334239.82, N'Cancelled'),
(7, '2025-05-16 15:25:23', 800362.85, N'Completed'),
(20, '2025-04-28 15:25:23', 2765672.67, N'Cancelled'),
(4, '2025-05-05 15:25:23', 2928463.94, N'Pending'),
(15, '2025-05-11 15:25:23', 2716584.38, N'Pending'),
(12, '2025-04-28 15:25:23', 2715711.81, N'Pending'),
(22, '2025-05-07 15:25:23', 1348257.32, N'Pending'),
(12, '2025-04-17 15:25:23', 944872.41, N'Completed'),
(14, '2025-04-29 15:25:23', 1910888.72, N'Cancelled'),
(2, '2025-04-20 15:25:23', 1734213.92, N'Cancelled'),
(7, '2025-05-07 15:25:23', 1324633.76, N'Pending'),
(5, '2025-04-30 15:25:23', 1280870.24, N'Completed'),
(21, '2025-05-13 15:25:23', 1615505.17, N'Cancelled'),
(3, '2025-05-06 15:25:23', 2258852.16, N'Completed'),
(10, '2025-05-07 15:25:23', 918633.28, N'Pending'),
(9, '2025-05-03 15:25:23', 2644519.11, N'Pending'),
(2, '2025-04-24 15:25:23', 1178438.35, N'Completed'),
(14, '2025-04-27 15:25:23', 2213948.71, N'Completed'),
(11, '2025-05-08 15:25:23', 779143.14, N'Cancelled'),
(21, '2025-04-17 15:25:23', 2894551.26, N'Pending'),
(6, '2025-05-02 15:25:23', 1058962.85, N'Pending'),
(9, '2025-04-28 15:25:23', 2894217.32, N'Completed'),
(5, '2025-05-03 15:25:23', 2560066.11, N'Cancelled'),
(22, '2025-04-30 15:25:23', 2573497.75, N'Cancelled'),
(2, '2025-05-07 15:25:23', 2478158.41, N'Pending'),
(23, '2025-04-26 15:25:23', 398904.28, N'Cancelled'),
(24, '2025-05-14 15:25:23', 2724395.53, N'Pending');

INSERT INTO OrderDetails (OrderID, ProductID, Quantity, UnitPrice) VALUES
(9, 5, 5, 921019.52),
(4, 17, 2, 839903.35),
(21, 24, 3, 432122.76),
(13, 1, 3, 265753.82),
(22, 7, 1, 620019.27),
(26, 11, 4, 532149.02),
(24, 3, 1, 1141164.14),
(11, 21, 1, 531244.47),
(1, 23, 4, 625603.51),
(23, 18, 5, 336218.33),
(16, 11, 1, 816078.97),
(29, 13, 2, 674134.16),
(18, 5, 3, 808503.48),
(24, 17, 3, 549259.74),
(11, 30, 5, 172113.18),
(9, 19, 2, 773695.02),
(4, 16, 2, 504503.63),
(4, 29, 4, 293220.5),
(2, 4, 2, 411948.23),
(24, 28, 5, 242905.71),
(23, 16, 1, 195947.84),
(27, 26, 1, 640396.2),
(16, 12, 3, 523173.3),
(19, 10, 3, 407439.29),
(15, 21, 2, 846659.38),
(16, 19, 4, 163298.89),
(14, 12, 2, 463035.24),
(22, 16, 2, 239208.12),
(18, 21, 3, 304305.24),
(20, 20, 4, 927751.99),
(14, 4, 3, 1183148.65),
(20, 24, 3, 513761.46),
(18, 10, 2, 912127.65);
GO

-- //////////////////////////////////PROCEDURE///////////////////////////////////////////

-- Thêm khách hàng mới
CREATE PROCEDURE sp_AddCustomer
    @FullName NVARCHAR(255),
    @Email NVARCHAR(255),
    @Password NVARCHAR(255),
    @PhoneNumber NVARCHAR(20),
    @Address NVARCHAR(500)
AS
BEGIN
    INSERT INTO Customers (FullName, Email, Password, PhoneNumber, Address)
    VALUES (@FullName, @Email, @Password, @PhoneNumber, @Address);
END
GO

-- Thêm đơn hàng mới
CREATE PROCEDURE sp_AddOrder
    @CustomerID INT,
    @TotalAmount DECIMAL(18,2),
    @Status NVARCHAR(50)
AS
BEGIN
    INSERT INTO Orders (CustomerID, TotalAmount, Status)
    VALUES (@CustomerID, @TotalAmount, @Status);
END
GO

-- Cập nhật trạng thái đơn hàng
CREATE PROCEDURE sp_UpdateOrderStatus
    @OrderID INT,
    @NewStatus NVARCHAR(50)
AS
BEGIN
    UPDATE Orders
    SET Status = @NewStatus
    WHERE OrderID = @OrderID;
END
GO

-- Thêm sản phẩm vào đơn hàng
CREATE PROCEDURE sp_AddProductToOrder
    @OrderID INT,
    @ProductID INT,
    @Quantity INT,
    @UnitPrice DECIMAL(18,2)
AS
BEGIN
    INSERT INTO OrderDetails (OrderID, ProductID, Quantity, UnitPrice)
    VALUES (@OrderID, @ProductID, @Quantity, @UnitPrice);
END
GO

-- Cập nhật số lượng sản phẩm trong đơn hàng
CREATE PROCEDURE sp_UpdateOrderDetailQuantity
    @OrderDetailID INT,
    @NewQuantity INT
AS
BEGIN
    UPDATE OrderDetails
    SET Quantity = @NewQuantity
    WHERE OrderDetailID = @OrderDetailID;
END
GO

-- Xóa sản phẩm khỏi đơn hàng
CREATE PROCEDURE sp_RemoveProductFromOrder
    @OrderDetailID INT
AS
BEGIN
    DELETE FROM OrderDetails
    WHERE OrderDetailID = @OrderDetailID;
END
GO

-- Lấy danh sách đơn hàng của một khách hàng
CREATE PROCEDURE sp_GetOrdersByCustomer
    @CustomerID INT
AS
BEGIN
    SELECT * FROM Orders
    WHERE CustomerID = @CustomerID
    ORDER BY OrderDate DESC;
END
GO

-- Tìm kiếm sản phẩm theo tên
CREATE PROCEDURE sp_SearchProductsByName
    @Keyword NVARCHAR(255)
AS
BEGIN
    SELECT * FROM Products
    WHERE ProductName LIKE '%' + @Keyword + '%';
END
GO

-- //////////////////////////////////TRIGGER///////////////////////////////////////////

-- Giảm số lượng hàng tồn khi thêm sản phẩm
CREATE TRIGGER trg_DecreaseStock_AfterInsertOrderDetails
ON OrderDetails
AFTER INSERT
AS
BEGIN
    UPDATE Products
    SET StockQuantity = StockQuantity - i.Quantity
    FROM Products p
    JOIN inserted i ON p.ProductID = i.ProductID;
END
GO

-- Tăng lại số lượng tồn kho khi đơn hàng bị hủy 
CREATE TRIGGER trg_Restock_OnOrderCancelled
ON Orders
AFTER UPDATE
AS
BEGIN
    IF EXISTS (
        SELECT * FROM inserted i
        JOIN deleted d ON i.OrderID = d.OrderID
        WHERE i.Status = 'Cancelled' AND d.Status <> 'Cancelled'
    )
    BEGIN
        UPDATE Products
        SET StockQuantity = StockQuantity + od.Quantity
        FROM Products p
        JOIN OrderDetails od ON p.ProductID = od.ProductID
        JOIN inserted i ON od.OrderID = i.OrderID
        JOIN deleted d ON i.OrderID = d.OrderID
        WHERE i.Status = 'Cancelled' AND d.Status <> 'Cancelled';
    END
END
GO

-- Kiểm tra hàng tồn kho trước khi thêm sản phẩm vào
CREATE TRIGGER trg_CheckStock_BeforeInsertOrderDetails
ON OrderDetails
INSTEAD OF INSERT
AS
BEGIN
    IF EXISTS (
        SELECT 1
        FROM inserted i
        JOIN Products p ON i.ProductID = p.ProductID
        WHERE i.Quantity > p.StockQuantity
    )
    BEGIN
        RAISERROR('Không đủ hàng trong kho để thực hiện đơn hàng.', 16, 1);
        ROLLBACK TRANSACTION;
    END
    ELSE
    BEGIN
        INSERT INTO OrderDetails (OrderID, ProductID, Quantity, UnitPrice)
        SELECT OrderID, ProductID, Quantity, UnitPrice
        FROM inserted;
    END
END
GO

-- Thống kê doanh thu theo tháng
CREATE VIEW vw_RevenueByMonth AS
SELECT
    FORMAT(OrderDate, 'yyyy-MM') AS YearMonth,
    SUM(TotalAmount) AS TotalRevenue,
    COUNT(*) AS TotalOrders
FROM Orders
WHERE Status = 'Completed'
GROUP BY FORMAT(OrderDate, 'yyyy-MM');
GO

-- Danh sách sản phẩm còn hàng
CREATE VIEW vw_ProductsInStock AS
SELECT *
FROM Products
WHERE StockQuantity > 0;
GO

-- lịch sử mua hàng của khách hàng
CREATE VIEW vw_CustomerPurchaseHistory AS
SELECT
    c.CustomerID,
    c.FullName,
    o.OrderID,
    o.OrderDate,
    o.Status,
    od.ProductID,
    p.ProductName,
    od.Quantity,
    od.UnitPrice,
    od.Quantity * od.UnitPrice AS Total
FROM Customers c
JOIN Orders o ON c.CustomerID = o.CustomerID
JOIN OrderDetails od ON o.OrderID = od.OrderID
JOIN Products p ON p.ProductID = od.ProductID;
GO