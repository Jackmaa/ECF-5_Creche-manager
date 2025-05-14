FROM node:18

WORKDIR /app

#ENV NODE_ENV=development

COPY package*.json ./
RUN npm install --legacy-peer-deps

COPY . .

EXPOSE 5173
CMD ["npx", "vite"]
