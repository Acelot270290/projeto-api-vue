# 📊 Projeto KPIs Dashboard - Fullstack (Laravel + Vue + Docker)

Este é um sistema completo com autenticação JWT, dashboard de KPIs, frontend em Vue.js e backend em Laravel 10, tudo rodando com Docker.

---

## 🚀 Requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Git

> 💡 **Não é necessário instalar PHP, Node, Composer ou MySQL localmente.**

---

## 📁 Estrutura do Projeto

```
.
├── backend/          # Laravel API
├── frontend/         # Vue 3 (Vite)
├── docker-compose.yml
└── README.md
```

---

## 🐳 Rodando com Docker

### 1. Clone o projeto

```bash
git clone https://github.com/seuusuario/seuprojeto.git
cd seuprojeto
```

### 2. Copie o `.env` do Laravel

```bash
cp backend/.env.example backend/.env
```

### 3. Suba os containers

```bash
docker-compose up -d --build
```

Isso irá:

- Subir o banco MySQL
- Rodar o Laravel na porta 8000
- Rodar o frontend Vue na porta 5173

---

## 🛠️ Setup Backend Laravel

### 4. Acesse o container do Laravel

```bash
docker exec -it laravel-api bash
```

### 5. Instale as dependências

```bash
composer install
```

### 6. Geração da chave e seed do banco

```bash
php artisan key:generate
php artisan migrate:fresh --seed
```

Isso irá criar as tabelas e popular com:

- Usuário admin
- KPIs fake (via factory)

---

## 🔐 Login Padrão

```bash
Email: admin@admin.com
Senha: password
```

---

## 🖼️ Frontend Vue

O frontend já está disponível em:

```
http://localhost:5173
```

Ele consome a API backend em `http://localhost:8000`.

---

## 🔁 Endpoints da API

| Rota               | Método | Autenticado | Descrição                     |
|--------------------|--------|-------------|-------------------------------|
| `/api/login`       | POST   | ❌          | Login com email/senha         |
| `/api/kpis`        | GET    | ✅          | Lista os KPIs com variação    |

---

## ✅ Funcionalidades

- Autenticação JWT
- Dashboard de KPIs com:
  - Cards de indicadores
  - Variação percentual
  - Gráfico com vue-chartjs
  - Atualização automática a cada 30s
- Interface responsiva (menu hamburguer no mobile)
- Integração total via Docker

---

## 🧹 Parar os containers

```bash
docker-compose down
```

---

## 👨‍💻 Autor

Desenvolvido por **Alan Diniz** — Fullstack Laravel + Vue.js