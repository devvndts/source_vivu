<table>
    <thead>
        <tr>
            <th>Từ khóa</th>
            @foreach(config('config_all.lang') as $k=>$v)
            <th>{{$v}}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
    @foreach($lang as $k=>$v)
        <tr class="export_table">
            <td>{{$v['giatri']}}</td>
            @foreach(config('config_all.lang') as $lang_key=>$lang_value)
            <td>{{$v['lang'.$lang_key]}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
