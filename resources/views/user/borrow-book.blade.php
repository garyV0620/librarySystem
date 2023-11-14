<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book List') }}
        </h2>
    </x-slot>
	<x-alert-message :message="session()->get('message')" />
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-5 container">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5" id="bookTable">
                    <thead class="text-white">
                        @foreach ($books as $book)
                            <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">Title</th>
                                <th class="p-3 text-left">Author</th>
                                <th class="p-3 text-left">Quantity</th>
                                <th class="p-3 text-left" width="150px">Book Status</th>
                                <th class="p-3 text-center" >Borrow</th>
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
                                    <x-form-action method="POST" label="Borrow" action="{{ route('borrow-book',[$book]) }}" />
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
       
        $('.form-action').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit behavior
            var form_action = $(this).data('label');
            Swal.fire({
            title: 'Do you want to '+ form_action +' this Book?',
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
