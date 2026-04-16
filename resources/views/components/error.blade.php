@props(['name'])

@error($name)
    <div class="label pb-0">
        <span class="label-text-alt text-error font-bold animate-pulse italic">
            * {{ $message }}
        </span>
    </div>
@enderror
