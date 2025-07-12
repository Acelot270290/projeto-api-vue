FROM node:20

# Criar diretório de trabalho
WORKDIR /app

# Copiar tudo
COPY . .

# Instalar dependências
RUN npm install

# Rodar o servidor Vite
CMD ["npm", "run", "dev", "--", "--host"]
