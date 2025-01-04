<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category_id" required>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="title">Product Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" max="99999999.99"
                        title="Please enter a valid price between 0 and 99999999.99" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="type">Type</label>
                        <div>
                            <label><input type="radio" name="type" value="Man" required> Man</label>
                            <label><input type="radio" name="type" value="Woman" required> Woman</label>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="tags">Tags</label>
                        <div>
                            @foreach ($tags as $tag)
                                <label><input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
