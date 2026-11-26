# VOX - Sistema de Ouvidoria Digital

![VOX Logo](src/public/assets/images/original_logo.png)

O **VOX** é um sistema moderno de gestão de ouvidoria, desenvolvido originalmente para o **IFMG Campus Bambuí**. O sistema permite registrar, acompanhar e gerenciar manifestações como reclamações, sugestões, elogios e denúncias de forma eficiente e transparente.

## ✨ Principais Funcionalidades

- **Portal Público:** Interface intuitiva para cidadãos realizarem e consultarem manifestações.
- **Painel Administrativo Pro:** Dashboard com estatísticas em tempo real e barra lateral de navegação rápida.
- **Timeline de Andamento:** Visualização clara do fluxo de tratamento de cada manifestação.
- **Gestão Auxiliar:** Controle completo de Setores, Categorias, Segmentos (Clientela) e Equipe.
- **Arquitetura Moderna:** Padrão MVC (Model-View-Controller) com PHP 8.2+ e Clean Code.
- **Segurança:** Proteção contra CSRF, XSS e Session Fixation integrada ao núcleo.

## 🚀 Tecnologias Utilizadas

- **Core:** PHP 8.2+ (Vanilla MVC)
- **Banco de Dados:** PostgreSQL 16
- **Frontend:** Vanilla JS + CSS3 (Glassmorphism & High End Design)
- **Infraestrutura:** Docker & Docker Compose
- **Servidor Web:** Nginx

## 🛠️ Como Executar

### Pré-requisitos
- Docker e Docker Compose instalados.

### Passo a Passo

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/silloty/vox.git
   cd vox
   ```

2. **Configure o ambiente:**
   ```bash
   cp .env.example .env
   ```
   Edite o `.env` antes de subir os containers. Não há senha padrão versionada.
   - `DB_PASS`: senha do PostgreSQL. O Compose recusa iniciar se ela estiver vazia.
   - `ADMIN_PASSWORD`: senha inicial do administrador (12 a 72 bytes). Se ficar vazia, a primeira criação do banco gera uma senha aleatória e a grava somente dentro do volume, em `/var/lib/postgresql/data/.vox-initial-admin-password`.
   - `ADMIN_LOGIN`: login inicial (o exemplo usa `admin`). É um identificador, não uma senha.

3. **Suba os containers:**
   ```bash
   docker compose up -d
   ```
   O comando legado `docker-compose up -d` também lê o mesmo arquivo. O script de administrador roda apenas quando o volume do Postgres é criado. Um volume que já existe mantém a senha do banco e os usuários atuais. Para recomeçar do zero (apaga os dados locais): `docker compose down -v`.

4. **Acesse a aplicação:**
   - Portal Público: [http://localhost:8001](http://localhost:8001)
   - Portal Administrativo: [http://localhost:8001/login](http://localhost:8001/login)

5. **Entre e troque a senha inicial.** Se `ADMIN_PASSWORD` ficou vazia, leia a senha gerada uma vez e apague o arquivo:
   ```bash
   docker exec vox-postgres cat /var/lib/postgresql/data/.vox-initial-admin-password
   docker exec vox-postgres rm -f /var/lib/postgresql/data/.vox-initial-admin-password
   ```
   No painel, abra **Usuários** e defina uma senha nova. Não reutilize a senha inicial, principalmente fora da máquina de desenvolvimento.

---

## � Registro INPI
O sistema VOX possui registro de programa de computador junto ao **Instituto Nacional da Propriedade Industrial (INPI)**:

- **Nº do Pedido:** BR 51 2013 000695 3
- **Data do Depósito:** 08/07/2013
- **Título:** VOX - SISTEMA DE OUVIDORIA
- **Titulares:** FAPEMIG / Instituto Federal de Educação, Ciência e Tecnologia de Minas Gerais (IFMG)
- **Autores:** Silas Antônio Cereda da Silva, Ciniro Aparecido Leite Nametala, Wanderson Santiago dos Reis.

---

## �👨‍💻 Créditos e Mantenedores

- **Desenvolvedor Original & Autor Principal:** Silas Antônio Cereda da Silva
- **Autores Co-desenvolvedores:** Ciniro Aparecido Leite Nametala, Wanderson Santiago dos Reis
- **Instituição:** CGTI IFMG Campus Bambuí
- **Refatorado em 2026:** Silas A C Silva e Antigravity AI (Google Deepmind)

---
© 2026 VOX - Sistema de Ouvidoria Digital
