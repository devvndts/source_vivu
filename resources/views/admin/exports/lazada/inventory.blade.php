<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã sản phẩm website</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng website</th>
            <th>Số lượng lazada</th>
            <th>Số lượng shopee</th>
        </tr>
        @if($products)
            @foreach($products as $k=>$v)
                @php
                    $product_options = $v['has_product_options'];
                @endphp                
                <tr>
                    <td rowspan="{{($product_options) ? (count($product_options) + 1) : 1}}">{{($k+1)}}</td>
                    <td>{{$v['masp']}}</td>
                    <td>{{$v['tenvi']}}</td>
                    @if($product_options)
                        <td colspan="{{($product_options) ? 3 : 1}}"></td>
                    @else
                        <td>{{$v['soluong_website']}}</td>
                        <td>{{$v['soluong_lazada']}}</td>
                        <td>{{$v['soluong_shopee']}}</td>
                    @endif                    
                </tr>
                @if($product_options)
                    @foreach($product_options as $op=>$option)
                        <tr>
                            <td>{{$option['masp']}}</td>
                            <td>{{$option['tenvi']}}</td>
                            <td>{{$option['soluong_website']}}</td>
                            <td>{{$option['soluong_lazada']}}</td>
                            <td>{{$option['soluong_shopee']}}</td>
                        </tr>
                    @endforeach                    
                @endif
            @endforeach
        @endif
    </thead>
</table>
