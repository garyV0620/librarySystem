<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Maintenance') }}
        </h2>
    </x-slot>
	<x-alert-message :message="session()->get('message')" />
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-5 container">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5" id="userTable">
                    <thead class="text-white">
                        @foreach ($users as $user)
                            <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th class="p-3 text-left">ID</th>
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">User Name</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left" width="150px">Email Status</th>
                                <th class="p-3 text-center" >Action</th>
                            </tr>
                        @endforeach
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                        @foreach ($users as $user)
                            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0  @if ( $user->deleted_at != null) !bg-red-100 @endif">
                                <td class="border-grey-light border hover:bg-gray-100 p-3">{{ $user->id }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->name }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->user_name }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->email }}</td>
                                <td class="border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if ( $user->email_verified_at == null)
                                        <p class="text-center py-1 text-sm text-red-400 bg-red-200 rounded-full">
                                            {{ __('Not Verified') }}
                                        </p>
                                    @else
                                        <p class="text-center py-1 text-sm text-blue-600 bg-blue-200 rounded-full">
                                            {{ __('Verified') }}
                                        </p>
                                    @endif
                                </td>
                                <td class=" text-center border-grey-light border hover:bg-gray-100 p-3 truncate">
                                    @if ( $user->deleted_at != null)
                                        <x-form-action label="Enable" action="{{ route('enable-user',[$user]) }}" />
                                    @else
                                        <x-form-action label="Disable" action="{{ route('disable-user',[$user]) }}" />
                                    @endif
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
            $('#userTable').DataTable().destroy();
        }else{
            $('#userTable').dataTable();
        }
        
        $( window ).on( "resize", function() {
            var viewportWidth = window.innerWidth;
            if (viewportWidth < 640) {
                $('#userTable').DataTable().destroy();
            }else{
                $('#userTable').dataTable();
            }
        });
       
        $('.form-action').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submit behavior
            var form_action = $(this).data('label');
            Swal.fire({
            title: 'Do you want to '+ form_action +' the user?',
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
