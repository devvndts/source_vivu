<?php
use App\Functions\Facades\Tool;
use App\Functions\Facades\Template;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Blade;

if (!function_exists('get_sales')) {
    function get_sales($type, $lang = 'vi', $options = null)
    {
        return Tool::getSales($type, $lang, $options);
    }
}
if (!function_exists('get_tags')) {
    function get_tags($type, $lang = 'vi', $options = null)
    {
        return Tool::getTags($type, $lang, $options);
    }
}
if (!function_exists('get_posts')) {
    function get_posts($type, $lang = 'vi', $options = null)
    {
        return Tool::getPosts($type, $lang, $options);
    }
}
if (!function_exists('get_products')) {
    function get_products($type, $lang = 'vi', $options = null)
    {
        return Tool::getProducts($type, $lang, $options);
    }
}
if (!function_exists('get_static')) {
    function get_static($type, $lang = 'vi')
    {
        return Tool::getStatic($type, $lang);
    }
}
if (!function_exists('get_static_photo')) {
    function get_static_photo($type, $lang = 'vi', $options = null)
    {
        return Tool::getStaticPhoto($type, $lang, $options);
    }
}
if (!function_exists('get_photos')) {
    function get_photos($type, $lang = 'vi', $options = null)
    {
        return Tool::getPhotos($type, $lang, $options);
    }
}
if (!function_exists('get_categories')) {
    function get_categories($type, $lang = 'vi', $options = null)
    {
        return Tool::getCategories($type, $lang, $options);
    }
}
if (!function_exists('get_galleries')) {
    function get_galleries($type, $lang = 'vi', $options = null)
    {
        return Tool::getGalleries($type, $lang, $options);
    }
}
if (!function_exists('get_string_for_locale')) {
    function get_string_for_locale($stringKey, $options = null)
    {
        return Tool::getStringForLocale($stringKey, $options);
    }
}
if (!function_exists('combine_attributes')) {
    function combine_attributes($array = null)
    {
        $result = '';
        foreach ($array as $key => $value) {
            $result .= sprintf('%s="%s" ', $key, $value);
        }
        return $result;
    }
}
if (!function_exists('renderFormElement')) {
    function renderFormElement($elementsConfig = null, $prefixName = '', $oldData = null)
    {
        $formLabelAttr = config('zvn.template.form_label.class');
        $formInputAttr = config('zvn.template.form_input.class');
        $elements = [];
        foreach ($elementsConfig as $key => $value) {
            $elementName = $prefixName . "[$key]";
            if ($value["type"] == "text") {
                $xhtmlInput = Form::text($elementName, @$oldData[$key], ['class'=>$formInputAttr]);
            } elseif ($value["type"] == "textarea") {
                $xhtmlInput = Form::textarea($elementName, @$oldData[$key], ['class'=>$formInputAttr]);
            } elseif ($value["type"] == "number") {
                $xhtmlInput = Form::number($elementName, @$oldData[$key], ['class'=>$formInputAttr]);
            } elseif ($value["type"] == "date") {
                $xhtmlInput = Form::date($elementName, @$oldData[$key], ['class'=>$formInputAttr]);
            } elseif ($value["type"] == "color") {
                $xhtmlInput = Form::color($elementName, @$oldData[$key], ['class'=>$formInputAttr]);
            }
            $elements[] = [
                'class' => $value["groupClass"],
                'label'   => Form::label($elementName, $value["title"], ['class'=>$formLabelAttr]),
                'element' => $xhtmlInput,
            ];
        }
        return $elements;
    }
}
if (!function_exists('renderBackendComponent')) {
    function renderBackendComponent($elementsConfig = null, $prefixName = '', $oldData = null)
    {
        $formInputAttr = config('zvn.template.form_input.class');
        $elements = [];
        $labelComponentString = '<x-backend_form.label>%s</x-backend_form.label>';
        $selectComponentString = '<x-backend_form.select %s :data="$data" :selectedIds="$selectedIds" />';
        $inputComponentString = '<x-backend_form.input %s />';
        $textareaComponentString = '<x-backend_form.textarea %s >%s</x-backend_form.textarea>';
        foreach ($elementsConfig as $key => $value) {
            $elementName = sprintf('%s[%s]', $prefixName, $key);
            $elementId = sprintf('%s_%s', $prefixName, $key);
            $label   = Blade::render(sprintf($labelComponentString, __($value["title"])));
            $attr = [];
            switch ($value["type"]) {
                case 'text':
                case 'color':
                case 'date':
                case 'number':
                    $attr = [
                        'type' => sprintf('type="%s"', $value["type"]),
                        'name' => sprintf('name="%s"', $elementName),
                        'id' => sprintf('id="%s"', $elementId),
                        'class' => sprintf('class="%s"', $formInputAttr),
                    ];
                    if (@$oldData[$key]) {
                        $attr['value'] = sprintf('value="%s"', $oldData[$key]);
                    }
                    $attrString = implode(' ', $attr);
                    $xhtmlInput = Blade::render(sprintf($inputComponentString, $attrString));
                    break;

                case 'radio':
                    $xhtmlInput = '';
                    $items = '';
                    $elementName = sprintf('%s[%s][]', $prefixName, $key);
                    foreach ($value["list"] as $keyList => $valueList) {
                        $attr = [
                            'type' => sprintf('type="%s"', $value["type"]),
                            'name' => sprintf('name="%s"', $elementName),
                            'value' => sprintf('value="%s"', $valueList["value"]),
                            'style' => sprintf('style="%s"', 'height: 16px; width: auto;'),
                        ];
                        if (@$oldData[$key][0] == $valueList["value"]) {
                            $attr['isChecked'] = 'isChecked';
                        }
                        $attrString = implode(' ', $attr);
                        $itemTitle = '&nbsp;' . $valueList["title"] . str_repeat('&nbsp;', 3);
                        $items .= Blade::render(sprintf($inputComponentString, $attrString)) . $itemTitle;
                    }
                    $attr = [
                        'class' => sprintf('class="%s"', $formInputAttr),
                        'style' => sprintf('style="%s"', 'display: flex;
                        justify-content: flex-start;
                        align-items: center;'),
                    ];
                    $attrStringWrapper = implode(' ', $attr);
                    $xhtmlInput = sprintf('<div %s>%s</div>', $attrStringWrapper, $items);
                    break;

                case 'checkbox':
                    $xhtmlInput = '';
                    $items = '';
                    $elementName = sprintf('%s[%s][]', $prefixName, $key);
                    foreach ($value["list"] as $keyList => $valueList) {
                        $attr = [
                            'type' => sprintf('type="%s"', $value["type"]),
                            'name' => sprintf('name="%s"', $elementName),
                            'value' => sprintf('value="%s"', $valueList["value"]),
                            'style' => sprintf('style="%s"', 'height: 16px; width: auto;'),
                        ];
                        if (isset($oldData[$key]) && in_array($valueList["value"], $oldData[$key])) {
                            $attr['isChecked'] = 'isChecked';
                        }
                        $attrString = implode(' ', $attr);
                        $itemTitle = '&nbsp;' . $valueList["title"] . str_repeat('&nbsp;', 3);
                        $items .= Blade::render(sprintf($inputComponentString, $attrString)) . $itemTitle;
                    }
                    $attr = [
                        'class' => sprintf('class="%s"', $formInputAttr),
                        'style' => sprintf('style="%s"', 'display: flex;
                        justify-content: flex-start;
                        align-items: center;'),
                    ];
                    $attrStringWrapper = implode(' ', $attr);
                    $xhtmlInput = sprintf('<div %s>%s</div>', $attrStringWrapper, $items);
                    break;

                case 'select':
                    $xhtmlInput = '';
                    $items = '';
                    $elementName = sprintf('%s[%s]', $prefixName, $key);
                    $attr = [
                        'name' => sprintf('name="%s"', $elementName),
                    ];
                    $selectedIds = null;
                    if (isset($oldData[$key]) && $oldData[$key]) {
                        $selectedIds = explode(',', $oldData[$key]);
                    }
                    $attrString = implode(' ', $attr);
                    $xhtmlInput = Blade::render(sprintf($selectComponentString, $attrString), ['data' => $value["list"], 'selectedIds' => $selectedIds]);
                    break;

                case 'textarea':
                    $attr = [
                        'name' => sprintf('name="%s"', $elementName),
                        'id' => sprintf('id="%s"', $elementId),
                        'class' => sprintf('class="%s"', $formInputAttr),
                    ];
                    $attrString = implode(' ', $attr);
                    $xhtmlInput = Blade::render(sprintf($textareaComponentString, $attrString, $oldData[$key] ?? ''));
                    break;
            
                default:
                    break;
            }
            $elements[] = [
                'class' => $value["groupClass"],
                'label'   => $label,
                'element' => $xhtmlInput ?? '',
            ];
        }
        return $elements;
    }
}
