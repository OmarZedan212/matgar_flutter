# Matgar

Matgar is a Flutter app starter for a Laravel e-commerce website. It includes a shop tab, product cards, cart state, checkout placeholder, account placeholder, and a small API config file for connecting to your Laravel backend.

## Run

```sh
flutter pub get
flutter run
```

## Laravel API

Set your backend URL at build time. The Flutter app expects the mobile API routes under `/api/mobile`.

```sh
flutter run --dart-define=LARAVEL_API_BASE_URL=https://your-domain.com/api/mobile
```

The default API config lives in `lib/src/config/api_config.dart`.

For an Android emulator pointed at a local Laravel server, the starter default is:

```sh
http://127.0.0.1:8000/api/mobile
```

## Starter Structure

- `lib/main.dart` starts the app.
- `lib/src/app.dart` contains the Material app, theme, and bottom navigation.
- `lib/src/screens` contains shop, cart, and account screens.
- `lib/src/models` contains app models such as `Product`.
- `lib/src/state` contains simple local state such as the cart controller.
- `lib/src/data` contains temporary sample products until the Laravel API is connected.

## Next Steps

- Replace sample products with calls to Laravel product endpoints.
- Add authentication with Laravel Sanctum or Passport.
- Connect checkout to your order and payment flow.
- Add product details, categories, search, and customer order history.
