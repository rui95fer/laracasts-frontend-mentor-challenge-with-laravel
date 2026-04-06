# Frontend Mentor Challenge with Laravel — Laracasts Course Notes

---

## Episode 1 — Kickoff and Challenge Files

- **Frontend Mentor provides a style guide — map it directly to your Tailwind theme config.**
  ```js
  // tailwind.config.js
  colors: {
    'red': '#C73B0F',
    'rose-50': '#FCF8F6',
  },
  fontFamily: {
    sans: ['Red Hat Text', 'sans-serif'],
  }
  ```

- **The challenge's `data.json` becomes your database seed, not static data.**
  ```php
  // database/seeders/ProductSeeder.php
  $data = json_decode(file_get_contents(base_path('data.json')), true);
  foreach ($data as $item) {
      Product::create([
          'name'     => $item['name'],
          'category' => $item['category'],
          'price'    => $item['price'],
      ]);
  }
  ```

- **Start Laravel with no starter kit for full control.**
  ```bash
  laravel new dessert-shop
  # Select: No starter kit
  ```

---

## Episode 2 — Laravel New

- **Create a fresh Laravel app with no starter kit, SQLite for the database.**
  ```bash
  laravel new desserts
  # Starter kit: None
  # Database: SQLite
  composer dev
  ```

- **Collocate your seed data with your database seeders.**
  ```
  database/
  └── seeders/
      ├── DatabaseSeeder.php
      └── data.json  ← move challenge data.json here
  ```

- **Place challenge images inside `resources/` so Laravel and Vite can manage them.**
  ```
  resources/
  └── images/  ← drop challenge images here
  ```

- **Strip the default welcome view down to a clean shell with Vite directives.**
  ```html
  <!-- resources/views/welcome.blade.php -->
  <head>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
      <h1>Frontend Mentor Challenge with Laravel</h1>
  </body>
  ```

- **Use Google Fonts instead of loading local font files — less setup, same result.**
  ```html
  <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text&display=swap" rel="stylesheet">
  ```

- **Use the HTML `popover` attribute for modals — no JavaScript or component library needed.**
  ```html
  <div popover id="order-modal">
      <p>Your order is confirmed!</p>
  </div>
  <button popovertarget="order-modal">Confirm Order</button>
  ```
