<x-layout title="عناويني">

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root { --accent: #c9a96e; }
</style>
@endpush

<div class="bg-base-200 min-h-screen py-8 px-4" dir="rtl" style="font-family:'Cairo',sans-serif;">
<div class="max-w-2xl mx-auto">

  {{-- Header --}}
  <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
      <h1 class="text-xl font-bold">عناويني</h1>
      <p class="text-xs text-base-content/50 mt-1">إدارة عناوين التوصيل الخاصة بك</p>
    </div>
    <a href="{{ route('profile.index') }}"
      class="btn btn-sm btn-ghost border border-base-300 gap-2 font-normal"
      style="font-family:'Cairo',sans-serif;">
      <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" d="M9 5l7 7-7 7"/>
      </svg>
      الملف الشخصي
    </a>
  </div>

  {{-- Flash Messages --}}
  @if(session('success'))
  <div class="alert mb-4 py-3 px-4 text-sm rounded-xl flex items-center gap-2"
    style="background:rgba(76,175,125,.1);border:1px solid rgba(76,175,125,.25);color:#4caf7d;">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
  </div>
  @endif

  @if(session('error'))
  <div class="alert mb-4 py-3 px-4 text-sm rounded-xl flex items-center gap-2"
    style="background:rgba(224,85,85,.1);border:1px solid rgba(224,85,85,.25);color:#e05555;">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/>
    </svg>
    {{ session('error') }}
  </div>
  @endif

  {{-- Add New Address Form --}}
  <div class="card bg-base-100 border border-base-300 shadow-none mb-4">
    <div class="card-body p-5">

      <div class="flex items-center justify-between mb-4 pb-3 border-b border-base-300">
        <h2 class="text-sm font-bold flex items-center gap-2">
          <svg class="w-4 h-4" style="color:var(--accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
          </svg>
          إضافة عنوان جديد
        </h2>
        <button type="button" onclick="toggleForm()"
          class="btn btn-xs btn-ghost border border-base-300 font-normal text-base-content/50"
          id="toggleBtn">
          إظهار
        </button>
      </div>

      <div id="addForm" style="display:none;">
        <form action="{{ route('addresses.store') }}" method="POST">
          @csrf

          <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">الاسم الأول  <span style="color:#e05555">*</span></label>
              <input type="text" name="first_name"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('first_name') }}"
                placeholder="أحمد"  />
              @error('first_name')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>
              <div>
                  <label class="text-xs text-base-content/50 mb-1 block">الاسم الأخير  <span style="color:#e05555">*</span></label>
                  <input type="text" name="last_name"
                         class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                         value="{{ old('last_name') }}"
                         placeholder="محمد"  />
                  @error('last_name')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
              </div>
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">رقم الهاتف <span style="color:#e05555">*</span></label>
              <input type="tel" name="phone"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('phone') }}"
                placeholder="01012345678"  />
              @error('phone')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="text-xs text-base-content/50 mb-1 block">عنوان الشارع <span style="color:#e05555">*</span></label>
            <input type="text" name="street_address"
              class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
              value="{{ old('street_address') }}"
              placeholder="الشارع، المبنى، الشقة"  />
            @error('street_address')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
          </div>

          <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">الحي / المنطقة</label>
              <input type="text" name="area"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('area') }}"
                placeholder="المعادي" />
              @error('area')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">رقم المبنى</label>
              <input type="text" name="building_number"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('building_number') }}"
                placeholder="12" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">المدينة <span style="color:#e05555">*</span></label>
              <input type="text" name="city"
                class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                value="{{ old('city') }}"
                placeholder="طنطا"  />
              @error('city')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>
            <div>
              <label class="text-xs text-base-content/50 mb-1 block">المحافظة <span style="color:#e05555">*</span></label>
              <select name="governorate"
                class="select select-sm select-bordered w-full focus:border-[#c9a96e]" >
                <option value="" disabled {{ !old('governorate') ? 'selected' : '' }}>اختر المحافظة</option>
                @foreach(['القاهرة','الجيزة','الإسكندرية','الغربية','الشرقية','المنوفية','الدقهلية','كفر الشيخ','دمياط','البحيرة','الإسماعيلية','بورسعيد','السويس','شمال سيناء','جنوب سيناء','الفيوم','بني سويف','المنيا','أسيوط','سوهاج','قنا','الأقصر','أسوان','مطروح','الوادي الجديد','البحر الأحمر'] as $gov)
                  <option value="{{ $gov }}" {{ old('governorate') === $gov ? 'selected' : '' }}>{{ $gov }}</option>
                @endforeach
              </select>
              @error('governorate')<span class="text-xs text-error mt-1 block">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="flex items-center gap-2 mb-4">
            <input type="checkbox" name="is_default" value="1" id="is_default"
              class="checkbox checkbox-xs" style="accent-color:var(--accent);"
              {{ old('is_default') ? 'checked' : '' }} />
            <label for="is_default" class="text-xs text-base-content/60 cursor-pointer">
              تعيين كعنوان افتراضي
            </label>
          </div>

          <button type="submit" class="btn btn-sm gap-2 font-bold"
            style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
            </svg>
            حفظ العنوان
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Addresses List --}}
  @if($addresses->isEmpty())
    <div class="card bg-base-100 border border-base-300 shadow-none">
      <div class="card-body items-center text-center py-12">
        <div class="opacity-10 mb-4">
          <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
            <path stroke-linecap="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <p class="text-xs font-bold tracking-widest text-base-content/40 uppercase">لا توجد عناوين محفوظة</p>
        <p class="text-xs text-base-content/30 mt-1">أضف عنوانك الأول لتسريع عملية الشراء</p>
      </div>
    </div>

  @else
    <div class="space-y-3">
      @foreach($addresses as $address)
      <div class="card bg-base-100 border shadow-none transition-colors
        {{ $address->is_default ? 'border-[#c9a96e]' : 'border-base-300' }}"
        style="{{ $address->is_default ? 'background:rgba(201,169,110,0.03)' : '' }}">
        <div class="card-body p-4">
          <div class="flex items-start justify-between gap-3 flex-wrap">

            {{-- Info --}}
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1 flex-wrap">
                <p class="font-semibold text-sm">{{ $address->full_name }}</p>
                @if($address->is_default)
                  <span class="badge badge-xs font-bold"
                    style="background:rgba(201,169,110,.12);color:var(--accent);border-color:rgba(201,169,110,.2);">
                    ⭐ افتراضي
                  </span>
                @endif
              </div>
              <p class="text-xs text-base-content/50">
                {{ $address->street_address }}
                @if($address->building_number) — مبنى {{ $address->building_number }}@endif
              </p>
              @if($address->area)
              <p class="text-xs text-base-content/40 mt-0.5">{{ $address->area }}، {{ $address->city }}، {{ $address->governorate ?? $address->city }}</p>
              @else
              <p class="text-xs text-base-content/40 mt-0.5">{{ $address->city }}، {{ $address->governorate ?? $address->city }}</p>
              @endif
              <p class="text-xs text-base-content/40 mt-0.5 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $address->phone }}
              </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-2 flex-shrink-0">
              @if(!$address->is_default)
              <form action="{{ route('addresses.default', $address) }}" method="POST">
                @csrf
                <button type="submit"
                  class="btn btn-xs btn-ghost border border-base-300 w-full font-normal text-base-content/50 hover:border-[#c9a96e] hover:text-[#c9a96e]"
                  style="font-family:'Cairo',sans-serif;">
                  تعيين افتراضي
                </button>
              </form>
              @endif

              <button onclick="openEdit({{ $address->id }})"
                class="btn btn-xs btn-ghost border border-base-300 w-full font-normal text-base-content/50"
                style="font-family:'Cairo',sans-serif;">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                تعديل
              </button>

              <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                onsubmit="return confirm('هل تريد حذف هذا العنوان؟')">
                @csrf @method('DELETE')
                <button type="submit"
                  class="btn btn-xs btn-ghost border border-base-300 w-full font-normal text-error hover:border-error"
                  style="font-family:'Cairo',sans-serif;">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M4 7h16M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/>
                  </svg>
                  حذف
                </button>
              </form>
            </div>

          </div>

          {{-- Edit Form (hidden) --}}
          <div id="edit-{{ $address->id }}" style="display:none;" class="mt-4 pt-4 border-t border-base-300">
            <form action="{{ route('addresses.update', $address) }}" method="POST">
              @csrf @method('PUT')

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">الاسم الأول</label>
                  <input type="text" name="first_name"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    value="{{ $address->first_name }}"  />
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">الاسم الأخير</label>
                  <input type="text" name="last_name"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    value="{{ $address->last_name }}"  />
                </div>
              </div>

                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">رقم الهاتف</label>
                  <input type="tel" name="phone"
                    class="input input-sm input-bordered w-full/50 focus:border-[#c9a96e]"
                    value="{{ $address->phone }}"  />
                </div>


              <div class="mb-3">
                <label class="text-xs text-base-content/50 mb-1 block">عنوان الشارع</label>
                <input type="text" name="street_address"
                  class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                  value="{{ $address->street_address }}"  />
              </div>

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">الحي / المنطقة</label>
                  <input type="text" name="area"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    value="{{ $address->area }}" />
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">رقم المبنى</label>
                  <input type="text" name="building_number"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    value="{{ $address->building_number }}" />
                </div>
              </div>

              <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">المدينة</label>
                  <input type="text" name="city"
                    class="input input-sm input-bordered w-full focus:border-[#c9a96e]"
                    value="{{ $address->city }}"  />
                </div>
                <div>
                  <label class="text-xs text-base-content/50 mb-1 block">المحافظة</label>
                  <select name="governorate"
                    class="select select-sm select-bordered w-full focus:border-[#c9a96e]" >
                    @foreach(['القاهرة','الجيزة','الإسكندرية','الغربية','الشرقية','المنوفية','الدقهلية','كفر الشيخ','دمياط','البحيرة','الإسماعيلية','بورسعيد','السويس','شمال سيناء','جنوب سيناء','الفيوم','بني سويف','المنيا','أسيوط','سوهاج','قنا','الأقصر','أسوان','مطروح','الوادي الجديد','البحر الأحمر'] as $gov)
                      <option value="{{ $gov }}" {{ ($address->governorate ?? $address->city) === $gov ? 'selected' : '' }}>{{ $gov }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="flex items-center gap-2 mb-4">
                <input type="checkbox" name="is_default" value="1"
                  class="checkbox checkbox-xs" style="accent-color:var(--accent);"
                  {{ $address->is_default ? 'checked' : '' }} />
                <label class="text-xs text-base-content/60">تعيين كعنوان افتراضي</label>
              </div>

              <div class="flex gap-2">
                <button type="submit" class="btn btn-sm gap-1 font-bold"
                  style="background:var(--accent);border-color:var(--accent);color:#0c0c0e;">
                  <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                  </svg>
                  حفظ التعديلات
                </button>
                <button type="button" onclick="closeEdit({{ $address->id }})"
                  class="btn btn-sm btn-ghost border border-base-300 font-normal text-base-content/50">
                  إلغاء
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
      @endforeach
    </div>
  @endif

</div>
</div>

@push('scripts')
<script>
function toggleForm() {
    const form = document.getElementById('addForm');
    const btn  = document.getElementById('toggleBtn');
    const visible = form.style.display !== 'none';
    form.style.display = visible ? 'none' : 'block';
    btn.textContent    = visible ? 'إظهار' : 'إخفاء';
}

// افتح تلقائياً لو في errors
@if($errors->any())
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addForm').style.display = 'block';
    document.getElementById('toggleBtn').textContent = 'إخفاء';
});
@endif

function openEdit(id) {
    // أغلق كل الـ edit forms الأخرى
    document.querySelectorAll('[id^="edit-"]').forEach(f => f.style.display = 'none');
    document.getElementById('edit-' + id).style.display = 'block';
}

function closeEdit(id) {
    document.getElementById('edit-' + id).style.display = 'none';
}
</script>
@endpush

</x-layout>
