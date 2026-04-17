import 'api_client.dart';

class CartService {
  const CartService(this._client);

  final ApiClient _client;

  Future<Map<String, dynamic>> fetchCart() async {
    return await _client.get('/cart') as Map<String, dynamic>;
  }

  Future<Map<String, dynamic>> addProduct(int productId, {int quantity = 1}) async {
    return await _client.post('/cart', body: {
      'product_id': productId,
      'quantity': quantity,
    }) as Map<String, dynamic>;
  }

  Future<Map<String, dynamic>> updateItem(int cartId, int quantity) async {
    return await _client.put('/cart/$cartId', body: {
      'quantity': quantity,
    }) as Map<String, dynamic>;
  }

  Future<Map<String, dynamic>> removeItem(int cartId) async {
    return await _client.delete('/cart/$cartId') as Map<String, dynamic>;
  }

  Future<Map<String, dynamic>> checkout({
    required String name,
    required String email,
    required String phone,
    required String address,
  }) async {
    return await _client.post('/checkout', body: {
      'name': name,
      'email': email,
      'phone': phone,
      'address': address,
    }) as Map<String, dynamic>;
  }
}
