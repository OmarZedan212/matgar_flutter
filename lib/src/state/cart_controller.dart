import 'package:flutter/foundation.dart';

import '../models/product.dart';
import '../models/app_user.dart';
import '../services/api_client.dart';
import '../services/cart_service.dart';
import 'session_controller.dart';

class CartController extends ChangeNotifier {
  CartController({
    required CartService cartService,
    required SessionController session,
  })  : _cartService = cartService,
        _session = session {
    _wasSignedIn = _session.isSignedIn;
    _session.addListener(_handleSessionChanged);
    if (_wasSignedIn) {
      load();
    }
  }

  final CartService _cartService;
  final SessionController _session;
  var _lines = <CartLine>[];
  bool _wasSignedIn = false;

  bool isLoading = false;
  String? errorMessage;
  String? successMessage;

  List<CartLine> get lines => List.unmodifiable(_lines);
  bool get isSignedIn => _session.isSignedIn;
  AppUser? get user => _session.user;

  int get itemCount {
    return _lines.fold(0, (total, line) => total + line.quantity);
  }

  double get subtotal {
    return _lines.fold(0, (total, line) => total + line.lineTotal);
  }

  @override
  void dispose() {
    _session.removeListener(_handleSessionChanged);
    super.dispose();
  }

  Future<void> load() async {
    if (!isSignedIn) {
      _lines = [];
      notifyListeners();
      return;
    }

    await _runCartRequest(() async {
      final response = await _cartService.fetchCart();
      _applyCartPayload(response);
    });
  }

  Future<bool> add(Product product) async {
    if (!_ensureSignedIn()) {
      return false;
    }

    return _runCartRequest(() async {
      final response = await _cartService.addProduct(product.id);
      _applyCartPayload(response);
      successMessage = 'Added to cart.';
    });
  }

  Future<bool> increase(CartLine line) async {
    return updateQuantity(line, line.quantity + 1);
  }

  Future<bool> decrease(CartLine line) async {
    return updateQuantity(line, line.quantity - 1);
  }

  Future<bool> updateQuantity(CartLine line, int quantity) async {
    if (!_ensureSignedIn()) {
      return false;
    }

    return _runCartRequest(() async {
      final response = quantity <= 0
          ? await _cartService.removeItem(line.id)
          : await _cartService.updateItem(line.id, quantity);
      _applyCartPayload(response);
    });
  }

  Future<bool> remove(CartLine line) async {
    if (!_ensureSignedIn()) {
      return false;
    }

    return _runCartRequest(() async {
      final response = await _cartService.removeItem(line.id);
      _applyCartPayload(response);
    });
  }

  Future<bool> clear() async {
    if (!_ensureSignedIn()) {
      return false;
    }

    return _runCartRequest(() async {
      for (final line in List<CartLine>.from(_lines)) {
        await _cartService.removeItem(line.id);
      }
      _lines = [];
    });
  }

  Future<bool> checkout({
    required String name,
    required String email,
    required String phone,
    required String address,
  }) async {
    if (!_ensureSignedIn()) {
      return false;
    }

    return _runCartRequest(() async {
      await _cartService.checkout(
        name: name,
        email: email,
        phone: phone,
        address: address,
      );
      _lines = [];
      successMessage = 'Order placed successfully.';
    });
  }

  void _handleSessionChanged() {
    final signedIn = _session.isSignedIn;

    if (signedIn && !_wasSignedIn) {
      _wasSignedIn = true;
      load();
      return;
    }

    if (!signedIn && _wasSignedIn) {
      _wasSignedIn = false;
      _lines = [];
      errorMessage = null;
      successMessage = null;
      notifyListeners();
    }
  }

  bool _ensureSignedIn() {
    if (isSignedIn) {
      return true;
    }

    errorMessage = 'Sign in first so your cart can be saved.';
    notifyListeners();
    return false;
  }

  Future<bool> _runCartRequest(Future<void> Function() action) async {
    isLoading = true;
    errorMessage = null;
    successMessage = null;
    notifyListeners();

    try {
      await action();
      return true;
    } on ApiException catch (error) {
      errorMessage = error.message;
      return false;
    } catch (_) {
      errorMessage = 'Could not reach the cart API.';
      return false;
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }

  void _applyCartPayload(Map<String, dynamic> payload) {
    final data = payload['data'] as List<dynamic>? ?? const [];

    _lines = data
        .whereType<Map<String, dynamic>>()
        .map(CartLine.fromJson)
        .where((line) => line.product != null)
        .toList(growable: false);
  }
}

class CartLine {
  const CartLine({
    required this.id,
    required this.productId,
    required this.quantity,
    required this.price,
    required this.product,
  });

  final int id;
  final int productId;
  final int quantity;
  final double price;
  final Product? product;

  double get lineTotal => price * quantity;

  factory CartLine.fromJson(Map<String, dynamic> json) {
    final productJson = json['product'];

    return CartLine(
      id: json['id'] as int,
      productId: json['product_id'] as int,
      quantity: json['quantity'] as int,
      price: (json['price'] as num).toDouble(),
      product: productJson is Map<String, dynamic>
          ? Product.fromJson(productJson)
          : null,
    );
  }
}
