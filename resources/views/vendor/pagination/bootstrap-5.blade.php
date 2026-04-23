@if ($paginator->hasPages())
    <!-- Custom Pagination - Bootstrap 5 Style -->
    <div
        style="padding:16px 24px; border-top:1px solid #F3F4F6; display:flex; align-items:center; justify-content:center; position:relative;">

        {{-- Mobile View --}}
        <div style="display:flex; width:100%; justify-content:space-between; @media(min-width:640px){display:none;}">
            @if ($paginator->onFirstPage())
                <span
                    style="padding:8px 14px; border:1px solid #E8E8E8; border-radius:6px; color:#8899A8; font-size:13px; background:#F7F9FC;">← Oldingi</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   style="padding:8px 14px; border:1px solid #E8E8E8; border-radius:6px; color:#1C2434; font-size:13px; text-decoration:none; background:#fff;">←
                    Oldingi</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   style="padding:8px 14px; border:1px solid #E8E8E8; border-radius:6px; color:#1C2434; font-size:13px; text-decoration:none; background:#fff;">Keyingi
                    →</a>
            @else
                <span
                    style="padding:8px 14px; border:1px solid #E8E8E8; border-radius:6px; color:#8899A8; font-size:13px; background:#F7F9FC;">Keyingi →</span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div style="display:flex; align-items:center; gap:4px; @media(max-width:639px){display:none !important;}">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span
                    style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #E8E8E8; border-radius:6px; color:#8899A8; font-size:15px; background:#F7F9FC; cursor:not-allowed;">
                    ‹
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #E8E8E8; border-radius:6px; color:#5750F1; font-size:15px; text-decoration:none; background:#fff; transition:all .2s;"
                   onmouseover="this.style.background='#EEF2FF'" onmouseout="this.style.background='#fff'">
                    ‹
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span
                        style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; color:#8899A8; font-size:13px;">...</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #5750F1; border-radius:6px; color:#fff; font-size:13px; font-weight:600; background:#5750F1;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #E8E8E8; border-radius:6px; color:#1C2434; font-size:13px; text-decoration:none; background:#fff; transition:all .2s;"
                               onmouseover="this.style.background='#EEF2FF'; this.style.color='#5750F1'"
                               onmouseout="this.style.background='#fff'; this.style.color='#1C2434'">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #E8E8E8; border-radius:6px; color:#5750F1; font-size:15px; text-decoration:none; background:#fff; transition:all .2s;"
                   onmouseover="this.style.background='#EEF2FF'" onmouseout="this.style.background='#fff'">
                    ›
                </a>
            @else
                <span
                    style="width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1px solid #E8E8E8; border-radius:6px; color:#8899A8; font-size:15px; background:#F7F9FC; cursor:not-allowed;">
                    ›
                </span>
            @endif

        </div>

        {{-- Results Info (Right Side) --}}
        <div style="position:absolute; right:24px; font-size:12px; color:#8899A8;">
            @if ($paginator->firstItem())
                {{ $paginator->firstItem() }} dan {{ $paginator->lastItem() }} gacha, jami {{ $paginator->total() }} ta
            @else
                {{ $paginator->count() }} ta
            @endif
        </div>

    </div>
@endif
