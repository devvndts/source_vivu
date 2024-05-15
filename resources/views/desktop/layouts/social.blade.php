@php
    $class = (!empty($options["class"])) ? sprintf('class=%s', $options["class"]): '';
    $title = (!empty($options["title"])) ? sprintf('<span>%s</span>', $options["title"]): '';
    $name = (isset($options["name"]) && $options["name"] == true) ? true: false;

    $xhtml = "";
    foreach($params as $k=>$value) {
        $name = $value->{"ten".$lang};
        $url = $value->link;
        $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', UPLOAD_PHOTO.$value->photo, $name, asset('img/noimage.png'));;
        if($name){
            $format = '<a target="_blank" href="%s">%s%s</a>';
            $xhtml .= sprintf($format, $url, $img, $name);
        }else{
            $format = '<a target="_blank" href="%s">%s</a>';
            $xhtml .= sprintf($format, $url, $img);
        }
    }
@endphp

<div {{ $class }}>
    {!! $title !!}
    {!! $xhtml !!}
</div>