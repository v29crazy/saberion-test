<x-app-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-label for="code" value="{{ __('Code') }}" />
                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus autocomplete="code" />
            </div>
            
            <div class="mt-4">
                <x-label for="category" value="{{ __('Category') }}" />
                <x-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category')" required autocomplete="category" />
            </div>

            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                <x-textarea id="description" class="block mt-1 w-full" name="description" :value="old('description')" required autocomplete="description" />
            </div>

            <div class="mt-4">
                <x-label for="selling_price" value="{{ __('Selling Price') }}" />
                <x-input id="selling_price" class="block mt-1 w-full " type="number" name="selling_price" :value="old('selling_price')" required autocomplete="selling_price" />
            </div>

            <div class="mt-4">
                <x-label for="special_price" value="{{ __('Special Price') }}" />
                <x-input id="special_price" class="block mt-1 w-full" type="number" name="special_price" :value="old('special_price')" required autocomplete="special_price" />
            </div>

            <div class="mt-4">
                <x-label for="status" value="{{ __('Status') }}" />
                <select id="status" required name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="Draft">Draft</option>
                    <option value="Published">Published</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>

            <div class="mt-4 flex">
                <input type="checkbox" wire:model="selectedRoles" id="is_delivery_available" name="is_delivery_available" value="1" class="mr-2">
                <x-label for="is_delivery_available" class="mr-4" value="{{ __('Is Delivery Available') }}" />
            </div>
            
            <div class="mt-4">
                <x-label for="image" value="{{ __('Image') }}" />
                <input type="file" wire:model="image" id="image" name="image" required>
            </div>

            <hr class="mt-4">
            
            <div class="mt-4">
                <h2 class="text-md font-semibold">Product Attributes</h2>

                <div id="attributes-container">
                    <div class="mt-2 flex items-center">
                        <input type="text" name="attributes[0][name]" class="w-20 mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Name" required>
                        <input type="text" name="attributes[0][attribute_value]"  class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Value" required>
                        <button type="button" onclick="addAttributeField()" class="ml-2 text-green-600 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase">Add Attribute</button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </x-authentication-card>

    
    <script>
        let attributeCount = 1;

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
            var container = document.getElementById('attributes-container');
            var attributeField = button.parentNode;
            container.removeChild(attributeField);
        }
    </script>
</x-guest-layout>
