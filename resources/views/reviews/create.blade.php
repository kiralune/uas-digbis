@extends('layouts.app')

@section('content')
<main class="max-w-3xl mx-auto px-6 py-16">
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 md:p-10">
        <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">Rating & Review</p>
        <h1 class="text-4xl font-black mt-2">{{ $transaction->event->title }}</h1>
        <p class="text-slate-500 mt-2">Bagikan pengalaman Anda setelah acara selesai.</p>

        @php
            $isEdit = isset($review) && $review;
        @endphp

        <form method="POST" action="{{ $isEdit ? route('reviews.update', $transaction->order_id) : route('reviews.store', $transaction->order_id) }}" class="space-y-6 mt-8">
            @csrf
            @if($isEdit)
                @method('PATCH')
            @endif
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-3">Rating</label>
                <div class="flex items-center gap-3 flex-wrap" data-star-picker>
                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" class="sr-only peer" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <span class="star inline-flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-200 text-2xl leading-none text-slate-300 transition duration-150 ease-out peer-hover:border-indigo-500 peer-hover:bg-indigo-50 peer-hover:text-amber-400 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-amber-400">
                                ★
                            </span>
                        </label>
                    @endfor
                </div>
                <p class="mt-2 text-xs text-slate-400">Klik bintang untuk memilih rating 1 sampai 5.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Testimoni</label>
                <textarea name="testimonial" rows="6" class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:border-indigo-600 outline-none" placeholder="Ceritakan pengalaman Anda...">{{ old('testimonial', $review->testimonial ?? '') }}</textarea>
            </div>

            <button type="submit" class="px-6 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">{{ $isEdit ? 'Simpan Perubahan' : 'Kirim Review' }}</button>
        </form>
    </div>
</main>

<script>
    const starPicker = document.querySelector('[data-star-picker]');
    if (starPicker) {
        const inputs = Array.from(starPicker.querySelectorAll('input[type="radio"]'));
        const stars = Array.from(starPicker.querySelectorAll('.star'));

        const paint = (activeValue) => {
            stars.forEach((star, index) => {
                const value = index + 1;
                const active = value <= activeValue;
                star.classList.toggle('border-indigo-600', active);
                star.classList.toggle('bg-indigo-50', active);
                star.classList.toggle('text-amber-400', active);
                star.classList.toggle('text-slate-300', !active);
                star.classList.toggle('border-slate-200', !active);
            });
        };

        const current = inputs.find((input) => input.checked);
        paint(current ? Number(current.value) : {{ old('rating', $review->rating ?? 0) }});

        const preselected = inputs.find((input) => Number(input.value) === Number({{ old('rating', $review->rating ?? 0) }}));
        if (preselected) {
            preselected.checked = true;
            paint(Number(preselected.value));
        }

        inputs.forEach((input) => {
            input.addEventListener('change', () => paint(Number(input.value)));
        });

        starPicker.addEventListener('mouseover', (event) => {
            const star = event.target.closest('.star');
            if (!star) return;
            const index = stars.indexOf(star);
            if (index >= 0) paint(index + 1);
        });

        starPicker.addEventListener('mouseleave', () => {
            const selected = inputs.find((input) => input.checked);
            paint(selected ? Number(selected.value) : 0);
        });
    }
</script>
@endsection