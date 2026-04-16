<form action="{{ route('profile.addresses.store') }}" method="POST">
    @csrf
    <input type="text" name="full_name" placeholder="اسم المستلم بالكامل" required>
    <input type="text" name="phone" placeholder="رقم الموبايل" required>

    <select name="city" required>
        <option value="Cairo">القاهرة</option>
        <option value="Giza">الجيزة</option>
        </select>

    <input type="text" name="area" placeholder="المنطقة / الحي" required>
    <input type="text" name="street_address" placeholder="اسم الشارع" required>

    <label>
        <input type="checkbox" name="is_default" value="1"> تعيين كعنوان افتراضي للشحن
    </label>

    <button type="submit">حفظ العنوان</button>
</form>
