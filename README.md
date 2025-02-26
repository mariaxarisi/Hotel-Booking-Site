# Hotel Booking Site

A full-featured hotel booking website that lets users browse and book hotels, add them to their favorites, comment on room pages, and manage their profiles.

## 🌐 Live Preview

You can preview the static version of the website using the links below:

- [Home Page](https://mariaxarisi.github.io/Hotel-Booking/)
- [Hotel List Page](https://mariaxarisi.github.io/Hotel-Booking/list.html)
- [Room Page](https://mariaxarisi.github.io/Hotel-Booking/room.html)
- [Profile Page](https://mariaxarisi.github.io/Hotel-Booking/profile.html)

---

## 🚀 Installation & Setup

### 1️⃣ Clone the Repository

```
git clone https://github.com/yourusername/Hotel-Booking-Site.git
cd Hotel-Booking-Site
```
### 2️⃣ Set Up Enviroment variables

Create a .env file in the root directory with the following content:

```
MYSQL_ROOT_PASSWORD=root_password
DB_HOST=db
DB_NAME=hotel_db
DB_USER=hotel_user
DB_PASSWORD=user_password
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```
> **Note:** Google Maps API key is optional. Without it, just maps won't be displayed.
### 3️⃣ Run with Docker

Ensure you have Docker and Docker Compose installed, then run:

```
docker-compose build
docker-compose up
```
### 4️⃣ Access the Website & Database

- To visit the **Hotel Booking Site**, open your browser and go to:  
  👉 [http://localhost](http://localhost)

- To check the **database using phpMyAdmin**, visit:  
  👉 [http://localhost:8080](http://localhost:8080)

---

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Deployment:** Docker, Docker Compose  
- **API Integrations:** Google Maps API