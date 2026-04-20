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

---

## Episode 9 — Empty Cart UI

- **Organise related Blade components into subfolders for clarity.**
  ```
  resources/views/components/cart/
  ├── index.blade.php        ← cart wrapper (shared heading)
  ├── empty.blade.php        ← empty state UI
  └── empty-illustration.blade.php  ← inline SVG
  ```
  ```blade
  {{-- cart/index.blade.php --}}
  <div class="bg-white rounded-xl p-6">
      <h2 class="text-red font-bold text-2xl">Your Cart (0)</h2>
      <x-cart.empty />
  </div>
  ```

- **Use inline SVGs as Blade components instead of `<img>` tags — easier to style with CSS.**
  ```blade
  {{-- cart/empty-illustration.blade.php --}}
  <svg ...>...</svg> {{-- paste SVG code directly --}}
  ```
  ```blade
  <x-cart.empty-illustration />
  ```

- **Wrap a sidebar in a plain `<div>` so its background doesn't stretch to fill the grid row.**
  ```blade
  {{-- welcome.blade.php --}}
  <div> {{-- wrapper stops the aside stretching full height --}}
      <aside>
          <x-cart.index />
      </aside>
  </div>
  ```

- **Build empty and populated states as separate components, then toggle between them with a conditional.**
  ```blade
  {{-- cart/index.blade.php --}}
  @if ($cart->isEmpty())
      <x-cart.empty />
  @else
      <x-cart.items :cart="$cart" />
  @endif
  ```

---

## Episode 10 — Cart and Cart Item Models

- **Use session ID instead of user auth to identify a cart — no login required.**
  ```php
  // carts table migration
  $table->string('session_id');
  ```

- **Use `foreignIdFor()` with `cascadeOnDelete()` to set up constrained foreign keys.**
  ```php
  // cart_items table migration
  $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
  $table->foreignIdFor(Cart::class)->constrained()->cascadeOnDelete();
  $table->unsignedInteger('quantity');
  ```

- **Add a unique constraint to prevent duplicate product+cart pairs.**
  ```php
  $table->unique(['product_id', 'cart_id']);
  ```

- **Define Eloquent relationships on both sides of the association.**
  ```php
  // app/Models/Cart.php
  public function items()
  {
      return $this->hasMany(CartItem::class);
  }

  // app/Models/CartItem.php
  public function cart()
  {
      return $this->belongsTo(Cart::class);
  }

  public function product()
  {
      return $this->belongsTo(Product::class);
  }
  ```

- **Eager load relationships to avoid N+1 queries when iterating cart items.**
  ```php
  // routes/web.php
  $cart = Cart::with('items.product')->first();
  ```
  ```blade
  @foreach ($cart->items as $item)
      <p>{{ $item->product->name }} x{{ $item->quantity }}</p>
  @endforeach
  ```

---

## Episode 11 — Session-Based Carts

- **Look up a cart by session ID using a static model method with eager loading.**
  ```php
  // app/Models/Cart.php
  public static function ifExists(): ?Cart
  {
      return static::with('items.product')
          ->where('session_id', session()->getId())
          ->first();
  }
  ```
  ```php
  // routes/web.php
  $cart = Cart::ifExists();
  ```

- **Never create a cart on page load — only create one when the first item is added.**
  ```php
  // Bad: creates a junk cart for every visitor
  $cart = Cart::firstOrCreate(['session_id' => session()->getId()]);

  // Good: two separate concerns
  $cart = Cart::ifExists();           // for rendering the UI
  $cart = Cart::ensureExists();       // only called when adding to cart
  ```

- **Guard against a null cart in the view before iterating its items.**
  ```blade
  @if ($cart)
      @foreach ($cart->items as $item)
          <p>{{ $item->product->name }} x{{ $item->quantity }}</p>
      @endforeach
  @endif
  ```

- **Each browser session gets its own isolated cart — test with incognito to verify.**
  ```php
  // Two visitors = two different session()->getId() values = two separate carts
  session()->getId(); // e.g. "abc123" in normal window
  session()->getId(); // e.g. "xyz789" in incognito window
  ```

---

## Episode 12 — Ensure Cart Exists

- **Use `firstOrCreate` to implement `ensureExists` — finds or creates a cart by session ID.**
  ```php
  // app/Models/Cart.php
  public static function ensureExists(): Cart
  {
      return static::firstOrCreate(['session_id' => session()->getId()]);
  }
  ```

- **Create a dedicated controller for all cart operations instead of putting logic in `web.php`.**
  ```bash
  php artisan make:controller CartController
  ```
  ```php
  // routes/web.php
  Route::post('/cart/{product}', [CartController::class, 'addOne'])->name('cart.addOne');
  ```

- **Use Ziggy's `route()` helper in Blade to reference named routes in form actions.**
  ```blade
  <form method="POST" action="{{ route('cart.addOne', $product) }}">
      @csrf
      <button type="submit">Add to Cart</button>
  </form>
  ```

- **Add model properties to `$fillable` to prevent mass assignment exceptions.**
  ```php
  // app/Models/Cart.php
  protected $fillable = ['session_id'];
  ```

- **Call `ensureExists` at the start of any cart write operation, not on page load.**
  ```php
  // app/Http/Controllers/CartController.php
  public function addOne(Product $product): RedirectResponse
  {
      $cart = Cart::ensureExists(); // creates cart only if it doesn't exist yet
      // ... add item to cart
  }
  ```

---

## Episode 13 — Add to Cart

- **Push cart logic into the Cart model, keeping the controller thin.**
  ```php
  // app/Http/Controllers/CartController.php
  public function addOne(Product $product): RedirectResponse
  {
      $cart = Cart::ensureExists();
      $cart->incrementItem($product);
      return back();
  }
  ```

- **Use `firstOrCreate` on a relationship to either find or create a cart item, then increment.**
  ```php
  // app/Models/Cart.php
  public function incrementItem(Product $product): void
  {
      $item = $this->items()->firstOrCreate(
          ['product_id' => $product->id], // find by this
          ['quantity'   => 0]             // create with this if not found
      );

      $item->increment('quantity');
  }
  ```

- **Add all mass-assignable fields to `$fillable` on the CartItem model.**
  ```php
  // app/Models/CartItem.php
  protected $fillable = ['product_id', 'quantity'];
  ```

---

## Episode 14 — Pruning Abandoned Carts

- **Use the `MassPrunable` trait to automatically delete stale carts based on `updated_at`.**
  ```php
  // app/Models/Cart.php
  use Illuminate\Database\Eloquent\MassPrunable;

  class Cart extends Model
  {
      use MassPrunable;

      public function prunable(): Builder
      {
          return static::where('updated_at', '<=', now()->subHours(2));
      }
  }
  ```

- **Test pruning safely with the `--pretend` flag before actually deleting anything.**
  ```bash
  php artisan model:prune --pretend  # shows what would be deleted
  php artisan model:prune            # actually deletes
  ```

- **Schedule the prune command to run automatically in `routes/console.php`.**
  ```php
  // routes/console.php
  use Illuminate\Support\Facades\Schedule;

  Schedule::command('model:prune')->daily();
  ```

- **Use `$touches` on CartItem to automatically refresh the parent Cart's `updated_at` on every interaction — resetting the expiry window.**
  ```php
  // app/Models/CartItem.php
  protected $touches = ['cart'];
  ```

---

## Episode 15 — Total Cart Quantity

- **Add a `totalQuantity()` helper on the Cart model to sum all item quantities.**
  ```php
  // app/Models/Cart.php
  public function totalQuantity(): int
  {
      return $this->items->sum('quantity');
  }
  ```

- **Pass the cart as a prop to the cart Blade component.**
  ```blade
  {{-- welcome.blade.php --}}
  <x-cart.index :cart="$cart" />
  ```
  ```blade
  {{-- cart/index.blade.php --}}
  @props(['cart'])
  <h2>Your Cart ({{ $cart?->totalQuantity() ?? 0 }})</h2>
  ```

- **Toggle between empty and active cart states using `totalQuantity`.**
  ```blade
  {{-- cart/index.blade.php --}}
  @if ($cart && $cart->totalQuantity() > 0)
      <x-cart.active :cart="$cart" />
  @else
      <x-cart.empty />
  @endif
  ```

---

## Episode 16 — Active Cart UI

- **Add a `formattedTotal()` helper on CartItem to keep price calculation out of the template.**
  ```php
  // app/Models/CartItem.php
  public function formattedTotal(): string
  {
      return Number::currency($this->quantity * $this->product->price_cents / 100, 'USD');
  }
  ```
  ```blade
  <span>{{ $item->formattedTotal() }}</span>
  ```

- **Use `$attributes->merge()` on SVG components to allow passing Tailwind classes from outside.**
  ```blade
  {{-- resources/views/components/icons/delete.blade.php --}}
  <svg {{ $attributes->merge(['class' => '']) }} fill="currentColor" ...>
      ...
  </svg>
  ```
  ```blade
  {{-- Usage: control size and color from the parent --}}
  <x-icons.delete class="size-2.5 text-rose-500 hover:text-red" />
  ```

- **Add a circular border to a button wrapping an SVG icon, not to the SVG itself.**
  ```blade
  <button class="border border-rose-500 rounded-full p-1 items-center">
      <x-icons.delete class="size-2.5 text-rose-500" />
  </button>
  ```

- **Use `justify-between` + `items-center` on a flex `<li>` to push content and the delete button to opposite ends.**
  ```blade
  <li class="flex justify-between items-center border-b border-rose-100 py-4">
      <div><!-- name, quantity, price --></div>
      <button><!-- delete icon --></button>
  </li>
  ```

---

## Episode 17 — Cart UI Continued

- **Guard against null cart in all places with the null-safe operator and a fallback.**
  ```blade
  {{-- Prevent crash when cart has been pruned --}}
  <h2>Your Cart ({{ $cart?->totalItemsCount() ?? 0 }})</h2>

  @if ($cart && $cart->totalItemsCount() > 0)
      <x-cart.active :cart="$cart" />
  @else
      <x-cart.empty />
  @endif
  ```

- **Add a `formattedTotal()` method on the Cart model to sum all line item totals.**
  ```php
  // app/Models/Cart.php
  public function formattedTotal(): string
  {
      $total = $this->items->sum(fn ($item) => $item->product->price_cents * $item->quantity);
      return Number::currency($total / 100, 'USD');
  }
  ```

- **Wrap cart sections in a `flex flex-col` container to control spacing with `gap`.**
  ```blade
  <div class="flex flex-col gap-8">
      <ul><!-- cart items --></ul>
      <div><!-- order total --></div>
      <div><!-- callout banner --></div>
      <button><!-- confirm order --></button>
  </div>
  ```

- **Build the carbon-neutral callout as a flex row with an inline SVG icon.**
  ```blade
  <div class="flex justify-center items-center gap-2 bg-rose-50 rounded-lg py-4">
      <x-icons.tree class="text-green" />
      <p>This is a <span class="font-bold">carbon-neutral</span> delivery</p>
  </div>
  ```

- **Style the confirm order button with full rounding and generous padding.**
  ```blade
  <button class="w-full bg-red text-white rounded-full px-6 py-4">
      Confirm Order
  </button>
  ```

---

## Episode 18 — Increment and Decrement UI

- **Add a `quantityOf()` method on Cart to check how many of a product are in the cart.**
  ```php
  // app/Models/Cart.php
  public function quantityOf(Product $product): int
  {
      return $this->items->firstWhere('product_id', $product->id)?->quantity ?? 0;
  }
  ```

- **Cache the result in a `@php` block when a value is used multiple times in a component.**
  ```blade
  @php $quantity = $cart?->quantityOf($product) ?? 0; @endphp

  @if ($quantity)
      {{-- increment/decrement UI --}}
  @else
      {{-- add to cart button --}}
  @endif
  ```

- **Pass the cart into the product component so it can check per-product quantities.**
  ```blade
  {{-- welcome.blade.php --}}
  <x-product :product="$product" :cart="$cart" />

  {{-- components/product.blade.php --}}
  @props(['product', 'cart'])
  ```

- **Use `-translate-y-1/2` to overlap a button onto the image — simpler than CSS variable calc.**
  ```blade
  {{-- Before (overcomplicated): --}}
  <form style="--button-height: 3rem" class="-mt-[calc(var(--button-height)/2)]">

  {{-- After (simple): --}}
  <div class="flex justify-center -translate-y-1/2">
      <button class="... py-3 rounded-full">...</button>
  </div>
  ```

- **Inline SVG icons directly in a button and control color with `currentColor`.**
  ```blade
  <button class="border-2 border-white rounded-full p-1">
      <svg class="size-2.5 text-white" fill="currentColor" ...>...</svg>
  </button>
  ```

---

## Episode 19 — Decrement and Delete Functionality

- **Reuse the existing `addOne` route and controller for the increment button — just wire up the form.**
  ```blade
  <form method="POST" action="{{ route('cart.addOne', $product) }}">
      @csrf
      <button type="submit">+</button>
  </form>
  ```

- **Use `ifExists()` (not `ensureExists()`) in the decrement controller — never create a cart just to remove from it.**
  ```php
  // app/Http/Controllers/CartController.php
  public function removeOne(Product $product): RedirectResponse
  {
      Cart::ifExists()?->decrementItem($product);
      return back();
  }
  ```

- **Decrement quantity by one, but delete the cart item entirely when quantity reaches zero.**
  ```php
  // app/Models/Cart.php
  public function decrementItem(Product $product): void
  {
      $item = $this->items->firstWhere('product_id', $product->id);

      if (!$item) return;

      if ($item->quantity > 1) {
          $item->decrement('quantity');
      } else {
          $item->delete();
      }
  }
  ```

- **Use `@method('PATCH')` to send a PATCH request through an HTML form.**
  ```blade
  <form method="POST" action="{{ route('cart.removeOne', $product) }}">
      @csrf
      @method('PATCH')
      <button type="submit">-</button>
  </form>
  ```
  ```php
  // routes/web.php
  Route::patch('/cart/{product}', [CartController::class, 'removeOne'])->name('cart.removeOne');
  ```

---

## Episode 20 — Remove Cart Item Entirely

- **Add a dedicated DELETE route that targets a `CartItem` directly, not a `Product`.**
  ```php
  // routes/web.php
  Route::delete('/cart/{cartItem}', [CartController::class, 'removeAll'])->name('cart.removeAll');
  ```

- **Keep the controller action minimal — no need for a model method when it's a single delete.**
  ```php
  // app/Http/Controllers/CartController.php
  public function removeAll(CartItem $cartItem): RedirectResponse
  {
      $cartItem->delete();
      return back();
  }
  ```

- **Wrap the delete button in a form with `@method('DELETE')` to send the correct HTTP verb.**
  ```blade
  {{-- cart/active.blade.php --}}
  <form method="POST" action="{{ route('cart.removeAll', $item) }}">
      @csrf
      @method('DELETE')
      <button type="submit">
          <x-icons.delete class="size-3 text-rose-400" />
      </button>
  </form>
  ```

---

## Episode 21 — HTML Popover

- **Use the native HTML `popover` attribute to build a modal — no JavaScript needed.**
  ```html
  <!-- The popover panel (hidden by default) -->
  <div popover id="order-confirmation">
      I am a cool popover
  </div>

  <!-- The trigger button -->
  <button popovertarget="order-confirmation">Confirm Order</button>
  ```

- **The popover is placed in the browser's top layer — no z-index or portal tricks needed.**
  ```html
  <!-- The browser automatically places it above everything else,
       no need to move it to the end of <body> or fight z-index -->
  <div popover id="order-confirmation">...</div>
  ```

- **Center the popover with `mx-auto` — Tailwind's reset fights the browser's default centering.**
  ```html
  <div popover id="order-confirmation" class="mx-auto">
      ...
  </div>
  ```

- **Style the backdrop with Tailwind's `backdrop:` variant — add blur for a polished effect.**
  ```css
  /* app.css — restore black so backdrop color works */
  @theme {
    --color-black: hsl(0 0% 0%);
  }
  ```
  ```html
  <div popover class="backdrop:bg-black/50 backdrop:backdrop-blur-sm">
      ...
  </div>
  ```

---

## Episode 22 — Modal Enter and Leave Transitions

- **Use `@starting-style` with `transition` to animate a popover on enter and leave.**
  ```html
  <div popover
      class="
          transition duration-200 transition-discrete
          opacity-100 translate-y-0
          starting:open:opacity-0 starting:open:scale-95
          open:opacity-100
      ">
  </div>
  ```

- **Use `open:` prefix to define styles while the popover is visible.**
  ```html
  <!-- open: = styles applied while popover is showing -->
  <!-- starting:open: = styles applied at the very start of the enter transition -->
  <div popover class="open:opacity-100 starting:open:opacity-0">
  ```

- **Add `transition-discrete` to enable transitions on `display` changes (block ↔ none).**
  ```html
  <div popover class="transition transition-discrete duration-200 ...">
  ```

- **Animate the backdrop separately using `backdrop:` with explicit transition properties.**
  ```html
  <div popover class="
      open:backdrop:opacity-100
      starting:open:backdrop:opacity-0
      backdrop:bg-black/50
      backdrop:[transition-property:opacity,display]
      backdrop:transition-discrete
      backdrop:duration-200
  ">
  ```

- **Set the popover wrapper to `bg-transparent` so inner `rounded` corners aren't clipped.**
  ```html
  <!-- Outer popover: transparent, handles transitions -->
  <div popover class="bg-transparent mx-auto ...">
      <!-- Inner container: white background with rounded corners -->
      <div class="bg-white rounded-lg p-8 max-w-full w-120">
          ...
      </div>
  </div>
  ```
