<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Referanslar
        </h2>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </x-slot>
    <div class="py-12">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card" style="width: 75%; background-color: #778da9; border-radius: 1rem;">
                <div class="card-body bg-light" style="margin: 1rem; border-radius: 1rem;">
                    <p class="text-dark" style="font-family: Raleway; font-weight">
                        <strong>
                            @if (\Session::has('message'))
                                {{ \Session::get('message') }}
                            @endif
                        </strong>
                    </p>
                    <form action="{{ url('panel/referanslar/update/' . $referanslar->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Referans İsmi</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $referanslar->name }}">
                        </div>

                        <div class="form-group">
                            <label for="title">Referans Emaili</label>
                            <input type="text" class="form-control" name="email" id="email"
                                value="{{ $referanslar->email }}">
                        </div>

                        <button type="submit" class="btn text-right text-decoration-none text-light"
                            style="background-color: black;">GÖNDER</button>
                    </form>
                </div>
            </div>
        </div>

</x-app-layout>