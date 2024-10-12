# 📋 MNotas - Sistema de Gestão Financeira

![Badge](https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow) ![GitHub repo size](https://img.shields.io/github/repo-size/miqueiasbraga2001/mnotas-financas) ![GitHub contributors](https://img.shields.io/github/contributors/miqueiasbraga2001/mnotas-financas)

Um sistema simples e intuitivo para gerenciar suas finanças pessoais e empresariais. Controle transações, categorias e tenha uma visão clara de suas finanças.

---

## 🚀 Funcionalidades Principais
- ✅ **Cadastro de Transações**: Adicione e edite suas entradas e saídas.
- 📊 **Relatórios Dinâmicos**: Visualize gráficos e relatórios em tempo real sobre suas finanças.
- 🗂️ **Categorias Personalizáveis**: Crie e organize suas categorias de despesas e receitas.
- 🔒 **Segurança de Dados**: Proteção de dados com autenticação segura.

---

## 🛠️ Tecnologias Utilizadas
- **Back-end**: Laravel ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
- **Front-end**: Bootstrap ![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white), Livewire, Alpine.js ![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
- **Gráficos**: Chart.js ![Chart.js](https://img.shields.io/badge/Chart.js-F5788D?style=for-the-badge&logo=chart.js&logoColor=white)
- **Banco de Dados**: MySQL ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
- **Controle de Versão**: Git ![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white), GitLab ![GitLab](https://img.shields.io/badge/GitLab-FC6D26?style=for-the-badge&logo=gitlab&logoColor=white)

---

## 📷 Screenshots
| Página Principal      | Relatório Financeiro |
| --------------------- | -------------------- |
| ![Página Principal](https://via.placeholder.com/400) | ![Relatório](https://via.placeholder.com/400) |

---

## 📝 Pré-requisitos
Antes de rodar o projeto, certifique-se de ter instalado:
- **PHP 8.0+** ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
- **Composer** ![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
- **MySQL** ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## ⚙️ Instalação

Siga os passos abaixo para rodar o projeto localmente:

```bash
# Clone o repositório
git clone https://gitlab.com/miqueiasbraga2001/mnotas-financas.git

# Acesse a pasta do projeto
cd mnotas-financas

# Instale as dependências
composer install

# Crie o arquivo .env
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure o banco de dados no arquivo .env

# Execute as migrações
php artisan migrate

# Rode o servidor local
php artisan serve
