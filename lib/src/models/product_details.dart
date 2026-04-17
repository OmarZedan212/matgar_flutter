import 'product.dart';

class ProductDetails {
  const ProductDetails({
    required this.product,
    required this.relatedProducts,
  });

  final Product product;
  final List<Product> relatedProducts;

  factory ProductDetails.fromJson(Map<String, dynamic> json) {
    final related = json['related'] as List<dynamic>? ?? const [];

    return ProductDetails(
      product: Product.fromJson(json['data'] as Map<String, dynamic>),
      relatedProducts: related
          .whereType<Map<String, dynamic>>()
          .map(Product.fromJson)
          .toList(growable: false),
    );
  }
}
