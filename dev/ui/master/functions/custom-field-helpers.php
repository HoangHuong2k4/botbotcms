<?php

use Dev\Base\Models\BaseModel;

if (! function_exists('get_noi_khu_data')) {
    /**
     * Lấy dữ liệu từ repeater field "nội khu" (noi_khu)
     * 
     * @param BaseModel $data Model instance (Page, Post, etc.)
     * @param array $default Default value nếu không có dữ liệu
     * @return array Mảng các item với hình ảnh và nội dung đã được format
     */
    function get_noi_khu_data(BaseModel $data, array $default = []): array
    {
        $noiKhuItems = get_field($data, 'noi_khu', []);
        
        if (empty($noiKhuItems) || ! is_array($noiKhuItems)) {
            return $default;
        }

        // Lấy noi_dung từ page (cùng cấp với noi_khu)
        $noiDungItems = get_field($data, 'noi_dung', []);
        
        $result = [];
        foreach ($noiKhuItems as $index => $item) {
            $hinhAnh = get_sub_field($item, 'hinh_anh_noi_khu', '');
            
            // Lấy nội dung từ noi_dung theo index tương ứng
            $noiDungData = [];
            if (! empty($noiDungItems[$index]) && is_array($noiDungItems[$index])) {
                $noiDungItem = $noiDungItems[$index];
                $tieuDe = get_sub_field($noiDungItem, 'nk_tieu_de', '');
                $moTa = get_sub_field($noiDungItem, 'nk_mo_ta', '');
                
                if (! empty($tieuDe) || ! empty($moTa)) {
                    $noiDungData[] = [
                        'tieu_de' => $tieuDe,
                        'mo_ta' => $moTa,
                    ];
                }
            }
            
            $result[] = [
                'hinh_anh' => $hinhAnh ? get_object_image($hinhAnh) : '',
                'noi_dung' => $noiDungData,
            ];
        }

        return $result;
    }
}

if (! function_exists('get_noi_khu_item')) {
    /**
     * Lấy một item cụ thể từ repeater "nội khu" theo index
     * 
     * @param BaseModel $data Model instance
     * @param int $index Index của item (bắt đầu từ 0)
     * @param array|null $default Default value
     * @return array|null Item data hoặc null
     */
    function get_noi_khu_item(BaseModel $data, int $index = 0, ?array $default = null): ?array
    {
        $noiKhuData = get_noi_khu_data($data);
        
        return $noiKhuData[$index] ?? $default;
    }
}

if (! function_exists('has_noi_khu')) {
    /**
     * Kiểm tra xem có dữ liệu "nội khu" hay không
     * 
     * @param BaseModel $data Model instance
     * @return bool
     */
    function has_noi_khu(BaseModel $data): bool
    {
        $noiKhuData = get_noi_khu_data($data);
        
        return ! empty($noiKhuData);
    }
}

if (! function_exists('get_noi_that_data')) {
    /**
     * Lấy dữ liệu từ repeater field "nội thất" (noi_that)
     * 
     * @param BaseModel $data Model instance (Page, Post, etc.)
     * @param array $default Default value nếu không có dữ liệu
     * @return array Mảng các item với hình ảnh và nội dung đã được format
     */
    function get_noi_that_data(BaseModel $data, array $default = []): array
    {
        $noiThatItems = get_field($data, 'noi_that', []);
        
        if (empty($noiThatItems) || ! is_array($noiThatItems)) {
            return $default;
        }

        // Lấy nt_noi_dung từ page (cùng cấp với noi_that)
        $ntNoiDungItems = get_field($data, 'nt_noi_dung', []);
        
        $result = [];
        foreach ($noiThatItems as $index => $item) {
            $hinhAnh = get_sub_field($item, 'hinh_anh_noi_that', '');
            
            // Lấy nội dung từ nt_noi_dung theo index tương ứng
            $noiDungData = [];
            if (! empty($ntNoiDungItems[$index]) && is_array($ntNoiDungItems[$index])) {
                $noiDungItem = $ntNoiDungItems[$index];
                $tieuDe = get_sub_field($noiDungItem, 'nt_tieu_de', '');
                $moTa = get_sub_field($noiDungItem, 'nt_mo_ta', '');
                
                if (! empty($tieuDe) || ! empty($moTa)) {
                    $noiDungData[] = [
                        'tieu_de' => $tieuDe,
                        'mo_ta' => $moTa,
                    ];
                }
            }
            
            $result[] = [
                'hinh_anh' => $hinhAnh ? get_object_image($hinhAnh) : '',
                'noi_dung' => $noiDungData,
            ];
        }

        return $result;
    }
}

if (! function_exists('get_noi_that_item')) {
    /**
     * Lấy một item cụ thể từ repeater "nội thất" theo index
     * 
     * @param BaseModel $data Model instance
     * @param int $index Index của item (bắt đầu từ 0)
     * @param array|null $default Default value
     * @return array|null Item data hoặc null
     */
    function get_noi_that_item(BaseModel $data, int $index = 0, ?array $default = null): ?array
    {
        $noiThatData = get_noi_that_data($data);
        
        return $noiThatData[$index] ?? $default;
    }
}

if (! function_exists('has_noi_that')) {
    /**
     * Kiểm tra xem có dữ liệu "nội thất" hay không
     * 
     * @param BaseModel $data Model instance
     * @return bool
     */
    function has_noi_that(BaseModel $data): bool
    {
        $noiThatData = get_noi_that_data($data);
        
        return ! empty($noiThatData);
    }
}

