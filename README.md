# 🎬 MovieDB Application 🎥

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white)
![TMDB](https://img.shields.io/badge/Powered_by-TMDB-01D277?logo=themoviedatabase&logoColor=white)

This project is a movie database application that allows users to explore popular movies, manage watchlists, create playlists, and interact with other users through reviews and profiles.

![1](https://github.com/user-attachments/assets/064b63e3-7aff-4d76-831a-141b699e9930)

![2](https://github.com/user-attachments/assets/56c8859a-6387-48c8-a3a7-4de18de95a9a)

## ✨ Features
### 1. **🎥 Movie Browsing**
- Browse popular movies, top-rated, now playing, and upcoming movies.
- Filter movies by genre, release year, and sort by rating or release date.

### 2. **📝 Watchlist Management**
- Add movies to your watchlist to keep track of what you want to watch.
- Remove movies from your watchlist when no longer needed.

### 3. **👀 Watched Movies**
- Mark movies as watched or unwatched to track your viewing history.

### 4. **🎵 Playlists**
- Create custom playlists and add movies to them.
- Remove movies from playlists or delete playlists entirely.

### 5. **📝 User Reviews**
- Write reviews for movies and rate them.
- View reviews from other users.

### 6. **👤 User Profiles**
- View your private profile with personalized data like followers, following, and activity.
- View public profiles of other users.

### 7. **🔍 Search**
- Search for movies by title and filter results by genre or release year.

---

# 🛠️ Project Setup Instructions

## 📋 Prerequisites
Before setting up the project, ensure you have the following installed:
- PHP >= 8.0
- Composer
- Node.js and npm
- MySQL or any other database supported by Laravel

## 🚀 Steps to Set Up the Project

### 1. **📥 Clone the Repository**
```bash
git clone https://github.com/shane-smyth/laravel_ca3.git
cd <repository-folder>
```

### 2. **📦 Install Dependencies**
```
composer install 
npm instal
```

### 3. **⚙️ Set Up Environment Variables**
- Copy the `.env.example` file to `.env`:
- Update the `.env` file with your database credentials and other required configurations.

```
cp .env.example .env
```

### 4. **🗄️ Run Database Migrations**
```
php artisan migrate
```

### 5. **🔗 Link Storage**
```
php artisan storage:link
```

### 6. **🎞️ Fetch Popular Movies**
```
php artisan tmdb:fetch-popular 50
```

### 7. **🚀 Start the Development Server**
```
php artisan serve 
npm run dev
```

### 8. **🌐 Access the Application**
- Open your browser and navigate to `http://127.0.0.1:8000`.
