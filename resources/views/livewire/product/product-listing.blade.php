<div class="space-y-6">
    <!-- Search and Sort Controls -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Search products..." 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                </div>
            </div>

            <!-- Sort Options -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">Sort by:</span>
                <select wire:model.live="sortBy" class="block w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="name">Name</option>
                    <option value="price">Price</option>
                    <option value="updated_at">Latest</option>
                </select>
                
                <button 
                    wire:click="changeSorting('{{ $sortBy }}')"
                    class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
                    title="Toggle sort direction"
                >
                    <svg class="h-5 w-5 transform {{ $sortDirection === 'desc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200 flex flex-col h-full">
                    <!-- Product Info -->
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-medium text-gray-900 text-lg mb-2">{{ $product->name }}</h3>
                        
                        <!-- Fixed height description container -->
                        <div class="mb-3 h-12 flex items-start">
                            @if($product->description)
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ Str::limit($product->description, 60) }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Spacer to push content to bottom -->
                        <div class="flex-1"></div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button 
                            wire:click="addToCart('{{ $product->uuid }}')"
                            @if($product->stock <= 0) disabled @endif
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 disabled:bg-gray-300 disabled:cursor-not-allowed"
                        >
                            @if($product->stock <= 0)
                                Out of Stock
                            @else
                                Add to Cart
                            @endif
                        </button>
                        
                        @if($product->stock <= 5 && $product->stock > 0)
                            <p class="text-sm text-orange-600 mt-2 text-center">Only {{ $product->stock }} left!</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($paginationData && $paginationData['total_pages'] > 1)
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing {{ $paginationData['from'] }} to {{ $paginationData['to'] }} of {{ $paginationData['total_data'] }} products
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($paginationData['current_page'] > 1)
                            <button 
                                wire:click="previousPage" 
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                Previous
                            </button>
                        @endif
                        
                        <span class="px-3 py-2 text-sm font-medium text-gray-900">
                            Page {{ $paginationData['current_page'] }} of {{ $paginationData['total_pages'] }}
                        </span>
                        
                        @if($paginationData['current_page'] < $paginationData['total_pages'])
                            <button 
                                wire:click="nextPage" 
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                Next
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m8-6v12" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-600">
                @if($search)
                    No products match your search "{{ $search }}". Try adjusting your search terms.
                @else
                    No products are available at the moment.
                @endif
            </p>
            
            @if($search)
                <button 
                    wire:click="$set('search', '')"
                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Clear search
                </button>
            @endif
        </div>
    @endif
</div>
