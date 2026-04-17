import 'product.dart';

class CustomerOrder {
  const CustomerOrder({
    required this.id,
    required this.status,
    required this.name,
    required this.email,
    required this.phone,
    required this.address,
    required this.total,
    required this.createdAt,
    this.items = const [],
  });

  final int id;
  final String status;
  final String name;
  final String email;
  final String phone;
  final String address;
  final double total;
  final DateTime? createdAt;
  final List<CustomerOrderItem> items;

  String get dateLabel {
    final date = createdAt;

    if (date == null) {
      return 'Unknown date';
    }

    final month = date.month.toString().padLeft(2, '0');
    final day = date.day.toString().padLeft(2, '0');

    return '${date.year}-$month-$day';
  }

  factory CustomerOrder.fromJson(Map<String, dynamic> json) {
    final items = json['items'] as List<dynamic>? ?? const [];

    return CustomerOrder(
      id: json['id'] as int,
      status: json['status'] as String? ?? 'Pending',
      name: json['name'] as String? ?? '',
      email: json['email'] as String? ?? '',
      phone: json['phone'] as String? ?? '',
      address: json['address'] as String? ?? '',
      total: (json['total'] as num?)?.toDouble() ?? 0,
      createdAt: DateTime.tryParse(json['created_at'] as String? ?? ''),
      items: items
          .whereType<Map<String, dynamic>>()
          .map(CustomerOrderItem.fromJson)
          .toList(growable: false),
    );
  }
}

class CustomerOrderItem {
  const CustomerOrderItem({
    required this.id,
    required this.productId,
    required this.quantity,
    required this.price,
    required this.lineTotal,
    this.product,
  });

  final int id;
  final int productId;
  final int quantity;
  final double price;
  final double lineTotal;
  final Product? product;

  factory CustomerOrderItem.fromJson(Map<String, dynamic> json) {
    final productJson = json['product'];

    return CustomerOrderItem(
      id: json['id'] as int,
      productId: json['product_id'] as int,
      quantity: json['quantity'] as int,
      price: (json['price'] as num?)?.toDouble() ?? 0,
      lineTotal: (json['line_total'] as num?)?.toDouble() ?? 0,
      product: productJson is Map<String, dynamic>
          ? Product.fromJson(productJson)
          : null,
    );
  }
}
