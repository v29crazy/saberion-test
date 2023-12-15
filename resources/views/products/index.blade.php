<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">Product List</h2>
                    <p class="text-gray-600">Additional details or description goes here.</p>
                </div>
            
                <div>
                    <a href="{{ route('products.create') }}" type="button" class="px-4 py-2 bg-red-600 text-white rounded">
                        {{ __('Add New Product') }}
                    </a>
                </div>
            </div>

            <form action="{{ route('products.index') }}" method="get" class="py-5">
                <label for="sort_by">Sort By:</label>
                <select name="sort_by" id="sort_by" class="mt-1border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="code" {{ request('sort_by') == 'code' ? 'selected' : '' }}>Code</option>
                </select>
            
                <label for="sort_order">Sort Order:</label>
                <select name="sort_order" id="sort_order" class="mt-1border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or code" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            
                <x-button class="ml-4">
                    {{ __('Apply Filters') }}
                </x-button>
            </form>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card bg-gray-200 p-2 border-2 rounded-md">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->code }}</h5>
                                <p class="card-text">{{ $product->name }}</p>
                                <div class="flex">
                                    <a type="button" href="{{ route('products.show', $product->id) }}" class="bg-gray-800 text-sm text-white rounded px-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">View</a>

                                    <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="bg-red-600 text-sm text-white rounded px-2 ml-4 delete-product border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
<script>
    $('.delete-product').click(function(e){
        e.preventDefault() 
        if (confirm('Are you sure?')) {
            $(e.target).closest('form').submit() 
        }
    });
</script>