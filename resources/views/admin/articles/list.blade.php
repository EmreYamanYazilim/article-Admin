@extends("layouts.admin")

@section("title")
@endsection

@section("css")
    <link rel="stylesheet" href="{{ asset("assets/plugins/flatpickr/flatpickr.min.css") }}">
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
                        <select class="form-select" name="category_id" aria-label="Parent Kategory Seçin ">
                            <option value="{{ null }}">kategori seçin</option>
                            @foreach($categories as $parent)
                                <option
                                    value="{{ $parent->id }}" {{ request()->get("parent_id") == $parent->id ? "selected" : "" }}>{{ $parent->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="user_id" aria-label="Kullanici seçin ">
                            <option value="{{ null }}">Kullanıcı</option>
                            @foreach($users as $user)
                                <option
                                    value="{{ $user->id }}" {{ request()->get("user_id") == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Status seçin">
                            <option value="{{ null }}">Status</option>
                            <option value="0" {{ request()->get("status") === "0" ? "selected" : "" }}>Pasif</option>
                            <!-- === tirli yaptıktan sonra rakkamlarıda tırnak içine alıyorum yoksa  boş sıfır değerin vericeğinden dolayı null atmıyor status gözükmüyor  -->
                            <option value="1" {{ request()->get("status") === "1" ? "selected" : "" }}>Aktif</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">

                        <input class="form-control flatpickr2  m-b-sm"
                               id="publish_date"
                               name="publish_date"
                               type="text"
                               value="{{ request()->get("publish_date")  }}"
                               placeholder="Ne Zaman Yayınlansın ?">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="title, slug, body, tags" name="search_text"
                               value="{{ request()->get("title") }}">
                    </div>
                    <div class="col-9 my-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="min_view_count"
                                               placeholder="min view count"
                                               value="{{ request()->get("min_view_count") }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="max_view_count"
                                               placeholder="max view count"
                                               value="{{ request()->get("max_view_count") }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="min_like_count"
                                               placeholder="min like count"
                                               value="{{ request()->get("min_like_count") }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="max_like_count"
                                               placeholder="max like count"
                                               value="{{ request()->get("max_like_count") }}">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <th scope="col">image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Body</th>
                    <th scope="col">Tags</th>
                    <th scope="col">View Count</th>
                    <th scope="col">like_count</th>
                    <th scope="col">Publish Date</th>

                    <th scope="col">Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>
                <x-slot:rows>
                    @foreach($list as $article)
                        <tr>
                            <td>
                                @if(!empty($article->image))
                                    <img src="{{ asset($article->image) ?? "" }} " alt="" class="img-fluid"
                                         height="100">
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>
                                @if($article->status)
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btnChangeStatus" data-id="{{ $article->id }}">Aktif</a>
                                @else()
                                    <a href="javascript:void(0)" class="btn btn-warning btn-sm btnChangeStatus" data-id="{{ $article->id }}">Pasif</a>
                                @endif
                            </td>
                            <td><span data-bs-container="body"
                                      data-bs-toggle="tooltip"
                                      data-bs-placement="top"
                                      data-bs-title="{{ substr($article->body,0,200) }}"
                                >{{ substr($article->body, 0,20) }}</span>
                            </td>
                            <td>{{ $article->tags }}</td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->like_count }}</td>
                            <td>{{ $article->publish_date }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <a href="{{ route("article.edit",["id" => $article->id]) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="material-icons ms-0">edit</i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                   data-name="{{ $article->name }}"
                                   data-id="{{ $article->id }}">
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
    <script src="{{ asset("assets/plugins/flatpickr/flatpickr.js") }}"></script>
    <script src="{{ asset("assets/js/pages/datepickers.js") }}"></script>
    <script src="{{ asset("assets/admin/plugins/bootstrap/js/popper.min.js") }}"></script>
    <script src="{{ asset("assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

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
                        $("#statusChangeForm").attr('action', '{{ route('category.delete') }}');
                        $("#statusChangeForm").submit();
                    }
                });
            });

            // edit işlemleri


        });

        const popover = new bootstrap.Popover('.example-popover', {
            container: 'body'
        })

    </script>
    <script>
        $("#publish_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>

@endsection
