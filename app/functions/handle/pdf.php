<?php
function tlp_pdf($ma_so, $ho_ten, $gioi_tinh, $ngay_sinh, $phuong_xa, $quan_huyen, $tinh_thanh, $cmnd, $muc_tien, $phuong_thuc, $noi_kcb, $noi_dung, $ho_so){
    $pdf = new tFPDF();
    $ngay = current_time('d');
    $thang = current_time('m');
    $nam = current_time('Y');
    if($gioi_tinh==1) $gioi_tinh = 'Nam';
    else $gioi_tinh = 'Nữ';
    $ho_ten = mb_strtoupper($ho_ten, "UTF-8");
    $ngay_sinh = date('d/m/Y', strtotime($ngay_sinh));
    $muc_tien = empty($muc_tien)?'':number_format($muc_tien, 0, '', ',').' đ';
    $pdf->AddFont('DejaVu','','DejaVuSerifCondensed.ttf',true);
    $pdf->AddFont('DejaVuBold','','DejaVuSerifCondensed-Bold.ttf',true);
    $pdf->AddPage();
    $pdf->SetFont('DejaVuBold','',9);
    $pdf->Cell(120, 4, '', 0, 0, 'C');
    $pdf->Cell(69, 4, 'Mẫu TK1-TS', 0, 1, 'C');
    $pdf->SetFont('DejaVu','',9);
    $pdf->Cell(120, 4, '', 0, 0, 'C');
    $pdf->Cell(69, 4, '(Ban hành kèm theo Quyết định số: 505/QĐ-BHXH', 0, 1, 'C');
    $pdf->Cell(120, 4, '', 0, 0, 'C');
    $pdf->Cell(69, 4, 'ngày 27/03/2020 của BHXH Việt Nam)', 0, 1, 'C');
    $pdf->SetFont('DejaVu','',12);
    $pdf->Cell(80, 10, 'BẢO HIỂM XÃ HỘI VIỆT NAM', 0, 0, 'C');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Cell(109, 10, 'CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'C');
    $pdf->SetFont('DejaVu','',12);
    $pdf->Cell(80, -6, '___________________', 0, 0, 'C');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Cell(109, 4, 'Độc lập - Tự do - Hạnh phúc', 0, 1, 'C');
    $pdf->SetFont('DejaVu','',12);
    $pdf->Cell(80, 0, '', 0, 0, 'C');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Cell(109, -2, '_______________________________', 0, 1, 'C');
    $pdf->SetFont('DejaVuBold','',13);
    $pdf->Ln(8);
    $pdf->Cell(189, 6, 'TỜ KHAI', 0, 1, 'C');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Cell(189, 6, 'THAM GIA, ĐIỀU CHỈNH THÔNG TIN BẢO HIỂM XÃ HỘI, BẢO HIỂM Y TẾ', 0, 1, 'C');
    $pdf->Ln(4);
    $pdf->Cell(189, 10, 'I. Áp dụng đối với người tham gia tra cứu không thấy mã số BHXH do cơ quan BHXH cấp', 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(140, 6, '[01]. Họ và tên (viết chữ in hoa): ..............................................................', 0, 0, 'L');
        $pdf->Cell(49, 6, '[02]. Giới tính: ................', 0, 1, 'L');
        $pdf->Cell(110, 6, '[03]. Ngày tháng năm sinh: ..............................................', 0, 0, 'L');
        $pdf->Cell(79, 6, '[04]. Quốc tịch: .......................................', 0, 1, 'L');
        $pdf->Cell(79, 6, '[05]. Dân tộc: ..........................................', 0, 0, 'L');
        $pdf->Cell(110, 6, '[06]. Số CMND/CCCD/Hộ  chiếu: .....................................', 0, 1, 'L');
        $pdf->Cell(90, 6, '[07]. Điện thoại: .................................................', 0, 0, 'L');
        $pdf->Cell(99, 6, '[08]. Email (Nếu có): ...............................................', 0, 1, 'L');
        $pdf->Cell(189, 6, '[09]. Nơi đăng ký khai sinh: [09.1]. Xã: .............................................................................................', 0, 1, 'L');
        $pdf->Cell(99, 6, '[09.2]. Huyện: .........................................................', 0, 0, 'L');
        $pdf->Cell(90, 6, '[09.3]. Tỉnh: .....................................................', 0, 1, 'L');
        $pdf->Cell(189, 6, '[10]. Họ tên cha/mẹ/giám hộ (đối với trẻ em dưới 6 tuổi): ................................................................', 0, 1, 'L');
        $pdf->Cell(189, 6, '[11]. Địa chỉ nhận kết quả: [11.1]. Số nhà, đường/phố, thôn/xóm: ...................................................', 0, 1, 'L');
        $pdf->Cell(70, 6, '[11.2]. Xã: .........................................', 0, 0, 'L');
        $pdf->Cell(69, 6, '[11.2]. Huyện: .................................', 0, 0, 'L');
        $pdf->Cell(50, 6, '[11.3]. Tỉnh: ....................', 0, 1, 'L');
        $pdf->Cell(189, 6, '[12]. Kê khai Phụ lục Thành viên hộ gia đình (phụ lục kèm theo) đối với người tham gia tra cứu.', 0, 1, 'L');
        $pdf->Cell(189, 6, 'không thấy mã số BHXH và người tham gia BHYT theo hộ gia đình để giảm trừ mức đóng.', 0, 1, 'L');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Ln(4);
    $pdf->Cell(189, 6, 'II. Áp dụng đối với người tham gia đã có mã số BHXH đề nghị đăng ký, điều chỉnh thông tin', 0, 1, 'L');
        $pdf->Cell(189, 6, 'ghi trên sổ BHXH, thẻ BHYT', 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(38, 6, '[13]. Mã số BHXH:', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(80, 6, "$ma_so", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(71, 6, '[14]. Điều chỉnh thông tin cá nhân:', 0, 1, 'L');
        $pdf->Cell(38, -4, '', 0, 0, 'L');
        $pdf->Cell(80, -4, '..................................................................', 0, 0, 'L');
        $pdf->Cell(71, -4, '', 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(68, 6, "[14.1]. Họ và tên (viết chữ in hoa):", 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(72, 6, "$ho_ten", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(33, 6, "[14.2]. Giới tính: ", 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(16, 6, "$gioi_tinh", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(68, -4, "", 0, 0, 'L');
        $pdf->Cell(72, -4, "...........................................................", 0, 0, 'L');
        $pdf->Cell(33, -4, "", 0, 0, 'L');
        $pdf->Cell(16, -4, "............", 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(60, 6, '[14.3]. Ngày, tháng, năm sinh: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(70, 6, "$ngay_sinh", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(59, 6, '[14.4]. Nơi đăng ký khai sinh:', 0, 1, 'L');
        $pdf->Cell(60, -4, '', 0, 0, 'L');
        $pdf->Cell(70, -4, ".........................................................", 0, 0, 'L');
        $pdf->Cell(59, -4, '', 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(8, 6, 'Xã: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(62, 6, "$phuong_xa", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(15, 6, 'Huyện: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(54, 6, "$quan_huyen", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(11, 6, 'Tỉnh: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(39, 6, "$tinh_thanh", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(8, -4, '', 0, 0, 'L');
        $pdf->Cell(62, -4, '...................................................', 0, 0, 'L');
        $pdf->Cell(15, -4, '', 0, 0, 'L');
        $pdf->Cell(54, -4, '............................................', 0, 0, 'L');
        $pdf->Cell(11, -4, '', 0, 0, 'L');
        $pdf->Cell(39, -4, '................................', 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(69, 6, '[14.5]. Số CMND/CCCD/Hộ  chiếu: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(120, 6, "$cmnd", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(69, -4, '', 0, 0, 'L');
        $pdf->Cell(120, -4, "...................................................................................................", 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(41, 6, '[15]. Mức tiền đóng: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(49, 6, "$muc_tien", 0, 0, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(48, 6, '[16]. Phương thức đóng: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(51, 6, "$phuong_thuc", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(41, -4, '', 0, 0, 'L');
        $pdf->Cell(49, -4, "........................................", 0, 0, 'L');
        $pdf->Cell(48, -4, '', 0, 0, 'L');
        $pdf->Cell(51, -4, "..........................................", 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(87, 6, '[17]. Nơi đăng ký khám, chữa bệnh ban đầu: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(102, 6, "$noi_kcb", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(87, -4, '', 0, 0, 'L');
        $pdf->Cell(102, -4, '....................................................................................', 0, 1, 'L');
        $pdf->Ln(4);
        $pdf->Cell(75, 6, '[18]. Nội dung thay đổi, yêu cầu khác: ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(100, 6, "$noi_dung", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(75, -4, '', 0, 0, 'L');
        $pdf->Cell(100, -4, '..............................................................................................', 0, 1, 'L');
        $pdf->Ln(6);
        $pdf->Cell(189, 4, '............................................................................................................................................................', 0, 1, 'L');
        $pdf->Cell(60, 6, '[19]. Hồ sơ kèm theo (nếu có): ', 0, 0, 'L');
        $pdf->SetFont('DejaVuBold','',12);
        $pdf->Cell(129, 6, "$ho_so", 0, 1, 'L');
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(60, -4, '', 0, 0, 'L');
        $pdf->Cell(129, -4, "..........................................................................................................", 0, 0, 'L');
        $pdf->Ln(2);
        $pdf->Cell(189, 4, '............................................................................................................................................................', 0, 1, 'L');
    $pdf->Ln(4);
    $pdf->Cell(80, 6, 'XÁC NHẬN CỦA ĐƠN VỊ', 0, 0, 'C');
    $pdf->Cell(119, 6, "Huyện Sốp Cộp, ngày $ngay tháng $thang năm $nam", 0, 1, 'C');
    $pdf->Cell(80, 6, '', 0, 0, 'C');
    $pdf->SetFont('DejaVuBold','',12);
    $pdf->Cell(119, 6, 'Người kê khai', 0, 1, 'C');
    $pdf->SetFont('DejaVu','',12);
    $pdf->Cell(80, 6, '……………………………………………', 0, 0, 'C');
    $pdf->Cell(119, 6, '…………………………………………………………………', 0, 1, 'C');
    $pdf->Cell(80, 6, '……………………………………………', 0, 0, 'C');
    $pdf->Cell(119, 6, '…………………………………………………………………', 0, 1, 'C');
    $pdf->Cell(80, 6, '……………………………………………', 0, 0, 'C');
    $pdf->Cell(119, 6, '…………………………………………………………………', 0, 1, 'C');
    $pdf->Cell(80, 6, '……………………………………………', 0, 0, 'C');
    $pdf->Cell(119, 6, '…………………………………………………………………', 0, 1, 'C');
    $pdf->Ln(4);
    $pdf->SetFont('DejaVu','',11);
    $pdf->Cell(189, 6, 'Ghi chú: Người tham gia tra cứu mã số BHXH tại địa chỉ: https://baohiemxahoi.gov.vn.', 0, 1, 'C');
    $pdf->Output();
}