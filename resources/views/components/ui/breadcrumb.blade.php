@props(['breadcrumbs' => []])

@if(!empty($breadcrumbs))
    <nav class="breadcrumbs">
        <div class="container">
            <ol>
                @foreach($breadcrumbs as $breadcrumb)
                    @php
                        $label = $breadcrumb['label'] ?? '';
                        $link = $breadcrumb['link'] ?? null;
                        $icon = $breadcrumb['icon'] ?? null;
                    @endphp
                    <li class="{{ $loop->last ? 'current' : '' }}">
                        @if($link && !$loop->last)
                            <a href="{{ $link }}" wire:navigate>
                                @if($icon)
                                    <i class="{{ $icon }}"></i>
                                @endif
                                {{ $label }}
                            </a>
                        @else
                            @if($icon)
                                <i class="{{ $icon }}"></i>
                            @endif
                            {{ $label }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </nav>
@endif

