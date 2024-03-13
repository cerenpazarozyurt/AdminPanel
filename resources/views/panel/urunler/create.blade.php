<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ürünler
        </h2>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">  {{--bootstrap linkini buraya eklemek sıkıntı mı--}}
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
                    <form action="{{ route('panel.urunler.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Ürün İsmi</label>
                            <input type="text" class="form-control" name="title" id="title">
                            <input type="hidden" name="slug" class="urunler_slug">
                        </div>

                        <div class="form-group">
                            <label for="title">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control">
                                <option value="" disabled selected>Seçiniz</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id}}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kapak_foto">Ürün Kapak Fotoğrafı</label>
                            <input type="file" class="form-control" name="kapak_foto" id="kapak_foto">
                        </div>

                        <div class="form-group">
                            <label for="kapak_foto">Ürün Fotoğrafları</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple>
                        </div>

                        <div class="form-group">
                            <label for="contents">Ürün İçeriği</label>
                            <textarea class="form-control" name="contents" id="urunler_icerik" rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Ürün Fiyatı</label>
                            <input type="number" class="form-control" name="price" id="urun_fiyati" step="0.01">
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
                CKEDITOR.replace('urunler_icerik');
                //$('.ckeditor').ckeditor();
            });

            $('#title').on('change', function() {
            value = $('#title').val();
            //slugify(value) 
            function slugify(str) {
                return String(str)
                    .normalize('NFKD') // split accented characters into their base characters and diacritical marks
                    .replace(/[\u0300-\u036f]/g,
                    '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
                    .trim() // trim leading or trailing whitespace
                    .toLowerCase() // convert to lowercase
                    .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
                    .replace(/\s+/g, '-') // replace spaces with hyphens
                    .replace(/-+/g, '-'); // remove consecutive hyphens
            }

            $('.urunler_slug').val(slugify(value));
            console.log(slugify(value));
        })
        </script>
</x-app-layout>