<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Haberler
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
                    <form action="{{ url('panel/news/update/' . $news->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Haber Başlığı</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ $news->title }}">
                            <input type="hidden" name="slug" class="news_slug" value="{{ $news->slug }}">
                        </div>      
                        
                        <div class="form-group">
                            <label for="title">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control">
                                <option value="" disabled selected>Seçiniz</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id}}"@if ($category->id == $news->kategori_id) selected @endif>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contents">Haber İçeriği</label>
                            <textarea class="form-control" name="contents" id="contents" rows="4">{{ $news->contents }}</textarea>
                        </div>

                        <div class="form-group mt-3 mb-3 row">
                            <div class="col-6">
                                <label for="kapak_foto">Haber Başlık Fotoğrafı</label>
                                <input type="file" class="form-control" name="kapak_foto" id="kapak_foto">
                            </div>
                            <div class="col-6 d-flex justify-content-center">
                                <img src="{{ asset('assets/img/news_photo') . '/' . $news->header_img }}" alt=""
                                    width="50%">
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-12">
                                <label for="images">Haber Fotoğrafları</label>
                                <input type="file" class="form-control" name="images[]" id="images" multiple>
                            </div>
                        </div>

                        <button type="submit" class="btn text-right text-decoration-none text-light"
                            style="background-color: black;">GÖNDER</button>
                    </form>

                    {{-- belirli bir haberin fotoğraflarını göstermek için --}}
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Haber Fotoğrafları</h3>
                        </div>
                        @if ($resimler->count() > 0) 
                            @foreach ($resimler as $photo)
                                <div class="col-3">
                                    <form
                                        action="{{ route('deleteNewsImage', ['page' => 'news', 'id' => $photo->id]) }}"
                                        method="get" style="position: absolute;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Resmi Sil</button>
                                    </form>

                                    <img src="{{ asset('assets/img/news_photo') . '/' . $photo->url }}" alt=""
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

            $('.news_slug').val(slugify(value));
            console.log(slugify(value));
        })
        </script>

</x-app-layout>