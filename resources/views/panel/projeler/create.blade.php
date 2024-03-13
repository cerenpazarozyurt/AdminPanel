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
                    <form action="{{ route('panel.projeler.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Proje İsmi</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>

                        <div class="form-group">
                            <label for="contents">Proje İçeriği</label>
                            <textarea class="form-control" name="contents" id="proje_icerik" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="kapak_foto">Proje Fotoğrafları</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple>
                        </div>

                        <button type="submit" class="btn text-right text-decoration-none text-light"
                            style="background-color: #415a77">GÖNDER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                CKEDITOR.replace('proje_icerik');
                //$('.ckeditor').ckeditor();
            });
        </script>
</x-app-layout>