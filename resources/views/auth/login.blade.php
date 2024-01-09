@extends("layouts.auth")

@section("title")
    Kaydol !
@endsection

@section("css")
@endsection

@section("content")
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="index.html">Neptune</a>
            </div>
            <p class="auth-description">Lütfen giriş yapmak için üye olun !!<br> üyeliğiniz yok mu ? <a
                    href="sign-up.html">Tıklayın</a></p>

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <form action="{{ route("login") }}" method="POST">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control m-b-md" id="signInEmail"
                           aria-describedby="signInEmail" placeholder="example@neptune.com"
                           name="email"
                    value="{{ old("email") }}">

                    <label for="signInPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword"
                           placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"
                           name="password">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember"
                    {{ old("remember") ? "checked" : "" }}>
                    <label class="form-check-label" for="remember">
                        Beni Hatırla
                    </label>
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
                    <a href="#" class="auth-forgot-password float-end">Forgot password?</a>
                </div>
                <div class="divider"></div>
                <div class="auth-alts">
                    <a href="#" class="auth-alts-google"></a>
                    <a href="#" class="auth-alts-facebook"></a>
                    <a href="#" class="auth-alts-twitter"></a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("js")
@endsection
