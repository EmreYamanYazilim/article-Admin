@extends("layouts.admin")

@section("title")
    Makale {{ isset($article) ? "Güncelleme" : "Ekleme" }}
@endsection

@section("css")
    <link rel="stylesheet" href="{{ asset("assets/plugins/flatpickr/flatpickr.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/plugins/summernote/summernote-lite.min.css") }}">

{{--    <link href="{{ asset("assets/plugins/flatpickr/flatpickr.min.css") }}">--}}
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makale {{ isset($article) ? "Güncelleme" : "Ekleme" }}</h2>
            <hr>
        </x-slot:header>
        <x-slot:body>
            <div class="example-container">
                <div class="example-content">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <form action="{{ isset($article) ? route("article.edit",["id" => $article->id]) : route("article.create") }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="title" >Makale Başlığı</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered m-b-sm
                           @if($errors->has("name"))
                           border-danger
                           @endif
                           "
                               aria-describedby="solidBoderedInputExample"
                               placeholder="Makale Başlığı"
                               name="title"
                               value="{{ isset($article) ? $article->title : "" }}"
                               required
                        >
                        <label for="slug"  >Makale Slug</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered m-b-sm"
                               aria-describedby="solidBoderedInputExample"
                               placeholder="Makale Slug"
                               name="slug"
                               value="{{ isset($article) ? $article->slug : "" }}"
                        >
                        <label for="tags">Makale Etiketi</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered m-b-sm"
                               placeholder="Etiketler"
                               name="tags"
                               id="tags"
                               value="{{ isset($article) ? $article->tags : "" }}"
                        >
                        <div class="form-text m-b-sm"> Her bir etiketi  virgülle ayırarak yazın</div>

                        <label for="category_id"> Kategori Seçimi</label>
                        <select class="form-select form-control form-control-solid-bordered m-b-sm"
                                name="category_id" >
                            <option  value="{{ null }}">Kategori Seçimi</option>
                            @foreach($categories as $item)
                                <option  value="{{ $item->id }}" {{ isset($article) && $article->category_id == $item->id ? "selected" : "" }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <hr>
                        <label for="description">Makale İçeriği</label>

                        <textarea id="summernote" name="body" class="m-b-sm">{{ isset($article) ? $article->body : "" }}</textarea>

                        <textarea class="form-control form-control-solid-bordered m-b-sm"
                                  name="seo_description" id="seo_description"
                                  cols="30" rows="10"
                                  placeholder="Seo Description"
                                  style="resize:none"
                        >{{ isset($article) ? $article->seo_description : "" }}</textarea>
                        <textarea class="form-control form-control-solid-bordered m-b-sm "
                                  name="seo_keywords" id="seo_keywords"
                                  cols="30" rows="10"
                                  placeholder="Seo Keywords"
                                  style="resize:none"
                        >{{ isset($article) ? $article->seo_keywords : "" }}</textarea>

                        <input class="form-control flatpickr2  m-b-sm"
                               id="publish_date"
                               name="publish_date"
                               type="text"
                               value="{{ isset($article) ? $article->publish_date : ""  }}"
                               placeholder="Ne Zaman Yayınlansın ?">
                        <input type="file" name="image" id="image" class="form-control m-b-sm" accept="image/png, image/jpeg, image/jpg">
                        <div class="form-text m-b-sm">Makale Görseli</div>
                        @if(isset($article)&& $article->image)
                            <img src="{{ asset("$article->image") }}" alt="" class="img-fluid" style="max-height: 200px">
                        @endif

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ isset($aritcle) && $article->status ? "checked" : "" }}
                            <label class="form-check-label" for="status">
                                Makale Sitede Görünsün mü ?
                            </label>
                        </div>

                        <hr>
                        <div class="col-6 mx-auto mt-2">
                            <button type="submit" class="btn btn-success btn-rounded w-100">{{ isset($category) ? "Güncelle" : "Kaydet" }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section("js")
    <script src="{{ asset("assets/plugins/flatpickr/flatpickr.js") }}"></script>
    <script src="{{ asset("assets/plugins/summernote/summernote-lite.min.js") }}"></script>
    <script src="{{ asset("assets/js/pages/text-editor.js") }}"></script>
{{--    <script src="{{ asset("assets/js/pages/datepickers.js") }}"></script>--}}
    <script>
        $("#publish_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection
