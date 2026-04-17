import 'package:flutter/foundation.dart';

import '../models/product.dart';

class CartController extends ChangeNotifier {
  final Map<int, CartLine> _lines = {};

  List<CartLine> get lines => _lines.values.toList(growable: false);

  int get itemCount {
    return _lines.values.fold(0, (total, line) => total + line.quantity);
  }

  double get subtotal {
    return _lines.values.fold(
      0,
      (total, line) => total + line.product.price * line.quantity,
    );
  }

  void add(Product product) {
    final current = _lines[product.id];
    _lines[product.id] = CartLine(
      product: product,
      quantity: current == null ? 1 : current.quantity + 1,
    );
    notifyListeners();
  }

  void remove(Product product) {
    final current = _lines[product.id];
    if (current == null) {
      return;
    }

    if (current.quantity == 1) {
      _lines.remove(product.id);
    } else {
      _lines[product.id] = CartLine(
        product: product,
        quantity: current.quantity - 1,
      );
    }
    notifyListeners();
  }

  void clear() {
    _lines.clear();
    notifyListeners();
  }
}

class CartLine {
  const CartLine({
    required this.product,
    required this.quantity,
  });

  final Product product;
  final int quantity;
}
