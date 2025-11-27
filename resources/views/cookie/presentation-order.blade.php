@php
    // Read cookie
   $raw = request()->cookie('presentation_order', '[]');
   $orderFromCookie = json_decode($raw, true);
   // Allowed components default order
   $defaultOrder = [
        'home.newpresentations',
        'home.mypresentations',
        'home.studypresentations',
        'home.nextilearn'
        ];

   // Sanitize: keep only allowed values
   $order = collect(is_array($orderFromCookie) ? $orderFromCookie : [])
       ->filter(fn ($c) => in_array($c, $defaultOrder, true))
       ->values()
       ->all();

   // Ensure all defaults appear (append any missing ones, preserving cookie order first)
   $order = array_values(array_unique(array_merge($order, $defaultOrder)));
@endphp

<div class="mt-2 p-4">
    <ul id="component-list" class="max-w-xs flex flex-col">
        @foreach ($order as $component)
            <li class="inline-flex items-center gap-x-3 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200"
                data-component="{{ $component }}">
                <svg class="hs-handle cursor-grab shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="5 9 2 12 5 15"></polyline>
                    <polyline points="9 5 12 2 15 5"></polyline>
                    <polyline points="15 19 12 22 9 19"></polyline>
                    <polyline points="19 9 22 12 19 15"></polyline>
                    <line x1="2" x2="22" y1="12" y2="12"></line>
                    <line x1="12" x2="12" y1="2" y2="22"></line>
                </svg>
                {{ $componentLabels[$component] ?? $component }}

            </li>
        @endforeach
    </ul>

    <button id="save-order"
            class="mt-2 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-blue-600 text-blue-600
            hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50
            disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400">
        Save order
    </button>

    <p id="order-message" class="text-sm text-green-700 mt-2 hidden">
        Order saved!
    </p>
</div>

<script>
    document.getElementById('save-order').addEventListener('click', function () {
        const items = document.querySelectorAll('#component-list [data-component]');
        const order = [];
        items.forEach(el => order.push(el.dataset.component));

        fetch("{{ route('presentation-order.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ order })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'ok') {
                    const msg = document.getElementById('order-message');
                    msg.classList.remove('hidden');
                    msg.textContent = 'Order saved!';
                }
            })
            .catch(err => {
                console.error(err);
            });
    });
</script>

