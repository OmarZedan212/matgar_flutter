class Product {
  const Product({
    required this.id,
    required this.name,
    required this.category,
    required this.price,
    required this.description,
    required this.imageUrl,
    this.isFeatured = false,
    this.oldPrice,
    this.rating = 0,
    this.quantity = 0,
    this.badge,
  });

  final int id;
  final String name;
  final String category;
  final double price;
  final String description;
  final String? imageUrl;
  final bool isFeatured;
  final double? oldPrice;
  final int rating;
  final int quantity;
  final String? badge;

  factory Product.fromJson(Map<String, dynamic> json) {
    final categoryJson = json['category'];
    final categoryName = categoryJson is Map<String, dynamic>
        ? categoryJson['name'] as String? ?? 'General'
        : json['category'] as String? ?? 'General';
    final badge = json['badge'] as String?;

    return Product(
      id: json['id'] as int,
      name: json['name'] as String,
      category: categoryName,
      price: (json['price'] as num).toDouble(),
      description: json['description'] as String? ?? '',
      imageUrl: json['image_url'] as String? ?? '',
      isFeatured: json['is_featured'] as bool? ?? badge != null,
      oldPrice: (json['old_price'] as num?)?.toDouble(),
      rating: json['rating'] as int? ?? 0,
      quantity: json['quantity'] as int? ?? 0,
      badge: badge,
    );
  }
}
