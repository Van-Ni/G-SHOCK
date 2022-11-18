// ****************************** //
#  =========================
#  1. Module User
#  =========================

+ Install auth
+ Import boostrap
+ Đổi lang
+ Tạo database 

# Đăng ký - Xác thực email
+ [ config sender ] 

# Quên mật khẩu
+ Vào trang dashboard
 - View: Tạo blade template   
   Tạo layout cha + tạo layout dashboard (extends)
   
# Logout: redirect to dashboard
  keyword: How to set laravel 5.3 logout redirect path?

# Thiết lập đường dẫn
  Idea: vanni.unitopcv.com/Project/Ismart/Admin
  -> redirect to dashboard

# Hiển thị danh sách quản trị hệ thống

# Tìm kiếm thành viên
  + Hiển thị dữ liệu = dd($users);
  + Hiển thị total = $users->total();
# Thêm thành viên 
  Validation form ( check password confirm )
  !!! Lưu ý: trường nhập lại name = "password_confirmation"
  Thêm vào database

# Xử lý lỗi khi truy cập chưa login
  Sử dụng Route group để xử lý

# Thiết lập trang xóa user trong hệ thống
Best Idea:
  + xác nhận có muốn xóa không ?
  + Kiểm tra id cần xóa có phải là id hiện tại của mình ko ?

# Thống kê user theo trạng thái
  + Status: active && trash

#  =========================
#  2. Module Page
#  =========================
 1. Tạo database 
 2. Ghép giao diện [add,list]
 3. Thêm bài viết 
 4. Hiển thị danh sách bài viết
    + convert status (*)
 5. Thực hiện tác vụ : sửa, delete-soft delete,restore, action
 
<!-- Tối ưu -->
 + Thêm trường người tạo:user_id

#  =========================
#  3. Module Post
#  =========================
1. Nghiên cứu tt cần lưu, tạo database 
2. Ghép giao diện [add,list,cat]
  
- Danh mục : 
  + Validation + Add database *
  + Viết hàm data_tree : tạo danh mục cây
  + Show danh sách danh mục
  + Sửa && xóa
- Thêm bài viết :
  + Thêm action vào form
  + Upload ảnh: preview image before upload
  + Validation 
  + Thêm mới
- Show danh sách :
  + Hiển thị
  + Trạng thái: pending, publish
  + Tìm kiếm
  + Action : pending, publish, soft delete , restore
  + Edit

# Tong ket , tối ưu

#  =========================
#  3. Module Product 
#  ========================= 
-- Ghép giao diện
1. Nghiên cứu tt cần lưu trữ
2. Xây dựng database

-- Danh mục sản phẩm: [product_cats]
  + Tạo database 
  + Validation
  + Thêm
  + Viết hàm data_tree + re_index
  + Hiển thị 
-- Thương hiệu: 
  + Tạo database
  + Validation
  + Thêm
-- Thêm mới: [products]
  + Tạo database
  + Thêm các trường & name 
  + Validation
  + Thêm ảnh 
  + render danh mục & thương hiệu
  + Thêm mới
-- Danh sách: [products]
  + Hiển thị 
  + Trạng thái: 1, 0, trash
  + Tìm kiếm
  + Action : pending, publish, soft delete , restore
  + Edit + Delete +  forceDelete + Restore 
- Màu sản phẩm [product_imgs]
  + Tạo database 
  + Validation 
  + Thêm
  + Hiển thị
- Ảnh liên quan :
  + Tạo database 
  + Validation 
  + Thêm
  + Hiển thị & xóa

#  =========================
#  4. Module Order 
#  ========================= 
- Viết hàm format money
- Tạo giao diện : list, edit
- Tạo fake database 
- Hiển thị trang danh sách && trang edit
- Hiển thị theo trạng thái
- Tìm kiếm
- Thực thi tác vụ
- Chỉnh sửa , xóa, restore, forceDelete

# Bo sung
- Update trang thai don hang
#  =========================
#  4. Module Dashboard 
#  ========================= 

- Ghép giao diện
- Load thông tin doanh thu
- Load thông tin đơn hàng mới 
- Tìm : thêm link vào edit đơn hàng

#  =========================
#  5. Module User - BỔ SUNG 
#  ========================= 

-  Tìm kiếm họ tên | email
-  Phân quyền " Middleware "

# **********ISMART************ #

#  =========================
#  1. SET UP 
#  ========================= 
- Tạo master layout
- Ghép giao diện
- Ghép css, js
#  =========================
#  2. Module page
#  ========================= 
- Ghép giao diện
- Tìm content để tạo
- Hiển thị
#  =========================
#  3. Module blog
#  =========================
- Ghép giao diện
- Lấy tiêu đề blog muốn hiển thị
- Tạo content
- Hiển thị : danh sách bài viết , chi tiết bài viết

#  =========================
#  3. Module home
#  =========================

1. Danh mục sp
- Tạo hàm data_tree ( * )
2. Tạo content cho module product: 8 sp
3. Load sản phẩm bán chay: Thêm trường num_sold
-  Select TOP 8
4. Hiển thị sản phẩm nổi bật: 
-  Random
5. Hiển thị sản phẩm 
- điên thoại
- Laptop

#  =========================
#  4. Module Product ( admin )
#  =========================
- Bổ sung: Thêm danh mục con ( AJAX )
-checklist:
 + Thêm field
 + child_cat_id

+ FIX BUG: 
 - Thêm trường: 
 + num_sold sau old_price
 + deleted_at 

# ADD PRODUCT
 
# UPDATE PRODUCT ( done )

#  =========================
#  5. Module Product
#  =========================
-  Ghép giao diện 
-  Tạo link đến route 
-  Hiển thị : 
+  Danh sách 
+  Danh mục 
+  Bộ lọc 
-  Lọc sản phẩm
-  Sắp xếp 
+  Chi tiết bài viết : 
- edit content
- Hiển thị sản phẩm tương ứng với màu 
- Xem thêm nội dung
+ Cùng chuyên mục 

# Load sản phẩm danh mục con
+ Tạo link 
+ Routing
+ Load view 
+ Load sản phẩm 
+ Lọc giá

# Load chi tiết sản phẩm
+  ảnh 
+  màu
+  content + style 
+  Xem thêm
#  =========================
#  7. Module SEARCH ( ajax )
#  =========================
+  Xây dựng giao diện 
+  checklist xử lý ajax: 
- event: [] 
- check dữ liệu nhận 
- get dữ liệu LIKE %product_name%
- Xây dựng html 
- Đổ dữ liệu 
- Truyền lên server -> đưa ra giao diện 
#  =========================
#  6. Module CART
#  =========================
+  Xem lại bài học !!!
+  Cài đặt Laravel Cart 
+  Tạo url mua sản phẩm 
+  Thêm sản phẩm 
[ thêm màu  và hình ảnh  ]
+  Hiển thị giỏ hàng
   Hiển thị demo 
   Taọ giao diện + custom
   Hiển thị  
[ có ảnh và màu ]
+  Cập nhật giỏ hàng ajax
   Subtotal by rowId 
   Total 
+  Xóa sản phẩm trong giỏ hàng
+  Xóa toàn bộ giỏ hàng

#  Rà xoát , test , tối ưu 

#  =========================
#  6. Module checkout
#  =========================
+ Ghép giao diện 
+ Validation form 
+ Ý tưởng điền địa chỉ ajax
+ Đổ dữ liệu cart
+ Ý tưởng thêm vào database 
 + Lưu vào database: customer, order
 + lưu lại thông tin kh đã nhập

# Hiển thị thanh toán thành công
 + Lên Idea
 - Tạo giao diện
 - Thanh toán 
   Chuyển hướng + kèm theo order code
   Từ order code: 
   Hiển thị thông tin kh 
   Hiển thị thông tin sản phẩm 
 + Customize Hiển thị ra bảng đơn hàng

# Bổ sung module slider
 + Tạo giao diện 
  Thêm mới 
  Danh sách 
 + Tạo database
 + Thêm database 
 + Hiển thị: 
  Danh sách slider
  Giao diện người dùng

#  =========================
#  7. Tổng kết : ôn lại kiến thức có trong pj
#  =========================


#  =========================
#  8. Đưa website lên Internet
#  =========================



# ************UPDATE Bổ sung************** #

# 1. Phân trang + tìm kiếm


# PHÂN QUYỀN NÂNG CAO 

4/10 lessons