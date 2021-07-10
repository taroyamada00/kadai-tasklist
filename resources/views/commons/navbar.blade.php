<header class="mb-4">
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                {{-- トップページへのリンク --}}
                <a class="navbar-brand" href="/">タスク管理アプリケーション</a>

                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="nav-bar">
                    <ul class="navbar-nav mr-auto"></ul>
                    <ul class="navbar-nav">
                        @if (Auth::check())
                            {{-- ユーザ名表示 --}}
                            <li class="nav-link">{{ Auth::user()->name }}</li>
                            {{-- ログアウトへのリンク --}}
                            <li class="nav-item nav-link">{!! link_to_route('logout.get', 'Logout') !!}</li>
                    </ul>
                        @else
                        {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get', 'Sign up', [], ['class' => 'nav-link']) !!}
                        {{-- ログインページへのリンク --}}
                <li class="nav-item">{!! link_to_route('login', 'Login', [], ['class' => 'nav-link']) !!}</li>
                    @endif
                </div>
            </nav>
</header>