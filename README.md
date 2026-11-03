# Books API

A simple REST API built with Laravel for retrieving, adding, updating and deleting books.

Student: DBjhane

## Setup

```
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

The API is then available at `http://127.0.0.1:8000/api`.

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/hello` | Welcome message |
| GET | `/api/books` | Retrieve all books |
| GET | `/api/books/{id}` | Retrieve one book |
| POST | `/api/books` | Add a new book |
| PUT | `/api/books/{id}` | Update a book |
| DELETE | `/api/books/{id}` | Delete a book |

Example body for `POST /api/books` (send `Accept: application/json` and `Content-Type: application/json`):

```json
{
  "title": "Learning Laravel",
  "author": "John Smith"
}
```

A book has `id`, `title`, `author`, `created_at` and `updated_at`. Validation errors return `422` and a missing book returns `404`, both as JSON.

## Challenge page

With the server running, open `http://127.0.0.1:8000/books.html` to list, add and delete books using `fetch()`.

## Tests

```
php artisan test
```

## Screenshots

Requests and responses (`Accept: application/json`) are in [screenshots/](screenshots):

| Step | Screenshot |
|------|------------|
| POST three books | `01-post-book-1.png`, `02-post-book-2.png`, `03-post-book-3.png` |
| GET all books | `04-get-all-books.png` |
| GET one book | `05-get-one-book.png` |
| PUT (update title) | `06-put-update-book.png` |
| DELETE | `07-delete-book.png` |
| GET a missing book (404) | `08-get-missing-book.png` |
| GET `/api/hello` | `09-get-hello.png` |

## Answers

1. **`routes/web.php` vs `routes/api.php`:** `web.php` serves browser pages and uses the `web` middleware group (sessions, cookies, CSRF protection). `api.php` is for stateless API endpoints, is prefixed with `/api`, and returns JSON without sessions or CSRF.
2. **GET vs POST:** GET retrieves data and sends parameters in the URL; it should not change anything on the server. POST sends data in the request body to create a resource, so it changes server state.
3. **Why JSON instead of HTML:** JSON is a lightweight, language-independent data format that any client (web, mobile, other servers) can parse easily. HTML mixes data with presentation, which other applications would have to scrape.
4. **Requesting a book ID that does not exist:** Laravel's route model binding fails and the API returns a `404 Not Found` response with a JSON message (for example `"No query results for model [App\\Models\\Book] 99."`).
5. **Mobile app usage:** A mobile app sends HTTP requests to the API URL (for example `GET /api/books` to show a list, `POST /api/books` to add one) and parses the JSON response to display it in its own UI.
