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
                        <div class="card">
                            <div class="card-header">
                                <span>
                                    <b>{{isset($contact)? 'Update contact' : 'Add New Contact'}}</b>
                                </span>
                            </div>
                            <div class="card-body">
                                <form action="{{isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    @if(isset($contact))
                                        @method('PUT')
                                    @endif

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{isset($contact)? $contact->name : old('name')}}">
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" id="lastname" class="form-control" name="lastname" value="{{isset($contact)? $contact->lastname : old('lastname')}}">
                                        @error('lastname')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" class="form-control" name="phone" value="{{isset($contact)? $contact->phone : old('phone')}}">
                                        @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success">{{isset($contact)? 'Update contact' : 'Add contact'}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
