@extends('app')

@section('content')
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <a href="{{ route('logout') }}">Logout</a>
    <h1>Feed de Artes</h1>

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

    <div class="feed">
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
            <p>Nenhuma arte foi publicada ainda. Seja o primeiro a compartilhar!</p>
        @endforelse
    </div>

    <style>
        .feed {
            width: 600px;
            margin: auto;
        }
        .art {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
        }
        .art-header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .art-image img {
            width: 100%;
            border-radius: 8px;
        }
        .art-caption {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
@endsection