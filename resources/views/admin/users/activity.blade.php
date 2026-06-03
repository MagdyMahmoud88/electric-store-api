{{-- resources/views/admin/users/activity.blade.php --}}
<x-layout>

    <div class="admin-bar sticky top-[64px] z-40 w-full">
        <div class="page-container">
            <div class="admin-bar__inner">
                <div class="admin-bar__brand">
                    <a href="{{ route('admin.users.show', $user) }}" class="admin-nav-link">
                        ← رجوع لبروفايل {{ $user->name }}
                    </a>
                </div>

                {{-- فلترة بالنوع --}}
                <form method="GET">
                    <select name="activity_type" onchange="this.form.submit()"
                            style="font-size:12px;padding:6px 12px;border-radius:8px;background:var(--surface2);border:1px solid var(--border);color:var(--text);outline:none;">
                        <option value="">كل الأنشطة</option>
                        @foreach($activityTypes as $type)
                            <option value="{{ $type }}" {{ request('activity_type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="page-container" style="padding-top:32px;padding-bottom:32px;">

        <div>
            <h1 class="text-2xl font-bold" style="color:var(--text)">سجل النشاط الكامل</h1>
            <p style="font-size:13px;color:var(--text-muted);margin-top:4px;">{{ $user->name }} — {{ $user->email }}</p>
        </div>

        {{-- ══ Timeline ══ --}}
        <div class="dash-card">
            @forelse($activityLogs as $log)
                <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 18px;border-bottom:1px solid var(--border);transition:background .12s;"
                     onmouseover="this.style.background='var(--surface2)'"
                     onmouseout="this.style.background='transparent'">

                    {{-- Icon --}}
                    <div style="width:40px;height:40px;border-radius:50%;background:var(--surface2);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
                        {{ $log->icon() }}
                    </div>

                    {{-- Content --}}
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:13px;font-weight:600;color:var(--text);margin:0;">
                            {{ $log->description }}
                        </p>

                        {{-- Metadata --}}
                        @if($log->metadata)
                            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:6px;">
                                @foreach($log->metadata as $key => $value)
                                    @if($value)
                                        <span style="font-size:11px;background:var(--surface2);border:1px solid var(--border);color:var(--text-soft);padding:2px 8px;border-radius:99px;">
                            {{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- IP + URL --}}
                        <div style="display:flex;gap:16px;margin-top:6px;font-size:11px;color:var(--text-muted);">
                            @if($log->ip_address)
                                <span>🌐 {{ $log->ip_address }}</span>
                            @endif
                            @if($log->url)
                                <span title="{{ $log->url }}">🔗 {{ parse_url($log->url, PHP_URL_PATH) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Time --}}
                    <div style="text-align:left;flex-shrink:0;">
                        <p style="font-size:12px;color:var(--text-muted);">{{ $log->created_at->diffForHumans() }}</p>
                        <p style="font-size:11px;color:var(--text-muted);margin-top:2px;">{{ $log->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            @empty
                <div style="padding:64px;text-align:center;color:var(--text-muted);">
                    <p style="font-size:40px;margin-bottom:8px;">📭</p>
                    <p style="font-size:13px;">لا توجد نشاطات مسجّلة</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            {{ $activityLogs->withQueryString()->links() }}
        </div>

    </div>

</x-layout>
