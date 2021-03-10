@section('title', 'Manage Contacts')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Contacts') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="overflow-y: auto;">
                            <div class="card-header">
                                <span>
                                    <b>Add Contacts with XML File</b>
                                </span>
                            </div>
                            <div class="card-body">
                                <form action="{{route('contacts.upload')}}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="xml_file">XML Contacts File</label>
                                        <input type="file" id="xml_file" class="form-control" name="xml_file">
                                        @error('xml_file')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Upload File</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="overflow-y: auto;">
                            <div class="card-header">
                                <span>
                                    <b>Manage Contacts</b>
                                </span>
                                <p style="float:right;">
                                    <a class="btn btn-sm btn-primary" href="{{route('contacts.create')}}">Add New Contact</a>
                                </p>
                            </div>
                            <div class="card-body">
                                @if($contacts->count()>0)
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Phone</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($contacts as $contact)
                                            <tr>
                                                <td>
                                                    {{$contacts->firstItem()+$loop->index}}
                                                </td>
                                                <td>
                                                    {{$contact->name}}
                                                </td>
                                                <td>
                                                    {{$contact->lastname}}
                                                </td>
                                                <td>
                                                    {{$contact->phone}}
                                                </td>
                                                <td>
                                                    <a href="{{route('contacts.edit', $contact->id)}}" class="btn btn-info btn-sm">
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" onclick="handleDelete({{$contact->id}})">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$contacts->links()}}
                                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="" method="POST" id="deleteContactForm">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Contact</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-center">Are you sure you want to delete this contact?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <h3>No Contacts Available</h3>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            function handleDelete(id) {
                var form = document.getElementById("deleteContactForm");
                form.action = '/contacts/' + id;
                $('#deleteModal').modal('show');
            }
        </script>
    @endsection
</x-app-layout>
