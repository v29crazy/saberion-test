<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <x-label for="code" value="{{ __('Code') }}" />
                <x-input id="code" class="block mt-1 w-full" type="text" name="code" value="{{ old('code', $product->code) }}" required autofocus autocomplete="code" />
            </div>
            
            <div class="mt-4">
                <x-label for="category" value="{{ __('Category') }}" />
                <x-input id="category" class="block mt-1 w-full" type="text" name="category" value="{{ old('category', $product->category) }}" required autocomplete="category" />
            </div>

            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                
                <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                name="description" required autocomplete="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mt-4">
                <x-label for="selling_price" value="{{ __('Selling Price') }}" />
                <x-input id="selling_price" class="block mt-1 w-full " type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required autocomplete="selling_price" />
            </div>

            <div class="mt-4">
                <x-label for="special_price" value="{{ __('Special Price') }}" />
                <x-input id="special_price" class="block mt-1 w-full" type="number" name="special_price" value="{{ old('special_price', $product->special_price) }}" required autocomplete="special_price" />
            </div>

            <div class="mt-4">
                <x-label for="status" value="{{ __('Status') }}" />
                <select id="status" required name="status"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="Draft" @if($product->status == "Draft") selected @endif>Draft</option>
                    <option value="Published" @if($product->status == "Published") selected @endif>Published</option>
                    <option value="Out of Stock" @if($product->status == "Out of Stock") selected @endif>Out of Stock</option>
                </select>
            </div>

            <div class="mt-4 flex">
                <input type="checkbox" @checked($product->is_delivery_available) value="1" id="is_delivery_available" name="is_delivery_available" class="mr-2">
                <x-label for="is_delivery_available" class="mr-4" value="{{ __('Is Delivery Available') }}" />
            </div>
            
            <div class="mt-4">
                <x-label for="image" value="{{ __('Image') }}" />
                <input type="file" value="{{ old('image', $product->image) }}" id="image" name="image">
                @if ($product->image)
                    {{ $product->image}}
                @endif
            </div>

            <hr class="mt-4">

            <div class="mt-4">
                <h2 class="text-md font-semibold">Product Attributes</h2>

                <div id="attributes-container">
                    @foreach($product->attributes as $index => $attribute)
                        <div class="mt-2 flex items-center">
                            <input type="text" name="attributes[{{ $index }}][name]" class="w-20 mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Name" value="{{ old('attributes.'.$index.'.name', $attribute->name) }}" required>
                            <input type="text" name="attributes[{{ $index }}][attribute_value]" class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Value" value="{{ old('attributes.'.$index.'.attribute_value', $attribute->attribute_value) }}" required>
                            <button type="button" onclick="removeAttributeField(this)" class="ml-2 text-red-500 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase">Remove</button>
                        </div>
                    @endforeach

                    <div class="mt-2 flex items-center">
                        <input type="text" name="attributes[{{ count($product->attributes) }}][name]" class="w-20 mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Name" required>
                        <input type="text" name="attributes[{{ count($product->attributes) }}][attribute_value]" class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Value" required>
                        <button type="button" onclick="addAttributeField()" class="ml-2 text-green-600 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase">Add Attribute</button>
                    </div>
                </div>
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update Product') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        let attributeCount = {{ count($product->attributes) }};

        function addAttributeField() {
            var container = document.getElementById('attributes-container');
            var attributeField = document.createElement('div');
            attributeField.className = 'mt-2 flex items-center';
            attributeField.innerHTML = `
                <input type="text" name="attributes[${attributeCount}][name]" class="w-20 mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Name" required>
                <input type="text" name="attributes[${attributeCount}][attribute_value]" class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Attribute Value" required>
                <button type="button" onclick="removeAttributeField(this)" class="ml-2 text-red-500 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase">Remove</button>
            `;
            container.appendChild(attributeField);

            attributeCount++;
        }

        function removeAttributeField(button) {
            if (confirm("Are you sure you want to remove this attribute?")) {
                var container = document.getElementById('attributes-container');
                var attributeField = button.parentNode;
                container.removeChild(attributeField);
            }
        }
    </script>
</x-app-layout>
