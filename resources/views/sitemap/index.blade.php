@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?xml-stylesheet type="text/xsl" href="'.$config_base.'sitemap-template.xsl"?>'; @endphp
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($site as $k=>$v)
        @if(!empty($v))
        <sitemap>
            <loc>{{$config_base.'sitemap/'.$k}}</loc>
            <lastmod>{{date("c",$time)}}</lastmod>
        </sitemap>
        @endif
    @endforeach
    @foreach($site_category as $k=>$v)
        @if(count($v['list_child_item'])>0)
        <sitemap>
            <loc>{{$config_base.'sitemap/'.$v['tenkhongdauvi']}}</loc>
            <lastmod>{{date("c",$time)}}</lastmod>
        </sitemap>
        @endif
    @endforeach
</sitemapindex>
