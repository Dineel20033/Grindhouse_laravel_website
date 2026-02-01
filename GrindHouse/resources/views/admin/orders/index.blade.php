@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('admin_content')

<h1 class="text-3xl font-bold text-gray-800 mb-8">Manage Orders</h1>

@if ($orders->count() > 0)

<!-- Desktop View -->
<div class="hidden md:block bg-white rounded-xl shadow-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address & Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total (LKR)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm">{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="font-medium">{{ $order->customer_name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->email }}</p>
                        </td>
                        <td class="px-6 py-4 max-w-xs text-sm">
                            {{ Str::limit($order->address, 50) }}<br>
                            <span class="text-xs text-gray-500">Phone: {{ $order->phone }}</span>
                        </td>
                        <td class="px-6 py-4 text-left max-w-sm">
                            @foreach ($order->items as $item)
                                <p class="text-xs mb-1">{{ $item->product_name }} (x{{ $item->quantity }})</p>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-amber-700">
                            {{ number_format($order->total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            {{ $order->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting this order will remove all associated items. Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>

<!-- Mobile Card View -->
<div class="md:hidden space-y-4">
    @foreach ($orders as $order)
        <div class="bg-white p-4 rounded-xl shadow border border-gray-100 flex flex-col gap-3">
             <div class="flex justify-between items-start border-b border-gray-100 pb-2">
                 <div>
                     <span class="font-mono text-sm font-bold text-gray-800">#{{ $order->id }}</span>
                     <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                 </div>
                 <div class="text-right">
                     <p class="font-bold text-amber-700 text-lg">LKR {{ number_format($order->total, 2) }}</p>
                 </div>
             </div>
             
             <div>
                <p class="font-semibold text-gray-800">{{ $order->customer_name }}</p>
                <div class="text-xs text-gray-500 mt-1">
                    <p>{{ $order->email }}</p>
                    <p>{{ $order->phone }}</p>
                    <p class="truncate">{{ $order->address }}</p>
                </div>
             </div>

             <div class="bg-gray-50 p-2 rounded text-xs text-gray-700">
                 <p class="font-semibold mb-1">Items:</p>
                 @foreach ($order->items as $item)
                     <div class="flex justify-between">
                         <span>{{ $item->product_name }}</span>
                         <span class="font-medium">x{{ $item->quantity }}</span>
                     </div>
                 @endforeach
             </div>

             <div class="mt-2 text-right">
                 <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting this order will remove all associated items. Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-xs font-bold w-full">
                        Delete Order
                    </button>
                </form>
             </div>
        </div>
    @endforeach
</div>

@else
    <div class="bg-white rounded-xl shadow-lg p-10 text-center">
        <p class="text-gray-500">No orders have been placed yet.</p>
    </div>
@endif

@endsection