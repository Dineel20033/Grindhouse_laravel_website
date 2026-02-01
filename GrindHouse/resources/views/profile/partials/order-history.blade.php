<div>
    <h2 class="text-lg font-medium text-gray-900">Order History</h2>
    <p class="mt-1 text-sm text-gray-600">
        Your past orders and items purchased.
    </p>

    <div class="mt-6 space-y-6">
        @forelse ($orders as $order)
            <div class="border rounded-lg p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="text-sm text-gray-700">
                        <span class="font-semibold">Order #{{ $order->id }}</span>
                        <span class="ml-2 text-gray-500">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="text-sm font-semibold text-gray-900">
                        Total: LKR {{ number_format($order->total, 2) }}
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-xs uppercase text-gray-500 mb-2">Items</div>
                    <ul class="space-y-2">
                        @foreach ($order->items as $item)
                            <li class="flex items-center justify-between text-sm">
                                <span>{{ $item->product_name }}</span>
                                <span class="text-gray-600">x{{ $item->quantity }} · LKR {{ number_format($item->price, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">No orders yet.</p>
        @endforelse
    </div>
</div>
