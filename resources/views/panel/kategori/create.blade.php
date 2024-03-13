<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori
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
                    <form action="{{ route('panel.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="title">Kategori Türü</label>
                                    <input type="text" class="form-control" name="title" id="title">
                                    <input type="hidden" name="slug" class="categories_slug">
                                </div>
                            </div>
                        
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="sayfaGirisi">Sayfa</label>
                                    <select id="sayfaGirisi" name="page" class="form-control">
                                        <option value="" disabled selected>Seçiniz</option>
                                        <option value="blog">Blog</option>
                                        <option value="urunler">Ürünler</option>
                                        <option value="news">News</option>
                                    </select>
                                </div>
                            </div>
                        </div>                        

                        <button type="submit" class="btn text-right text-decoration-none text-light"
                            style="background-color: #415a77">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
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

            $('.categories_slug').val(slugify(value));
            console.log(slugify(value));
        })
    </script>

</x-app-layout>