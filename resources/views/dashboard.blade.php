<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </x-slot>

    <div class="py-12">
        <div class="d-flex justify-content-center align-items-center"
            style="background-color: #415a77 !important; margin-top:3rem;">
            <div class="card-body bg-light" style="margin: 1rem; border-radius: 1rem;">

                <table class="table" style="color:black">
                    <tr>
                        <td>Blog Sayısı:</td>
                        <td>{{ $blog }}</td>
                    </tr>
                    <tr>
                        <td>Haber Sayısı:</td>
                        <td>{{ $news }}</td>
                    </tr>
                    <tr>
                        <td>Ürün Sayısı:</td>
                        <td>{{ $urunler }}</td>
                    </tr>
                    <tr>
                        <td>Proje Sayısı:</td>
                        <td>{{ $projeler }}</td>
                    </tr>
                    <tr>
                        <td>Referans Sayısı:</td>
                        <td>{{ $referanslar }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

