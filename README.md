# 📊 Projeto KPIs Dashboard - Fullstack (Laravel + Vue + Docker)

Este é um sistema completo com autenticação JWT, dashboard de KPIs, frontend em Vue.js e backend em Laravel 10, tudo rodando com Docker.

---

## 🚀 Requisitos

- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/)
- Make (opcional para comandos encurtados, Linux/Mac)
- Git

---

## 📁 Estrutura do Projeto

```
.
├── backend/          # Laravel API
├── frontend/         # Vue 3 (Vite)
├── docker-compose.yml
├── .env              # Copiar do .env.example
```

---

## 🐳 Instruções para rodar com Docker

1. **Clone o projeto**
```bash
git clone https://github.com/seuusuario/seuprojeto.git
cd seuprojeto
```

2. **Configure o `.env` do Laravel**

```bash
cp backend/.env.example backend/.env
```

3. **Suba os containers**
```bash
docker-compose up -d --build
```

---

## 🛠️ Setup Laravel (Backend)

1. **Acesse o container do app**
```bash
docker exec -it app bash
```

2. **Instale as dependências**
```bash
composer install
```

3. **Gere a chave da aplicação**
```bash
php artisan key:generate
```

4. **Migrate + Seed**
```bash
php artisan migrate:fresh --seed
```

> Isso vai rodar as `factories` e preencher a base com usuários e KPIs de exemplo.

---

## 🔐 Login

Use o usuário criado pelo seeder:

```bash
Email: admin@admin.com
Senha: password
```

---

## 🧪 Testar Autenticação JWT

No frontend, ao fazer login, o token será salvo no `localStorage` e usado nas requisições autenticadas para os KPIs.

---

## 🖼️ Frontend (Vue 3 com Vite)

1. **Instale as dependências**
```bash
cd frontend
npm install
```

2. **Inicie o projeto**
```bash
npm run dev
```

> Por padrão, o frontend roda em: http://localhost:5173

---

## 🔁 API Endpoints

| Rota               | Método | Autenticado | Descrição                     |
|--------------------|--------|-------------|-------------------------------|
| `/api/login`       | POST   | ❌          | Autentica e retorna JWT       |
| `/api/kpis`        | GET    | ✅          | Lista os KPIs com variação    |

---

## 🧪 Exemplo de Factory Seeder

```php
// database/seeders/DatabaseSeeder.php

public function run()
{
    \App\Models\User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('password'),
    ]);

    \App\Models\Kpi::factory(10)->create();
}
```

---

## 📦 Tecnologias Usadas

- Laravel 10
- Vue 3 (Vite)
- Bootstrap 5 + Bootstrap Icons
- Vue Router
- Chart.js (via vue-chartjs)
- JWT Auth
- Docker + PostgreSQL + PHP-FPM + Nginx

---

## ✅ Funcionalidades

- Login com JWT
- Proteção de rotas privadas
- Sidebar responsiva com menu hamburguer
- KPIs com variação e gráfico
- Refresh automático a cada 30s
- Mobile first

---

## 🧹 Encerrando containers

```bash
docker-compose down
```

---

## 👨‍💻 Autor

Desenvolvido por [Seu Nome] - Fullstack Laravel + Vue.js

---