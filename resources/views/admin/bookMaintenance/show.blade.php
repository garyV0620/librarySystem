<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Maintenance') }}
        </h2>
    </x-slot>
	<x-alert-message :message="session()->get('message')" />
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
            <div class="px-5 container">
                 <!-- Modal toggle -->
                 <div class="flex justify-center">
                    <button id="addBook" data-modal-target="add-book-modal" data-modal-toggle="add-book-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Add New Book
                    </button>
                 </div>
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5" id="bookTable">
                    <thead class="text-white">
                        @foreach ($books as $book)
                            <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">Title</th>
                                <th class="p-3 text-left">Author</th>
                                <th class="p-3 text-left">Quantity</th>
                                <th class="p-3 text-left" width="150px">Book Status</th>
                                <th class="p-3 text-center" >Update</th>
                                <th class="p-3 text-center" >Delete</th>
                            </tr>
                        @endforeach
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        @foreach ($books as $book)
                            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0  @if ($book->quantity == 0) !bg-red-100 @endif">
                               
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $book->title }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $book->author }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $book->quantity }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if (  $book->quantity == 0)
                                        <p class="text-center py-1 text-sm text-red-400 bg-red-200 rounded-full">
                                            {{ __('Not Available') }}
                                        </p>
                                    @else
                                        <p class="text-center py-1 text-sm text-blue-600 bg-blue-200 rounded-full">
                                            {{ __('Available') }}
                                        </p>
                                    @endif
                                </td>
                                <td class=" text-center border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    <x-form-action method="GET" label="Update" action="{{ route('books.edit',[$book]) }}" />
                                </td>
                                <td class=" text-center border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    <x-form-action otherMethod="delete" label="Delete" action="{{ route('books.destroy',[$book]) }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add/edit Book modal -->
        <div id="add-book-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            @if (isset($editBook))
                                Update Book
                            @else
                                Add New Book
                            @endif
                        </h3>
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-book-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" method="POST" action="{{ isset($editBook) ? route('books.update', [$editBook]) : route('books.store') }}">
                            @csrf
                            @if (isset($editBook))
                                @method('PUT')
                            @endif
                            <div>
                                <x-input-label for="title" :value="__('Book Title')" />
                                <x-text-input id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" type="text" name="title" :value="old('title', $editBook->title ?? '')"  autofocus autocomplete="title" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="author" :value="__('Book Author')" />
                                <x-text-input id="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" type="text" name="author" :value="old('author', $editBook->author ?? '')"  autofocus autocomplete="author" />
                                <x-input-error :messages="$errors->get('author')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="quantity" :value="__('Book quantity')" />
                                <x-text-input id="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" type="number" name="quantity" :value="old('quantity', $editBook->quantity ?? '')"  autofocus autocomplete="quantity" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <script>
    $(document).ready(function() {
        var viewportWidth = window.innerWidth;
        if (viewportWidth < 640) {
            $('#bookTable').DataTable().destroy();
        }else{
            $('#bookTable').dataTable();
        }
        
        $( window ).on( "resize", function() {
            var viewportWidth = window.innerWidth;
            if (viewportWidth < 640) {
                $('#bookTable').DataTable().destroy();
            }else{
                $('#bookTable').dataTable();
            }
        });
       
        //show modal on error and edit
        @if (count($errors) > 0 || isset($editBook))
            $('#addBook').click();
        @endif

        $('#addBook').click(function() {
            if (window.location.href.indexOf("edit") > -1) {
                window.location.href = '{{ route('books.index') }}';
                return false;
            }
        });
        
        $('.form-action').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit behavior
            var form_action = $(this).data('label');
            Swal.fire({
            title: 'Do you want to '+ form_action +' the Book?',
            showDenyButton: true,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            },
            }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed to enable the user, submit the form
                this.submit();
            } else if (result.isDenied) {
                // User declined to enable the user, prevent form submission
                Swal.fire('Changes are not saved', '', 'info');
            }
            });
        });
    });
    </script>
</x-app-layout>
