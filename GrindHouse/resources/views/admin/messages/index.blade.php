@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('admin_content')

<h1 class="text-3xl font-bold text-gray-800 mb-8">Contact Messages</h1>


<!-- Desktop View -->
<div class="hidden md:block bg-white rounded-xl shadow-lg overflow-x-auto">
    @if ($messages->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message Snippet</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($messages as $message)
                    <tr class="group">
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            {{ $message->first_name }} {{ $message->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $message->email }}
                        </td>
                        <td class="px-6 py-4 text-left max-w-xs text-sm">
                            <p class="truncate" title="{{ $message->message }}">
                                {{ Str::limit($message->message, 60) }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            {{ $message->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            {{-- <a href="#" class="text-blue-600 hover:text-blue-800 text-xs mr-2">View</a> --}}
                            
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="hidden group-hover:table-row bg-gray-50">
                        <td colspan="5" class="px-6 py-4 text-sm">
                            <p class="font-semibold text-gray-700 mb-2">Full Message:</p>
                            <p class="text-gray-600 whitespace-pre-line">{{ $message->message }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-gray-500 py-10">No contact messages found.</p>
    @endif
</div>

<!-- Mobile View -->
<div class="md:hidden space-y-4">
    @if ($messages->count() > 0)
        @foreach ($messages as $message)
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $message->first_name }} {{ $message->last_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $message->email }}</p>
                    </div>
                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">
                        {{ $message->created_at->format('M d') }}
                    </span>
                </div>
                
                <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                    <p class="text-gray-700 text-sm italic">
                        "{{ $message->message }}"
                    </p>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
            <p class="mt-1 text-sm text-gray-500">Your inbox is empty.</p>
        </div>
    @endif
</div>

@endsection