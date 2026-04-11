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

---

## Episode 3 — Styleguide to Tailwind Conversion

- **Disable all default Tailwind colors to create a bespoke, design-specific color palette.**
  ```css
  /* resources/css/app.css */
  @theme {
    --color-*: initial;

    --color-red: #C73B0F;
    --color-green: #1EA575;
    --color-rose-50: #FCF8F6;
    --color-rose-100: #F5EDED;
    --color-rose-300: #CAAFA7;
    --color-rose-400: #AD8A85;
    --color-rose-500: #87635A;
    --color-rose-900: #260F08;
  }
  ```

- **Restrict font weights to only what the design needs.**
  ```css
  @theme {
    --font-weight-*: initial;

    --font-weight-regular: 400;
    --font-weight-medium: 600;
    --font-weight-bold: 700;
  }
  ```

- **Load custom fonts via Google Fonts instead of local files.**
  ```html
  <!-- resources/views/welcome.blade.php -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:wght@400;600;700&display=swap" rel="stylesheet">
  ```
  ```css
  /* resources/css/app.css */
  @theme {
    --font-family-sans: 'Red Hat Text', sans-serif;
  }
  ```

- **Build a visual color swatch page to verify your theme is working correctly.**
  ```html
  <div class="flex gap-4 p-8">
    <div class="size-24 rounded-lg bg-red"></div>
    <div class="size-24 rounded-lg bg-green"></div>
    <div class="size-24 rounded-lg bg-rose-50"></div>
    <div class="size-24 rounded-lg bg-rose-100"></div>
    <div class="size-24 rounded-lg bg-rose-300"></div>
    <div class="size-24 rounded-lg bg-rose-900"></div>
  </div>
  ```

---

## Episode 4 — Product Model and Migration

- **Generate a model, migration, and seeder in one command.**
  ```bash
  php artisan make:model Product --migration --seeder
  ```

- **Store prices in cents (integers) to avoid floating point issues.**
  ```php
  // database/migrations/xxxx_create_products_table.php
  $table->string('name');
  $table->string('category');
  $table->string('image');
  $table->unsignedInteger('price_cents'); // e.g. $6.50 → 650
  ```

- **Store only one image filename — construct the full path in the template instead.**
  ```php
  // Migration: just store the filename
  $table->string('image'); // e.g. "waffle.jpg"
  ```
  ```html
  <!-- Blade template: build the path where needed -->
  <img src="{{ asset('images/' . $product->image) }}" />
  ```

- **Seed data from a JSON file by parsing it inside the seeder.**
  ```php
  // database/seeders/ProductSeeder.php
  public function run(): void
  {
      $data = json_decode(file_get_contents(database_path('seeders/data.json')), true);

      foreach ($data as $item) {
          Product::create([
              'name'        => $item['name'],
              'category'    => $item['category'],
              'image'       => basename($item['image']['mobile']),
              'price_cents' => $item['price'] * 100,
          ]);
      }
  }
  ```
  ```bash
  php artisan migrate
  php artisan db:seed --class=ProductSeeder
  ```

---

## Episode 5 — Data Seeding

- **Use the `File` facade with `database_path()` to read JSON from inside the `database/` directory.**
  ```php
  $data = json_decode(File::get(database_path('seeders/data.json')), true);
  ```

- **Call specific seeders from `DatabaseSeeder` so `migrate:fresh --seed` runs everything.**
  ```php
  // database/seeders/DatabaseSeeder.php
  public function run(): void
  {
      $this->call(ProductSeeder::class);
  }
  ```
  ```bash
  php artisan migrate:fresh --seed
  ```

- **Strip the folder path from image filenames using `str_replace` before saving.**
  ```php
  'image' => str_replace('./assets/images/', '', $item['image']['mobile']),
  // "./assets/images/waffle.jpg" → "waffle.jpg"
  ```

- **Pass all products to a view directly from the route for small datasets.**
  ```php
  // routes/web.php
  Route::get('/', fn () => view('welcome', ['products' => Product::all()]));
  ```

- **Validate data reaches the frontend with a quick `@foreach` before building the UI.**
  ```blade
  {{-- resources/views/welcome.blade.php --}}
  @foreach ($products as $product)
      <p>{{ $product->name }}</p>
  @endforeach
  ```

---

## Episode 6 — Layout and Product Grid

- **Use Tailwind 4's arbitrary max-width values and the spacing scale (divide px by 4) for containers.**
  ```html
  <body class="max-w-360 mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-rose-50">
  ```

- **Build a two-column layout with a fixed sidebar using arbitrary `grid-cols` values.**
  ```html
  <body class="grid md:grid-cols-[1fr_400px] gap-8">
      <main><!-- product grid --></main>
      <aside class="bg-white p-6"><!-- shopping cart --></aside>
  </body>
  ```

- **When you wipe all Tailwind colors, remember to manually restore `white`.**
  ```css
  /* resources/css/app.css */
  @theme {
    --color-white: hsl(0 0% 100%);
  }
  ```

- **Use progressive responsive grid columns to handle the layout at every breakpoint.**
  ```html
  <!-- Product grid: 1 col → 2 col → back to 1 (sidebar appears) → 2 → 3 -->
  <ul class="grid gap-4 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
      @foreach ($products as $product)
          <li class="bg-rose-100 aspect-square rounded-xl"></li>
      @endforeach
  </ul>
  ```

- **Design in the browser by applying placeholder colors and sizes first, then refine.**
  ```html
  <!-- Rough scaffold to validate layout before adding real content -->
  <li class="bg-rose-100 aspect-square rounded-xl"></li>
  ```

---

## Episode 7 — Product Component Semantic Markup

- **Extract repeating UI into a dedicated Blade component and pass data as props.**
  ```blade
  {{-- resources/views/components/product.blade.php --}}
  @props(['product'])

  <li>
      <article>
          <img src="{{ Vite::asset('resources/images/' . $product->image) }}" alt="Photo of {{ $product->name }}">
          <p>{{ $product->category }}</p>
          <h2>{{ $product->name }}</h2>
          <p>{{ $product->formattedPrice() }}</p>
      </article>
  </li>
  ```
  ```blade
  {{-- welcome.blade.php --}}
  @foreach ($products as $product)
      <x-product :product="$product" />
  @endforeach
  ```

- **Use `Vite::asset()` to reference images stored in `resources/`.**
  ```blade
  <img src="{{ Vite::asset('resources/images/' . $product->image) }}" />
  ```

- **Add a price formatting helper directly on the model instead of formatting in the view.**
  ```php
  // app/Models/Product.php
  public function formattedPrice(): string
  {
      return Number::currency($this->price_cents / 100, 'USD');
  }
  ```

- **Wrap the Add to Cart button in a `<form>` with CSRF protection from the start.**
  ```blade
  <form method="POST" action="/cart">
      @csrf
      {{-- TODO: add hidden product id input --}}
      <button type="submit">Add to Cart</button>
  </form>
  ```

---

## Episode 8 — Product Card Styling

- **Use `aspect-square` + `object-cover` to make images square without distortion.**
  ```html
  <img class="aspect-square object-cover rounded-xl" ... />
  ```

- **Center a button over the image boundary using a CSS variable + `calc` for robust negative margin.**
  ```html
  <form class="flex justify-center" style="--button-height: 3rem">
      <button class="h-(--button-height) -mt-[calc(var(--button-height)/2)] ...">
          Add to Cart
      </button>
  </form>
  ```

- **Store SVG icons as Blade components for inline reuse and CSS control.**
  ```
  resources/views/components/icons/add-to-cart.blade.php
  ```
  ```blade
  <button class="flex items-center gap-2">
      <x-icons.add-to-cart />
      <span>Add to Cart</span>
  </button>
  ```

- **Apply hover styles directly with Tailwind's `hover:` variant.**
  ```html
  <button class="border border-rose-500 hover:border-red hover:text-red ...">
  ```

- **Style text hierarchy with size, weight, and color — no extra wrappers needed.**
  ```html
  <p class="text-rose-500">{{ $product->category }}</p>
  <h2 class="text-lg font-medium">{{ $product->name }}</h2>
  <p class="text-red font-medium">{{ $product->formattedPrice() }}</p>
  ```
