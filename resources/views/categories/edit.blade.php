<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $category->name }}" required>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $category->description }}</textarea>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
