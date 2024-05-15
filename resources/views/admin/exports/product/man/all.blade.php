<table>
    <thead>
        <tr>
            <th>Mã Sản phẩm</th>
            <th>Mã Phiên Bản</th>
            <th>Tên Sản Phẩm</th>
            <th>Giá Cũ</th>
            <th>Giá Bán</th>
            <th>Màu</th>
            <th>Size</th>
            <th>Hình ảnh</th>
            <th>Title</th>
            <th>Keywords</th>
            <th>Description</th>
        </tr>
    </thead>

    <tbody>
    @foreach($products as $p=>$product)
        <tr>
            <td>{{ $product['masp'] }}</td>
            <td></td>
            <td>{{ $product['tenvi'] }}</td>
            <td>{{ $product['giacu'] }}</td>
            <td>{{ $product['gia'] }}</td>
            <td></td>
            <td></td>
            <td>{{ $product['photo'] }}</td>
            <td>{{ $product['titlevi'] }}</td>
            <td>{{ $product['keywordsvi'] }}</td>
            <td>{{ $product['descriptionvi'] }}</td>
        </tr>
        @if($product['countVersion']>0)
            @foreach($product['productDetail'] as $pd=>$productDetail)
            <tr>
                <td>{{ $product['masp'] }}</td>
                <td>{{ $productDetail['masp'] }}</td>
                <td>{{ $productDetail['tenvi'] }}</td>
                <td>{{ $productDetail['giacu'] }}</td>
                <td>{{ $productDetail['gia'] }}</td>
                <td>{{ CartHelper::get_mau_info($productDetail['id_mau'])['tenvi'] }}</td>
                <td>{{ CartHelper::get_size_info($productDetail['id_size'])['tenvi'] }}</td>
                <td>{{ $productDetail['photo'] }}</td>
                <td>{{ $productDetail['titlevi'] }}</td>
                <td>{{ $productDetail['keywordsvi'] }}</td>
                <td>{{ $productDetail['descriptionvi'] }}</td>
            </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
