import 'package:flutter/material.dart';

import 'screens/account_screen.dart';
import 'screens/cart_screen.dart';
import 'screens/home_screen.dart';
import 'screens/orders_screen.dart';
import 'services/api_client.dart';
import 'services/auth_service.dart';
import 'services/cart_service.dart';
import 'services/order_service.dart';
import 'services/product_service.dart';
import 'state/cart_controller.dart';
import 'state/session_controller.dart';

class MatgarApp extends StatefulWidget {
  const MatgarApp({super.key});

  @override
  State<MatgarApp> createState() => _MatgarAppState();
}

class _MatgarAppState extends State<MatgarApp> {
  late final ApiClient apiClient = ApiClient();
  late final ProductService productService = ProductService(apiClient);
  late final AuthService authService = AuthService(apiClient);
  late final CartService cartService = CartService(apiClient);
  late final OrderService orderService = OrderService(apiClient);
  late final SessionController session = SessionController(
    apiClient: apiClient,
    authService: authService,
  );
  late final CartController cart = CartController(
    cartService: cartService,
    session: session,
  );

  @override
  void dispose() {
    apiClient.close();
    session.dispose();
    cart.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    const primary = Color(0xff3b82f6);
    const background = Color(0xfff4f9fc);
    const black = Color(0xff000000);

    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Matgar',
      theme: ThemeData(
        useMaterial3: true,
        colorScheme: ColorScheme.fromSeed(
          seedColor: primary,
          brightness: Brightness.light,
        ).copyWith(
          primary: primary,
          onPrimary: Colors.white,
          surface: Colors.white,
          onSurface: black,
          primaryContainer: background,
          onPrimaryContainer: black,
        ),
        scaffoldBackgroundColor: background,
        appBarTheme: const AppBarTheme(
          centerTitle: false,
          backgroundColor: background,
          foregroundColor: black,
        ),
        navigationBarTheme: NavigationBarThemeData(
          backgroundColor: Colors.white,
          indicatorColor: primary.withOpacity(0.12),
        ),
        cardTheme: CardThemeData(
          color: Colors.white,
          elevation: 0,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(8),
            side: BorderSide(color: primary.withOpacity(0.12)),
          ),
        ),
      ),
      home: MatgarShell(
        cart: cart,
        productService: productService,
        orderService: orderService,
        session: session,
      ),
    );
  }
}

class MatgarShell extends StatefulWidget {
  const MatgarShell({
    super.key,
    required this.cart,
    required this.productService,
    required this.orderService,
    required this.session,
  });

  final CartController cart;
  final ProductService productService;
  final OrderService orderService;
  final SessionController session;

  @override
  State<MatgarShell> createState() => _MatgarShellState();
}

class _MatgarShellState extends State<MatgarShell> {
  int selectedIndex = 0;

  @override
  Widget build(BuildContext context) {
    final pages = [
      HomeScreen(
        productService: widget.productService,
        cart: widget.cart,
      ),
      CartScreen(cart: widget.cart),
      OrdersScreen(
        orderService: widget.orderService,
        session: widget.session,
      ),
      AccountScreen(session: widget.session),
    ];

    return ListenableBuilder(
      listenable: widget.cart,
      builder: (context, _) {
        return Scaffold(
          body: SafeArea(child: pages[selectedIndex]),
          bottomNavigationBar: NavigationBar(
            selectedIndex: selectedIndex,
            onDestinationSelected: (index) {
              setState(() => selectedIndex = index);
            },
            destinations: [
              const NavigationDestination(
                icon: Icon(Icons.storefront_outlined),
                selectedIcon: Icon(Icons.storefront),
                label: 'Shop',
              ),
              NavigationDestination(
                icon: Badge.count(
                  count: widget.cart.itemCount,
                  isLabelVisible: widget.cart.itemCount > 0,
                  child: const Icon(Icons.shopping_bag_outlined),
                ),
                selectedIcon: Badge.count(
                  count: widget.cart.itemCount,
                  isLabelVisible: widget.cart.itemCount > 0,
                  child: const Icon(Icons.shopping_bag),
                ),
                label: 'Cart',
              ),
              const NavigationDestination(
                icon: Icon(Icons.receipt_long_outlined),
                selectedIcon: Icon(Icons.receipt_long),
                label: 'Orders',
              ),
              const NavigationDestination(
                icon: Icon(Icons.person_outline),
                selectedIcon: Icon(Icons.person),
                label: 'Account',
              ),
            ],
          ),
        );
      },
    );
  }
}
