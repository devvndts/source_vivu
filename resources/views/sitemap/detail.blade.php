@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
@php echo '<?xml-stylesheet type="text/xsl" href="'.$config_base.'sitemap-template.xsl"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($site as $k=>$v)
        @if(isset($v))
        <url>
            <loc>{{ $v['loc'] }}</loc>
            <lastmod>{{$v['lastmod']}}</lastmod>
            <changefreq>{{ $v['changefreq'] }}</changefreq>
            <priority>{{ $v['priority'] }}</priority>
        </url>
        @endif
    @endforeach
</urlset>
