<ul class="h-card d-none">
    <li class="h-fn fn">{{$setting['ten'.$lang]}}</li>
    <li class="h-org org">{{$setting['ten'.$lang]}}</li>
    <li class="h-tel tel">{{preg_replace('/[^0-9]/','',$optsetting['hotline']);?></li>
    <li><a class="u-url ul" href="{{$config_base}}">{{$config_base}}</a></li>
</ul>
<h1 class="d-none">{{(isset($title))?$title:''}}</h1>
