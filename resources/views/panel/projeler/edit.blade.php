<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Projeler
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
                    <form action="{{ url('panel/projeler/update/' . $projeler->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Proje İsmi</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ $projeler->name }}">
                        </div>

                        <div class="form-group">
                            <label for="contents">Proje İçeriği</label>
                            <textarea class="form-control" name="contents" id="contents" rows="4">{{ $projeler->contents }}</textarea>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-12">
                                <label for="images">Proje Fotoğrafları</label>
                                <input type="file" class="form-control" name="images[]" id="images" multiple>
                            </div>
                        </div>

                        <button type="submit" class="btn text-right text-decoration-none text-light"
                            style="background-color: black;">GÖNDER</button>
                    </form>

                    {{-- belirli bir bloğun fotoğraflarını göstermek için --}}
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Proje Fotoğrafları</h3>
                        </div>
                        @if ($resimler->count() > 0) 
                            @foreach ($resimler as $photo)
                                <div class="col-3">
                                    <form
                                        action="{{ route('deleteNewsImage', ['page' => 'projeler', 'id' => $photo->id]) }}"
                                        {{-- Her fotoğraf için bir silme formu oluşturulur. Bu form, ilgili fotoğrafın ID'sini ve silme işlemi için yönlendirilecek URL'yi içerir. --}} method="get" style="position: absolute;">
                                        @csrf {{-- formun güvenliğini sağlamak için kullanılır. --}}
                                        <button type="submit" class="btn btn-secondary">Resmi Sil</button>
                                    </form>

                                    <img src="{{ asset('assets/img/projeler_photo') . '/' . $photo->url }}" alt=""
                                        width="50%">
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <h3 class="text-center">Fotoğraf Bulunamadı</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                CKEDITOR.replace('contents');
                //$('.ckeditor').ckeditor();
            });
        </script>

</x-app-layout>