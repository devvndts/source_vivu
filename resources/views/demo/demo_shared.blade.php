<div class="px-5 shadow-2xl rounded-2xl my-5 border-[1px] border-b-slate-400">
    <h2 class="text-xl font-bold">Footer</h2>
    <pre>
        <code>
            @php
            $text = '<x-shared.footer_title title="Chăm sóc khách hàng" />
    <x-footer.list class="text-base" >
        <x-footer.list.item href="" >Tên chính sách</x-footer.list.item>
        <x-footer.list.item href="" >Tên chính sách</x-footer.list.item>
    </x-footer.list>';
            @endphp
            {{ $text }}
        </code>
    </pre>
    @php
    $chinhsachs = collect([
        (object) ['tenvi' => 'Chính sách 01', 'tenkhongdauvi' => 'chinh-sach-01'],
        (object) ['tenvi' => 'Chính sách 02', 'tenkhongdauvi' => 'chinh-sach-02'],
        (object) ['tenvi' => 'Chính sách 03', 'tenkhongdauvi' => 'chinh-sach-03'],
    ]);
    @endphp
    <x-shared.footer_title title="{{ __('Chăm sóc khách hàng') }}" />
    <x-footer.list class="text-base" >
        @foreach ($chinhsachs as $item)
        @php
            $url = $item->{$sluglang};
        @endphp
        <x-footer.list.item href="{{ $url }}" >
            {{ $item->{"ten$lang"} }}
        </x-footer.list.item>
        @endforeach
    </x-footer.list>
</div>
<div class="px-5 shadow-2xl rounded-2xl my-5 border-[1px] border-b-slate-400">
    <h2 class="text-xl font-bold">Button</h2>
    
    <pre>
        <code>
        props([
            'btnClass' => 'btn-primary',
            'type' => 'button',
            'title' => 'Button',
            'isInput' => false,
        ])
        </code>
    </pre>
    <x-shared.button />
    <pre>
        <code>
            @php
                $text = "<x-shared.button />";
            @endphp
            {{ $text }}
        </code>
    </pre>
    <x-shared.button isInput btnClass="btn-success" title="Button as input" />
    <pre>
        <code>
            @php
                $text = '<x-shared.button isInput btnClass="btn-success" title="Button as input" />';
            @endphp
            {{ $text }}
        </code>
    </pre>
    <x-shared.button href="{{ url('') }}" btnClass="btn-danger" title="Button link" />
    <pre>
        <code>
            @php
                $text = '<x-shared.button isInput btnClass="btn-success" title="Button as input" />';
            @endphp
            {{ $text }}
        </code>
    </pre>
</div>

<div class="px-5 shadow-2xl rounded-2xl my-5 border-[1px] border-b-slate-400">
    <h2 class="text-xl font-bold">Readmore</h2>
    
    <pre>
        <code>
            props([
                'title' => __('site.viewmore'),
                ])
        </code>
    </pre>
    <x-shared.readmore  href="{{ url('') }}" />
    <pre>
        <code>
            @php
                $text = '<x-shared.readmore href="{{ url(\'\') }}"  />';
            @endphp
            {{ $text }}
        </code>
    </pre>
    <x-shared.readmore title="Xem"  >
        <x-slot name="icon"></x-slot>
    </x-shared.readmore>
    <pre>
        <code>
            @php
                $text = '<x-shared.readmore title="Xem"  >
        <x-slot name="icon"></x-slot>
    </x-shared.readmore>';
            @endphp
            {{ $text }}
        </code>
    </pre>
</div>

<div class="px-5 shadow-2xl rounded-2xl my-5 border-[1px] border-b-slate-400">
    <h2 class="text-xl font-bold">Title</h2>
    
    <pre>
        <code>
            props([
                'title' => __('site.viewmore'),
                ])
        </code>
    </pre>
    <x-shared.readmore  href="{{ url('') }}" />
    <pre>
        <code>
            @php
                $text = '<x-shared.readmore href="{{ url(\'\') }}"  />';
            @endphp
            {{ $text }}
        </code>
    </pre>
    <x-shared.readmore title="Xem"  >
        <x-slot name="icon"></x-slot>
    </x-shared.readmore>
    <pre>
        <code>
            @php
                $text = '<x-shared.readmore title="Xem"  >
        <x-slot name="icon"></x-slot>
    </x-shared.readmore>';
            @endphp
            {{ $text }}
        </code>
    </pre>
</div>
