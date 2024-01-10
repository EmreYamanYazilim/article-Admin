@extends("layouts.admin")

@section("title")
@endsection

@section("css")
    <style>
        .table-hover > tbody > tr:hover {
            --bs-table-hover-bg: transparent;
            background: #2269f5;
            color: #ffffff;
        }
    </style>

@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2>Kategori Listesi</h2>
        </x-slot:header>
        <x-slot:body>
            <form action="">
                <div class="row">
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="name" name="name" value="{{ request()->get("name") }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Slug" name="slug" value="{{ request()->get("slug") }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Description" name="description" value="{{ request()->get("description") }}">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="order" name="order" value="{{ request()->get("order") }}">
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="parent_id" aria-label="Parent Kategory Seçin ">
                            <option value="{{ null }}">kategori seçin</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ request()->get("parent_id") == $parent->id ? "selected" : "" }}>{{ $parent->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="user_id" aria-label="Kullanici seçin ">
                            <option value="{{ null }}">Kullanıcı</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request()->get("user_id") == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Status seçin">
                            <option value="{{ null }}">Status</option>
                            <option value="0" {{ request()->get("status") === "0" ? "selected" : "" }}>Pasif</option> <!-- === tirli yaptıktan sonra rakkamlarıda tırnak içine alıyorum yoksa  boş sıfır değerin vericeğinden dolayı null atmıyor status gözükmüyor  -->
                            <option value="1" {{ request()->get("status") === "1" ? "selected" : "" }}>Aktif</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="feature_status" aria-label="feature seçin">
                            <option value="{{ null }}">Feature</option>
                            <option value="0" {{ request()->get("feature_status") === "0" ? "selected" : "" }}>Pasif</option>
                            <option value="1" {{ request()->get("feature_status") === "1" ? "selected" : "" }}>Aktif</option>
                        </select>
                    </div>
                    <hr>
                    <div class="col-12  mb-2 d-flex mb-2">
                    <button type="submit" class="btn btn-primary w-50">Filitrele</button>
                    <button type="submit" class="btn btn-warning w-50"> Temizle</button>
                    </div>
                    <hr>
                </div>


            </form>

            <x-bootstrap.table
                :class="'table-striped table-hover'"
                :is-responsive="1">
                <x-slot:columns>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feature status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order</th>
                    <th scope="col">Parent category</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>
                <x-slot:rows>
                    @foreach($list as $category)
                        <tr>
                            <td scope="row">{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-warning btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                @if($category->feature_status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeFeatureStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-warning btn-sm btnChangeFeatureStatus">Pasif</a>
                                @endif
                            </td>
                            <td>{{ substr($category->description, 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parentCategory?->name }}</td> <!-- parent category varsa bas yoksa basma baskernen name'i göster  -->
                            <td>{{ $category->user->name }}</td><!-- kategorinin useri varsa onun name'sini bassin Hasone ile bağladım -->
                            <td>
                                <a href="{{ route("category.edit", ["id" => $category->id]) }}" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                   data-name="{{ $category->name }}"
                                   data-id="{{ $category->id }}">
                                    <i class="material-icons ms-0">delete</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
                </x-bootstrap.table:>
{{--            {{ $list->links("pagination::bootstrap-5") }}--}}
            {{ $list->appends(request()->all())->links("pagination::bootstrap-5") }} <!-- sayfa  atladığında bozulma hatası gidermek için -->


        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section("js")
    <script>


// status bölümü
        $(document).ready(function () {
            $('.btnChangeStatus').click(function () {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);


                Swal.fire({
                    title: "Status değiştirmek istediğinize emin misiniz ?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Evet",
                    denyButtonText: `Hayır`,
                    cancelButtonText: "iptal",

                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action", "{{ route('categories.changeStatus') }}");
                        $('#statusChangeForm').submit();

                    } else if (result.isDenied) {
                        Swal.fire("Herhangi bir işlem yapılmadı ", "", "info");
                    }
                });
            });

            // FetureStatus bölümü      başka sweetalert koydum
            $('.btnChangeFeatureStatus').click(function () {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: "Bilgi !",
                    text: "Feature Statusu değşitirmek istediğinden emin misin ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "evet!",
                    cancelButtonText: "İptal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#statusChangeForm").attr("action", "{{ route("categories.feature.changeStatus") }}");
                        $("#statusChangeForm").submit();

                    }
                });
            });

            // delete işlemi
            $('.btnDelete').click(function () {
                let categoryID = $(this).data('id');
                let categoryName = $(this).data('name');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: categoryName + " -> Silmek istediğinizden Emin misiniz ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Evet"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#statusChangeForm").attr('action','{{ route('category.delete') }}');
                        $("#statusChangeForm").submit();
                    }
                });
            });

            // edit işlemleri


        });

    </script>

@endsection
