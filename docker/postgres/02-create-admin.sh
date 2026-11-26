#!/bin/sh
# Cria o administrador inicial a partir do ambiente.
# Roda só na primeira inicialização do volume (docker-entrypoint-initdb.d).
# Precisa permanecer executável: o entrypoint oficial só isola o script
# em um subprocesso quando o bit de execução está ligado.

set -eu

ADMIN_LOGIN="${ADMIN_LOGIN:-admin}"
ADMIN_NAME="${ADMIN_NAME:-Administrador}"

if [ -z "$ADMIN_LOGIN" ] || [ "${#ADMIN_LOGIN}" -gt 50 ]; then
    echo "VOX: ADMIN_LOGIN deve ter de 1 a 50 caracteres." >&2
    exit 1
fi

if [ "${#ADMIN_NAME}" -gt 200 ]; then
    echo "VOX: ADMIN_NAME deve ter no máximo 200 caracteres." >&2
    exit 1
fi

export ADMIN_LOGIN ADMIN_NAME

already=$(psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" -tA <<'SQL'
\getenv admin_login ADMIN_LOGIN
SELECT CASE WHEN EXISTS (
    SELECT 1 FROM usuario WHERE login = :'admin_login'
) THEN 'yes' ELSE 'no' END;
SQL
)
already=$(printf '%s' "$already" | tr -d '[:space:]')

if [ "$already" = "yes" ]; then
    echo "VOX: administrador inicial já existe; a senha não foi alterada."
    exit 0
fi

generated=0
if [ -z "${ADMIN_PASSWORD:-}" ]; then
    ADMIN_PASSWORD=$(dd if=/dev/urandom bs=32 count=1 2>/dev/null | od -An -tx1 | tr -d ' \n' | cut -c1-24)
    generated=1
fi

sanitized=$(printf '%s' "$ADMIN_PASSWORD" | tr -d '[:cntrl:]')
if [ "$ADMIN_PASSWORD" != "$sanitized" ]; then
    echo "VOX: ADMIN_PASSWORD não pode conter caracteres de controle." >&2
    exit 1
fi

if [ "$generated" -eq 0 ] && [ "${#ADMIN_PASSWORD}" -lt 12 ]; then
    echo "VOX: ADMIN_PASSWORD precisa ter pelo menos 12 caracteres." >&2
    exit 1
fi

password_bytes=$(printf '%s' "$ADMIN_PASSWORD" | wc -c | tr -d ' ')
if [ "$password_bytes" -gt 72 ]; then
    echo "VOX: ADMIN_PASSWORD deve ter no máximo 72 bytes (limite do bcrypt)." >&2
    exit 1
fi

if [ "$generated" -eq 1 ] && [ "${#ADMIN_PASSWORD}" -lt 24 ]; then
    echo "VOX: falha ao gerar a senha inicial do administrador." >&2
    exit 1
fi

export ADMIN_PASSWORD

secret_file="/var/lib/postgresql/data/.vox-initial-admin-password"
if [ "$generated" -eq 1 ]; then
    umask 077
    mkdir -p "$(dirname "$secret_file")"
    printf 'login=%s\npassword=%s\n' "$ADMIN_LOGIN" "$ADMIN_PASSWORD" > "$secret_file"
    chmod 600 "$secret_file"
fi

if ! psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<'SQL'
CREATE EXTENSION IF NOT EXISTS pgcrypto;
\getenv admin_login ADMIN_LOGIN
\getenv admin_name ADMIN_NAME
\getenv admin_password ADMIN_PASSWORD
INSERT INTO usuario (login, senha, nome)
SELECT :'admin_login', crypt(:'admin_password', gen_salt('bf', 10)), :'admin_name'
WHERE NOT EXISTS (
    SELECT 1 FROM usuario WHERE login = :'admin_login'
);
SQL
then
    if [ "$generated" -eq 1 ]; then
        rm -f "$secret_file"
    fi
    exit 1
fi

if [ "$generated" -eq 1 ]; then
    cat <<EOF
============================================================
VOX: senha inicial do administrador foi gerada.
Login: ${ADMIN_LOGIN}
A senha ficou apenas em ${secret_file}
Leia uma vez com:
  docker exec vox-postgres cat ${secret_file}
Troque a senha no primeiro acesso e apague esse arquivo.
============================================================
EOF
else
    echo "VOX: administrador inicial configurado a partir de ADMIN_PASSWORD."
fi
