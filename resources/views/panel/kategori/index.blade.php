<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori
        </h2>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </x-slot>
    <div class="py-12">
        <div class="d-flex justify-content-center align-items-center"
            style="background-color: #415a77 !important; margin-top:3rem;">
            <div class="card-body bg-light" style="margin: 1rem; border-radius: 1rem;">

                <div class="text-right mb-3" style="color:white">
                    <a href="{{ url('panel/categories/create') }}" method="get" class="btn btn-success"
                        style="background-color: #415a77;">Kategori Ekle</a>
                </div>

                <p class="text-dark" style="font-family: Raleway; font-weight">
                    {{-- eğer oturumda 'message' adında bir değişken varsa, bu değişkenin değerini ekrana yazdırmak için kullanılır. Yani, eğer bir mesaj varsa, bu mesajı ekrana yazacak. --}}
                    <strong>
                        @if (\Session::has('message'))
                            {{ \Session::get('message') }}
                        @endif
                    </strong>
                </p>

                <table class="table" style="color:white">
                    <thead>
                        <tr>
                            <th scope="col" style=color:black;>#</th>
                            <th scope="col" style=color:black;>Tür</th>
                            <th scope="col" style=color:black;>Sayfa</th>
                            <th scope="col" style="width: 5%; color:black;">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories->reverse() as $key => $value)
                            <tr style=color:black;>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $value->title }}</td>
                                <td>{{ $value->page }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ url('panel/categories/edit/' . $value->id) }}">Düzenle</a>

                                            <!-- Silme Butonu -->
                                            <a class="dropdown-item sil-btn" href="#" data-id="{{ $value->id }}"
                                                onclick="deleteCategory('{{ url('panel/categories/delete/' . $value->id) }}')">Sil</a>

                                            <script>
                                                // Global kapsamda confirmDelete fonksiyonunu tanımla
                                                var confirmDelete;

                                                function deleteCategory(url) {
                                                    // Silme modalını aç
                                                    $('#deleteCategoryModal').modal('show');

                                                    // Silme işlemini onayladığında bu URL'ye git
                                                    confirmDelete = function(url) {
                                                        window.location.href = url;
                                                    };
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Silme Modalı -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1"
    aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    Kategoriyi Sil</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bu kategoriye ait tüm yazılarınız etkilenecektir. Devam etmek
                    istiyor musunuz?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">İptal</button>
                <!-- Onaylama butonu -->
                <a href="" class="btn btn-danger sil-onay">Evet,
                    Sil</a>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

<script>
    $('.sil-btn').on("click", function() {
        var id = $(this).attr("data-id");

        $(".sil-onay").attr('href', "/panel/categories/delete/" + id);
        
    });
</script>


</x-app-layout>
