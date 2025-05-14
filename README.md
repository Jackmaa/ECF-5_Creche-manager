# Crèche Manager App 🧒📋

Une application web pour gérer efficacement une crèche : enfants, présences, responsables légaux, et personnels.

## 🛠️ Tech Stack

![Symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony&logoColor=white)
![Vue 3](https://img.shields.io/badge/Vue-3.5.13-42b883?style=for-the-badge&logo=vue.js&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-6.3.5-646cff?style=for-the-badge&logo=vite&logoColor=white)
![Axios](https://img.shields.io/badge/Axios-5A29E4?style=for-the-badge&logo=axios&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![DaisyUI](https://img.shields.io/badge/DaisyUI-4.x-FF69B4?style=for-the-badge&logo=daisyui&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

## 🚀 Features

- 🧒 Gestion des enfants & profils détaillés
- 👩‍👧 Assignation de responsables légaux (parents, gardiens)
- 📆 Gestion des présences avec heure d’arrivée et de départ
- 🧑‍🏫 Gestion des rôles (admin, éducateurs)
- 📋 Dashboard responsive avec Vue 3 + DaisyUI
- 🔐 Authentification et sécurité via API JWT (à venir)

## 📦 Installation & Setup (Docker)

```sh
# Cloner le projet
git clone https://github.com/Jackmaa/creche-manager.git
cd creche-manager

# Lancer les services (backend, frontend, base de données)
docker-compose up -d --build
```

### ✏️ Commandes utiles

```sh
# Symfony CLI (exécution dans le conteneur backend)
docker-compose exec symfony php bin/console

# Installer un bundle
docker-compose exec symfony composer require nom-du-bundle

# Lancer le serveur de dev Vue (si mode dev manuel)
docker-compose exec vue npm run dev
```

## 📂 Structure du projet

```
📁 creche-manager
├── back/                  # Symfony backend
│   ├── src/Entity         # Entités Doctrine (Child, User, Presence...)
│   └── config/            # Configuration Doctrine & sécurité
├── front/                 # Frontend Vue 3
│   ├── src/components     # Composants Vue
│   ├── src/services       # Fichiers API (axios)
│   └── tailwind.config.js # Configuration Tailwind & DaisyUI
├── docker/                # Dockerfiles
├── docker-compose.yml     # Configuration multi-services
└── README.md
```

## ✅ Fonctionnalités prévues

- [x] Intégration TailwindCSS + DaisyUI
- [x] API test fonctionnelle (`/api/test`)
- [x] Proxy API entre Vue & Symfony via Vite
- [x] Hot reload fonctionnel en container
- [ ] CRUD enfants, présences, utilisateurs
- [ ] Authentification par rôle
- [ ] Dashboard avec statistiques

## 🧠 Inspirations & Ressources

- [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html)
- [Vue 3 Composition API](https://vuejs.org/guide/introduction.html)
- [DaisyUI Docs](https://daisyui.com/)
- [Tailwind UI Concepts](https://tailwindcss.com/docs)

## 💡 Notes

Ce projet est conçu comme un **exercice de mise en pratique** fullstack dans un environnement dockerisé, combinant API Symfony + SPA Vue.js.

⚡ _Un outil simple, élégant et rapide pour les structures d’accueil._
