@props(['name'])

@error($name)
    <div class="label pb-0">
        <span class="label-text-alt text-red-500 font-bold animate-pulse italic">
            * {{ $message }}
        </span>
    </div>
@enderror
