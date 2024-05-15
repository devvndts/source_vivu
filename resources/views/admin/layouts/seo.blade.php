<div class="card-seo">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                @foreach(config('config_all.seo') as $k => $v)
                    <li class="nav-item">
                        <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-seolang-{{$k}}" role="tab" aria-controls="tabs-seolang-{{$k}}" aria-selected="true">SEO ({{$v}})</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                @foreach(config('config_all.seo') as $k => $v)
                @php
                    $rowItem['title'.$k] = $rowItem['title'.$k] ?? '';
                    $rowItem['keywords'.$k] = $rowItem['keywords'.$k] ?? '';
                    $rowItem['description'.$k] = $rowItem['description'.$k] ?? '';
                @endphp
                    <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-seolang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                        <div class="form-group">
                            <label for="title{{$k}}" class="inp">                                
                                <input type="text" class="form-control check-seo title-seo" name="data[title{{$k}}]" id="title{{$k}}" placeholder="&nbsp;" value="{{ (isset($rowItem['title'.$k]))?$rowItem['title'.$k]:'' }}">
                                <div class="label">SEO Title:
                                    <span class="//label-seo miko-label-seo">                                
                                        <strong class="count-seo">(<span>{{ Helper::CountSeo($rowItem['title'.$k]) }}</span>/70 {{ __('ký tự') }})</strong>
                                    </span>
                                </div>
                                <div class="focus-bg"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="keywords{{$k}}" class="inp">                                
                                <input type="text" class="form-control check-seo keywords-seo" name="data[keywords{{$k}}]" id="keywords{{$k}}" placeholder="&nbsp;" value="{{ (isset($rowItem['keywords'.$k]))?$rowItem['keywords'.$k]:'' }}">
                                <div class="label">SEO Keywords:
                                    <span class="//label-seo miko-label-seo">                                
                                        <strong class="count-seo"><span>{{ Helper::CountSeo($rowItem['keywords'.$k]) }}</span>/70 {{ __('ký tự') }}</strong>
                                    </span>
                                </div>
                                <div class="focus-bg"></div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="description{{$k}}" class="inp">                            
                                <textarea class="form-control check-seo description-seo" name="data[description{{$k}}]" id="description{{$k}}" rows="5" placeholder="&nbsp;">{{ (isset($rowItem['description'.$k]))?$rowItem['description'.$k]:'' }}</textarea>
                                <div class="label">SEO Description:    
                                    <span class="//label-seo miko-label-seo">                                
                                        <strong class="count-seo"><span>{{ Helper::CountSeo($rowItem['description'.$k]) }}</span>/160 {{ __('ký tự') }}</strong>
                                    </span>
                                </div>
                                <div class="focus-bg"></div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <input type="hidden" id="seo-create" value="{{ Helper::CreateSeo() }}">
    </div>
</div>
