import '../models/product.dart';
import 'api_client.dart';

class ProductService {
  const ProductService(this._client);

  final ApiClient _client;

  Future<List<Product>> fetchProducts({String? search}) async {
    final response = await _client.get(
      '/products',
      queryParameters: {
        'per_page': '30',
        if (search != null && search.trim().isNotEmpty) 'search': search.trim(),
      },
    );

    final data = response is Map<String, dynamic>
        ? response['data'] as List<dynamic>? ?? const []
        : const [];

    return data
        .whereType<Map<String, dynamic>>()
        .map(Product.fromJson)
        .toList(growable: false);
  }
}
