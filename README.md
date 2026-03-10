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
   Copie o arquivo de exemplo e ajuste as variáveis se necessário:
   ```bash
   cp .env.example .env
   ```

3. **Suba os containers:**
   ```bash
   docker-compose up -d
   ```

4. **Acesse a aplicação:**
   - Portal Público: [http://localhost:8001](http://localhost:8001)
   - Portal Administrativo: [http://localhost:8001/login](http://localhost:8001/login)

### 🔐 Credenciais Padrão (Ambiente de Teste)
- **Usuário:** `admin`
- **Senha:** `admin`

---

## 👨‍💻 Créditos e Mantenedores

- **Desenvolvedor Original:** Silas Antônio Cereda da Silva
- **Instituição:** CGTI IFMG Campus Bambuí
- **Modificado por:** Antigravity AI (Google Deepmind)

---
© 2026 VOX - Sistema de Ouvidoria Digital
