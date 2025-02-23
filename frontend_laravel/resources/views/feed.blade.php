@extends('app')

@section('content')
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .container-feed {
            width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 10px;
        }

        .tabs {
            display: flex;
            width: 600px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            border-radius: 24px;
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 24px;
            transition: all 0.1s ease-in-out;
        }

        .tab.active {
            box-shadow: inset 0 0 4px rgba(29, 160, 242, 0.8);
            color: #1DA1F2;
            transition: all 0.1s ease-in-out;
        }

        .art {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
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

        .art-caption p {
            margin: 0;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .buttons a,
        .buttons button {
            cursor: pointer;
            background: none;
            border: none;
            font-size: 16px;
        }

        .buttons a {
            color: #1DA1F2;
        }

        .buttons button {
            color: red;
        }

        .alert {
            position: absolute;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 90%;
            max-width: 500px;
        }

        .top-header-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin: 10px auto;
            padding: 15px;
        }

        .top-header-logo img {
            width: 150px;
        }

        .logout-link {
            display: flex;
            align-items: end;
            text-decoration: none;
            width: 74px;
            font-weight: bold;
            font-size: 16px;
            margin-right: 80px;
        }

        .logout-link i {
            font-size: 20px;
            color: #1DA1F2;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .input-group,
        .form-floating {
            width: 100%;
        }

        .preview {
            width: 100%;
            height: 100px;
            object-fit: cover;
            display: none;
            margin-top: 10px;
            border-radius: 5px;
        }

        .button-container {
            text-align: right;
        }

        .button-container button {
            background-color: #1DA1F2;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #0d8de6;
        }

        /* Estilos para o modal */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            margin: auto;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .modal-body {
            padding: 15px;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer button {
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-footer .btn-confirm {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .modal-footer .btn-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        /* Estilos para edição de legenda */
        .edit-caption {
            display: none;
            width: 100%;
            margin-top: 10px;
        }

        .edit-caption textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .edit-caption button {
            margin-top: 10px;
            background-color: #1DA1F2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        textarea {
            resize: none;
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container">
        <div class="top-header-logo">
            <img src="{{ asset('images/logo-myarts.png') }}" alt="Logo MyArts">
            <div class="tabs">
                <div class="tab active" onclick="switchTab('all')" id="tab-all">Todas as Artes</div>
                <div class="tab" onclick="switchTab('mine')" id="tab-mine">Minhas Artes</div>
            </div>
            <a href="#" class="logout-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>

        <div class="container-feed">
            <div id="feed-all" class="feed">
                <form action="{{ route('arts.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
                    @csrf
                    <div class="input-group">
                        <input type="file" class="form-control" id="inputGroupFile04" accept="image/*" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" required>
                    </div>
                    <img id="preview" class="preview">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="caption" required cols="40" rows="10"></textarea>
                        <label for="floatingTextarea2">Legenda</label>
                    </div>
                    <div class="button-container">
                        <button type="submit">Publicar Arte</button>
                    </div>
                </form>
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
                    <div class="art" id="art-{{ $art['id'] }}">
                        <div class="art-header">
                            <strong>{{ $art['username'] ?? 'Desconhecido' }}</strong>
                            <span>{{ date('d/m/Y H:i', strtotime($art['created_at'])) }}</span>
                        </div>
                        <div class="art-image">
                            <img src="{{ $art['image'] }}" alt="Sua Arte"
                                onerror="this.onerror=null;this.src='/images/default-art.png';">
                        </div>
                        <div class="art-caption">
                            <p>{{ $art['caption'] }}</p>
                            <div class="edit-caption">
                                <form id="editForm-{{ $art['id'] }}" method="POST" action="{{ route('arts.update', $art['id']) }}">
                                    @csrf
                                    @method('PUT')
                                    <textarea class="form-control" name="caption">{{ $art['caption'] }}</textarea>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </form>
                            </div>
                        </div>
                        <div class="buttons">
                            <a href="#" onclick="toggleEditCaption({{ $art['id'] }})">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-art-id="{{ $art['id'] }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p>Você ainda não publicou nenhuma arte.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmar Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja sair?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-confirm">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja deletar esta arte?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-confirm">Deletar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.getElementById('feed-all').style.display = tab === 'all' ? 'block' : 'none';
            document.getElementById('feed-mine').style.display = tab === 'mine' ? 'block' : 'none';
            document.getElementById('tab-all').classList.toggle('active', tab === 'all');
            document.getElementById('tab-mine').classList.toggle('active', tab === 'mine');
        }

        document.getElementById("inputGroupFile04").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById("preview");
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });

        // Configura o modal de deletar
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const artId = button.getAttribute('data-art-id');
                const form = document.getElementById('deleteForm');
                form.action = `/art/${artId}`;
            });
        });

        // Função para alternar a edição da legenda
        function toggleEditCaption(artId) {
            const artElement = document.getElementById(`art-${artId}`);
            const captionElement = artElement.querySelector('.art-caption p');
            const editCaptionElement = artElement.querySelector('.edit-caption');

            if (captionElement.style.display === 'none') {
                captionElement.style.display = 'block';
                editCaptionElement.style.display = 'none';
            } else {
                captionElement.style.display = 'none';
                editCaptionElement.style.display = 'block';
            }
        }
    </script>
@endsection