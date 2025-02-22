    @extends('app')

    @section('content')
        <style>
            .container {
                width: 600px;
                margin: auto;
                background: #fff;
                border-radius: 8px;
                padding: 10px;
            }
            .tabs {
                display: flex;
                border-bottom: 2px solid #ccc;
            }
            .tab {
                flex: 1;
                text-align: center;
                padding: 10px;
                cursor: pointer;
                font-weight: bold;
            }
            .tab.active {
                border-bottom: 2px solid #1DA1F2;
                color: #1DA1F2;
            }
            .art {
                border-bottom: 1px solid #ccc;
                padding: 15px;
            }
            .art-header {
                display: flex;
                justify-content: space-between;
                font-size: 14px;
            }
            .art-image img {
                width: 100%;
                border-radius: 8px;
            }
            .art-caption {
                margin-top: 10px;
                font-size: 14px;
            }
            .buttons {
                display: flex;
                justify-content: space-between;
                margin-top: 10px;
            }
            .delete-btn {
                color: red;
                cursor: pointer;
            }
        </style>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <div class="container">
            <a href="{{ route('logout') }}" style="float: right;">Logout</a>
            <h1 style="color: #1DA1F2;">Feed de Artes</h1>

            <form action="{{ route('arts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="image">Imagem:</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div>
                    <label for="caption">Legenda:</label>
                    <textarea name="caption" rows="3" required></textarea>
                </div>
                <button type="submit">Publicar Arte</button>
            </form>

            <div class="tabs">
                <div class="tab active" onclick="switchTab('all')" id="tab-all">Todos os Posts</div>
                <div class="tab" onclick="switchTab('mine')" id="tab-mine">Meus Posts</div>
            </div>

            <div id="feed-all" class="feed">
                @forelse ($arts as $art)
                    <div class="art">
                        <div class="art-header">
                            <strong>{{ $art['username'] ?? 'Desconhecido' }}</strong>
                            <span>{{ date('d/m/Y H:i', strtotime($art['created_at'])) }}</span>
                        </div>
                        <div class="art-image">
                            <img src="{{ $art['image'] }}" alt="Arte de {{ $art['username'] ?? 'Desconhecido' }}"
                                onerror="this.onerror=null;this.src='/images/default-art.png';">
                        </div>
                        <div class="art-caption">
                            <p>{{ $art['caption'] }}</p>
                        </div>
                    </div>
                @empty
                    <p>Nenhuma arte foi publicada ainda.</p>
                @endforelse
            </div>

            <div id="feed-mine" class="feed" style="display: none;">
                @forelse ($myArts as $art)
                    <div class="art">
                        <div class="art-header">
                            <strong>Você</strong>
                            <span>{{ date('d/m/Y H:i', strtotime($art['created_at'])) }}</span>
                        </div>
                        <div class="art-image">
                            <img src="{{ $art['image'] }}" alt="Sua Arte"
                                onerror="this.onerror=null;this.src='/images/default-art.png';">
                        </div>
                        <div class="art-caption">
                            <p>{{ $art['caption'] }}</p>
                        </div>
                        <div class="buttons">
                            <a href="{{ route('arts.update', $art['id']) }}">Editar</a>
                            <form action="{{ route('arts.destroy', $art['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')a
                                <button type="submit" class="delete-btn">Deletar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>Você ainda não publicou nenhuma arte.</p>
                @endforelse
            </div>
        </div>

        <script>
            function switchTab(tab) {
                document.getElementById('feed-all').style.display = tab === 'all' ? 'block' : 'none';
                document.getElementById('feed-mine').style.display = tab === 'mine' ? 'block' : 'none';
                document.getElementById('tab-all').classList.toggle('active', tab === 'all');
                document.getElementById('tab-mine').classList.toggle('active', tab === 'mine');
            }
        </script>
    @endsection