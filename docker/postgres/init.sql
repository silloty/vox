-- ============================================================
-- VOX - Sistema de Ouvidoria
-- Script de Inicialização do Banco de Dados
-- Baseado na estrutura original do sistema (INPI)
-- ============================================================

-- Tabela: status
CREATE TABLE IF NOT EXISTS status (
    status_id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- Tabela: clientela
CREATE TABLE IF NOT EXISTS clientela (
    clientela_id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL
);

-- Tabela: tipo
CREATE TABLE IF NOT EXISTS tipo (
    tipo_id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    visivel BOOLEAN DEFAULT TRUE
);

-- Tabela: departamento
CREATE TABLE IF NOT EXISTS departamento (
    departamento_id SERIAL PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    email VARCHAR(200),
    descricao TEXT
);

-- Tabela: usuario
CREATE TABLE IF NOT EXISTS usuario (
    usuario_id SERIAL PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(200) NOT NULL
);

-- Tabela: manifestacao (core)
CREATE TABLE IF NOT EXISTS manifestacao (
    manifestacao_id SERIAL PRIMARY KEY,
    forma_identificacao CHAR(1) NOT NULL DEFAULT 'A',
    nome VARCHAR(200),
    email VARCHAR(200),
    cpf VARCHAR(14),
    telefone VARCHAR(20),
    endereco TEXT,
    ref_tipo INTEGER REFERENCES tipo(tipo_id),
    assunto VARCHAR(300),
    conteudo TEXT NOT NULL,
    ref_clientela INTEGER REFERENCES clientela(clientela_id),
    registro VARCHAR(50) NOT NULL UNIQUE,
    anonimato BOOLEAN DEFAULT FALSE,
    data_criacao DATE DEFAULT CURRENT_DATE,
    data_finalizacao DATE,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ref_status INTEGER REFERENCES status(status_id) DEFAULT 2,
    resposta_final TEXT,
    feedback TEXT,
    visualizado BOOLEAN DEFAULT FALSE
);

-- Tabela: andamento
CREATE TABLE IF NOT EXISTS andamento (
    andamento_id SERIAL PRIMARY KEY,
    ref_manifestacao INTEGER NOT NULL REFERENCES manifestacao(manifestacao_id) ON DELETE CASCADE,
    ref_departamento INTEGER NOT NULL REFERENCES departamento(departamento_id),
    registro VARCHAR(50),
    data_envio DATE,
    hora_envio TIME,
    resposta TEXT,
    data_resposta DATE,
    hora_resposta TIME
);

-- View: vw_manifestacao (usada pelo sistema legado)
CREATE OR REPLACE VIEW vw_manifestacao AS
SELECT 
    m.manifestacao_id,
    m.forma_identificacao,
    m.nome,
    m.email,
    m.cpf,
    m.telefone,
    m.endereco,
    m.assunto,
    m.conteudo,
    m.registro,
    m.anonimato,
    m.data_criacao,
    m.data_finalizacao,
    m.data_hora,
    m.resposta_final,
    m.feedback,
    m.visualizado,
    c.clientela_id AS codigo_clientela,
    c.nome AS nome_clientela,
    s.status_id AS codigo_status,
    s.nome AS nome_status,
    t.tipo_id AS codigo_tipo,
    t.nome AS nome_tipo
FROM manifestacao m
LEFT JOIN clientela c ON m.ref_clientela = c.clientela_id
LEFT JOIN status s ON m.ref_status = s.status_id
LEFT JOIN tipo t ON m.ref_tipo = t.tipo_id;

-- View: vw_andamento
CREATE OR REPLACE VIEW vw_andamento AS
SELECT
    a.andamento_id,
    a.ref_manifestacao,
    a.registro,
    a.data_envio,
    a.hora_envio,
    a.resposta,
    a.data_resposta,
    a.hora_resposta,
    d.departamento_id,
    d.nome AS nome_departamento,
    d.email AS email_departamento,
    m.assunto AS assunto_manifestacao,
    m.registro AS registro_manifestacao
FROM andamento a
JOIN departamento d ON a.ref_departamento = d.departamento_id
JOIN manifestacao m ON a.ref_manifestacao = m.manifestacao_id;

-- Índices para performance
CREATE INDEX IF NOT EXISTS idx_manifestacao_registro ON manifestacao(registro);
CREATE INDEX IF NOT EXISTS idx_manifestacao_status ON manifestacao(ref_status);
CREATE INDEX IF NOT EXISTS idx_manifestacao_data ON manifestacao(data_criacao);
CREATE INDEX IF NOT EXISTS idx_andamento_manifestacao ON andamento(ref_manifestacao);
CREATE INDEX IF NOT EXISTS idx_andamento_registro ON andamento(registro);

-- ============================================================
-- DADOS INICIAIS
-- ============================================================

-- Status padrão do sistema
INSERT INTO status (nome, descricao) VALUES 
    ('Em Andamento', 'Manifestação em análise pelos departamentos'),
    ('Aberta', 'Manifestação recebida e aguardando encaminhamento'),
    ('Fechada', 'Manifestação finalizada pelo ouvidor');

-- Departamento "Ouvidoria" (ID=1 obrigatório pelo sistema original)
INSERT INTO departamento (nome, email, descricao) VALUES 
    ('Ouvidoria', '', 'Setor responsável pelo recebimento e gestão das manifestações');

-- Tipos padrão
INSERT INTO tipo (nome, visivel) VALUES 
    ('Reclamação', TRUE),
    ('Sugestão', TRUE),
    ('Elogio', TRUE),
    ('Denúncia', TRUE),
    ('Solicitação', TRUE);

-- Clientela padrão
INSERT INTO clientela (nome) VALUES 
    ('Aluno'),
    ('Servidor'),
    ('Comunidade Externa'),
    ('Fornecedor'),
    ('Outro');

-- Usuário administrador padrão (senha: admin123)
-- A senha será re-hashada na primeira execução do sistema
INSERT INTO usuario (login, senha, nome) VALUES 
    ('admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador');
