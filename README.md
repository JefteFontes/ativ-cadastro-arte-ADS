# Projeto de Cadastro de Artes

Este projeto é uma aplicação web para cadastro, visualização, edição e exclusão de artes. Ele foi desenvolvido utilizando Django para o backend (API REST) e Laravel para o frontend. O sistema permite que usuários se cadastrem, façam login, publiquem artes, visualizem artes de outros usuários e gerenciem suas próprias artes.

## Funcionalidades

### Backend (Django)

- **Autenticação de usuários**: Utiliza JWT (JSON Web Tokens) para autenticação segura.
- **Cadastro de artes**: Permite o cadastro de novas artes com imagem e legenda.
- **Listagem de artes**: Retorna todas as artes cadastradas ou apenas as artes do usuário autenticado.
- **Edição e exclusão de artes**: Permite que o usuário edite ou exclua suas próprias artes.

### Frontend (Laravel)

- **Cadastro e login de usuários**: Interface para cadastro e autenticação de usuários.
- **Feed de artes**: Exibe todas as artes cadastradas no sistema.
- **Gerenciamento de artes**: Permite que o usuário visualize, edite e exclua suas próprias artes.

## Tecnologias Utilizadas

### Backend

- **Django**: Framework Python para desenvolvimento web.
- **Django REST Framework**: Para criação da API REST.
- **SQLite**: Banco de dados para armazenamento das informações.
- **Simple JWT**: Para autenticação via JWT.

### Frontend

- **Laravel**: Framework PHP para desenvolvimento web.
- **Bootstrap**: Para estilização das páginas.
- **HTTP Client**: Para consumo da API Django.

## Estrutura do Projeto

### Backend (Django)

#### URLs:

```python
urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/login/', CustomTokenObtainPairView.as_view(), name='token_obtain_pair'),
    path('api/token/refresh/', TokenRefreshView.as_view(), name='token_refresh'),
    path('api/register/', RegisterView.as_view(), name='register'),
    path('api/art/', ArtListCreateView, name='art-list-create'),
    path('api/art/<int:art_id>/', ArtDetailView, name='art-detail'),
]
```

### Frontend (Laravel)

#### Controllers:

- **AuthController**: Gerencia autenticação e registro de usuários.
- **ArtController**: Gerencia as operações relacionadas às artes.

#### Rotas:

```php
Route::get('/', [AuthController::class, 'ShowLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/feed', [ArtController::class, 'index'])->name('arts.index');
Route::post('/art/store', [ArtController::class, 'store'])->name('arts.store');
Route::put('/art/{id}', [ArtController::class, 'update'])->name('arts.update');
Route::delete('/art/{id}', [ArtController::class, 'destroy'])->name('arts.destroy');
```

## Testando a API com Insomnia

O backend do projeto já está hospedado e disponível para testes no PythonAnywhere. Você pode testar a API usando o Insomnia ou qualquer outra ferramenta de teste de APIs. Abaixo estão os endpoints disponíveis:

### Endpoints da API

#### Registro de Usuário:

- **Método:** POST
- **URL:** [https://jeftefontes.pythonanywhere.com/api/register/](https://jeftefontes.pythonanywhere.com/api/register/)
- **Corpo da Requisição:**

```json
{
  "username": "nome_de_usuario",
  "email": "email@example.com",
  "password": "senha_segura"
}
```

#### Login de Usuário:

- **Método:** POST
- **URL:** [https://jeftefontes.pythonanywhere.com/api/login/](https://jeftefontes.pythonanywhere.com/api/login/)
- **Corpo da Requisição:**

```json
{
  "username": "nome_de_usuario",
  "password": "senha_segura"
}
```

- **Resposta:**

```json
{
  "refresh": "token_de_refresh",
  "access": "token_de_acesso"
}
```

#### Listar Todas as Artes:

- **Método:** GET
- **URL:** [https://jeftefontes.pythonanywhere.com/api/art/](https://jeftefontes.pythonanywhere.com/api/art/)
- **Headers:**

```json
{
  "Authorization": "Bearer token_de_acesso"
}
```

#### Listar Artes do Usuário:

- **Método:** GET
- **URL:** [https://jeftefontes.pythonanywhere.com/api/art/?my\_arts=true](https://jeftefontes.pythonanywhere.com/api/art/?my_arts=true)
- **Headers:**

```json
{
  "Authorization": "Bearer token_de_acesso"
}
```

#### Cadastrar Nova Arte:

- **Método:** POST
- **URL:** [https://jeftefontes.pythonanywhere.com/api/art/](https://jeftefontes.pythonanywhere.com/api/art/)
- **Headers:**

```json
{
  "Authorization": "Bearer token_de_acesso"
}
```

- **Corpo da Requisição (multipart/form-data):**
  - **image:** Arquivo de imagem (JPEG, PNG, JPG, GIF).
  - **caption:** Legenda da arte (string).

#### Editar Arte:

- **Método:** PUT
- **URL:** [https://jeftefontes.pythonanywhere.com/api/art/](https://jeftefontes.pythonanywhere.com/api/art/)[int\:art\_id](int\:art_id)/
- **Headers:**

```json
{
  "Authorization": "Bearer token_de_acesso"
}
```

- **Corpo da Requisição:**

```json
{
  "caption": "Nova legenda"
}
```

#### Excluir Arte:

- **Método:** DELETE
- **URL:** [https://jeftefontes.pythonanywhere.com/api/art/](https://jeftefontes.pythonanywhere.com/api/art/)[int\:art\_id](int\:art_id)/
- **Headers:**

```json
{
  "Authorization": "Bearer token_de_acesso"
}
```

## Rodando o projeto Laravel

1. **Clone o repositório:**

```sh
git clone https://github.com/seuusuario/seurepositorio.git
cd seurepositorio
```

2. **Instale as dependências:**

```sh
composer install
```

3. **Crie o arquivo de ambiente:**

```sh
cp .env.example .env
```

5. **Inicie o servidor:**

```sh
php artisan serve
```

Agora, o frontend Laravel estará disponível para acesso no navegador.

## Requisitos
- PHP: Versão 8.4.3
- Composer: Versão 2.8.5

