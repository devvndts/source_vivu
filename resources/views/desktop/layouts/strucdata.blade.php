<script type="application/ld+json">
    {
        "@context" : "https://schema.org",
        "@type" : "Organization",
        "name" : "{!!$setting['ten'.$lang]!!}",
        "url" : "{{url('/').'/'}}",
        "sameAs" :
        [
            @if(isset($mangxahoi) && count($mangxahoi) > 0)
                @php
                    $sum_social = count($mangxahoi); 
                @endphp
                @foreach($mangxahoi as $key => $value)
                    "{{$value['link']}}"{{(($key+1)<$sum_social)?',':''}}
                @endforeach
            @endif
        ],
        "address":
        {
            "@type": "PostalAddress",
            "streetAddress": "{!!$settingOption['diachi']!!}",
            "addressRegion": "Ho Chi Minh",
            "postalCode": "70000",
            "addressCountry": "vi"
        }
    }
</script>